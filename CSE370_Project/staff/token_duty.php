<?php
include("../includes/auth_staff.php");
include("../db.php");

$staff_id = $_SESSION['user_id'];
$msg = "";

if (isset($_POST['cut_token'])) {
    $token_id = $_POST['token_id'];

    $stmt = $conn->prepare("
        UPDATE DailyMealToken
        SET status='Used', used_at=NOW(), used_by_staff_id=?
        WHERE token_id=? AND status='Collected'
    ");
    $stmt->bind_param("ii", $staff_id, $token_id);
    $stmt->execute();

    header("Location: token_duty.php?success=cut");
    exit();
}

if (isset($_POST['delete_token'])) {
    $token_id = $_POST['token_id'];

    $conn->query("
        DELETE FROM DailyMealToken
        WHERE token_id='$token_id'
        AND status='Used'
        AND used_by_staff_id='$staff_id'
    ");

    header("Location: token_duty.php?success=deleted");
    exit();
}

if (isset($_GET['success'])) {
    if ($_GET['success'] == "cut") {
        $msg = "Token cut successfully!";
    } elseif ($_GET['success'] == "deleted") {
        $msg = "Used token deleted successfully!";
    }
}

$duties = $conn->query("
SELECT * FROM TokenDuty
WHERE staff_id='$staff_id'
ORDER BY duty_date DESC, duty_id DESC
");

$tokens = $conn->query("
SELECT 
    t.token_id,
    t.user_id,
    si.name AS student_name,
    s.room_no,
    t.meal_type,
    t.token_date,
    t.status,
    t.collected_at,
    t.used_by_staff_id
FROM DailyMealToken t
JOIN Student_Info si ON t.user_id = si.user_id
JOIN Student s ON t.user_id = s.user_id
WHERE EXISTS (
    SELECT 1 FROM TokenDuty td
    WHERE td.staff_id='$staff_id'
    AND td.duty_date=t.token_date
    AND td.meal_type=t.meal_type
)
ORDER BY t.token_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Token Duty</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_staff.php"); ?>

<div class="container">
<h1 class="page-title">My Token Duties</h1>

<?php if($msg != "") { ?>
<div class="success"><?php echo $msg; ?></div>
<?php } ?>

<div class="meal-duty-list">
<?php while($d = $duties->fetch_assoc()) { ?>
    <div class="duty-card">
        <h3><?php echo $d['meal_type']; ?></h3>
        <p><b>Date:</b> <?php echo $d['duty_date']; ?></p>
        <p><b>Status:</b> <?php echo $d['status']; ?></p>
    </div>
<?php } ?>
</div>

<h1 class="page-title second-title">Student Tokens</h1>

<table>
<thead>
<tr>
<th>Token ID</th>
<th>Student</th>
<th>Room</th>
<th>Meal</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($t = $tokens->fetch_assoc()) { ?>
<tr>
<td><?php echo $t['token_id']; ?></td>
<td><?php echo $t['student_name']; ?></td>
<td><?php echo $t['room_no']; ?></td>
<td><?php echo $t['meal_type']; ?></td>
<td><?php echo $t['token_date']; ?></td>
<td><?php echo $t['status']; ?></td>
<td>
<?php if($t['status'] == "Collected") { ?>
    <form method="POST">
        <input type="hidden" name="token_id" value="<?php echo $t['token_id']; ?>">
        <button type="submit" name="cut_token">Cut Token</button>
    </form>
<?php } elseif($t['status'] == "Used" && $t['used_by_staff_id'] == $staff_id) { ?>
    <form method="POST" onsubmit="return confirm('Delete this used token?');">
        <input type="hidden" name="token_id" value="<?php echo $t['token_id']; ?>">
        <button type="submit" name="delete_token">Delete</button>
    </form>
<?php } else { ?>
    <span class="read-label">Done</span>
<?php } ?>
</td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</body>
</html>