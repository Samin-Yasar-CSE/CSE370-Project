<?php
include("../includes/auth_warden.php");
include("../db.php");

$warden_id = $_SESSION['user_id'];
$msg = "";

$res = $conn->query("SELECT COUNT(*) AS total FROM Complaint WHERE status='Pending'");
$row = $res->fetch_assoc();
$comp_count = $row['total'];

if (isset($_POST['assign_duty'])) {
    $staff_id = $_POST['staff_id'];
    $duty_date = $_POST['duty_date'];
    $meal_type = $_POST['meal_type'];

    $stmt = $conn->prepare("
        INSERT INTO TokenDuty (staff_id, duty_date, meal_type, assigned_by, status)
        VALUES (?, ?, ?, ?, 'Assigned')
    ");
    $stmt->bind_param("issi", $staff_id, $duty_date, $meal_type, $warden_id);
    $stmt->execute();

    header("Location: token_duty.php?success=assigned");
    exit();
}

if (isset($_GET['success'])) {
    $msg = "Token duty assigned successfully!";
}

$staffs = $conn->query("SELECT user_id, name FROM Staff ORDER BY name ASC");

$duties = $conn->query("
SELECT td.*, s.name AS staff_name
FROM TokenDuty td
JOIN Staff s ON td.staff_id = s.user_id
ORDER BY td.duty_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Token Duty</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
<h1 style="color:white;">Assign Meal Token Duty</h1>

<?php if($msg != "") { ?>
<div class="success"><?php echo $msg; ?></div>
<?php } ?>

<div class="card">
<form method="POST">
<label>Staff</label>
<select name="staff_id" required>
<option value="">-- Select Staff --</option>
<?php while($s = $staffs->fetch_assoc()) { ?>
<option value="<?php echo $s['user_id']; ?>"><?php echo $s['name']; ?></option>
<?php } ?>
</select>

<label>Duty Date</label>
<input type="date" name="duty_date" required>

<label>Meal Type</label>
<select name="meal_type" required>
<option>Breakfast</option>
<option>Morning Snacks</option>
<option>Lunch</option>
<option>Evening Snacks</option>
<option>Dinner</option>
</select>

<button type="submit" name="assign_duty">Assign Duty</button>
</form>
</div>

<h1 style="color:white; margin-top:30px;">Assigned Token Duties</h1>

<table>
<thead>
<tr>
<th>ID</th>
<th>Staff</th>
<th>Date</th>
<th>Meal</th>
<th>Status</th>
</tr>
</thead>

<tbody>
<?php while($d = $duties->fetch_assoc()) { ?>
<tr>
<td><?php echo $d['duty_id']; ?></td>
<td><?php echo $d['staff_name']; ?></td>
<td><?php echo $d['duty_date']; ?></td>
<td><?php echo $d['meal_type']; ?></td>
<td><?php echo $d['status']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</body>
</html>