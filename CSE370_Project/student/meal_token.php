<?php
include("../includes/auth_student.php");
include("../db.php");

$user_id = $_SESSION['user_id'];
$msg = "";
$today = date("Y-m-d");

if (isset($_POST['collect_token'])) {
    $meal_type = $_POST['meal_type'];

    $check = $conn->prepare("
        SELECT token_id FROM DailyMealToken 
        WHERE user_id=? AND meal_type=? AND token_date=?
    ");
    $check->bind_param("iss", $user_id, $meal_type, $today);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        header("Location: meal_token.php?msg=already");
        exit();
    } else {
        $stmt = $conn->prepare("
            INSERT INTO DailyMealToken (user_id, meal_type, token_date, status)
            VALUES (?, ?, ?, 'Collected')
        ");
        $stmt->bind_param("iss", $user_id, $meal_type, $today);
        $stmt->execute();

        header("Location: meal_token.php?msg=collected");
        exit();
    }
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "collected") {
        $msg = "Meal token collected successfully!";
    } elseif ($_GET['msg'] == "already") {
        $msg = "You already collected this meal token today.";
    }
}
if (isset($_GET['success'])) {
    $msg = "Meal token collected successfully!";
}

$tokens = $conn->query("
SELECT * FROM DailyMealToken
WHERE user_id='$user_id'
ORDER BY token_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Meal Token</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_student.php"); ?>

<div class="container">
<h1 style="color:white;">Daily Meal Token</h1>

<?php if($msg != "") { ?>
<div class="success"><?php echo $msg; ?></div>
<?php } ?>

<div class="token-panel">
    <h2>Collect Today's Token</h2>
    <p class="muted">Date: <?php echo $today; ?></p>

    <form method="POST" class="token-buttons">
        <button name="collect_token" value="1" type="submit" onclick="document.getElementById('meal_type').value='Breakfast'">Breakfast</button>
        <button name="collect_token" value="1" type="submit" onclick="document.getElementById('meal_type').value='Morning Snacks'">Morning Snacks</button>
        <button name="collect_token" value="1" type="submit" onclick="document.getElementById('meal_type').value='Lunch'">Lunch</button>
        <button name="collect_token" value="1" type="submit" onclick="document.getElementById('meal_type').value='Evening Snacks'">Evening Snacks</button>
        <button name="collect_token" value="1" type="submit" onclick="document.getElementById('meal_type').value='Dinner'">Dinner</button>
        <input type="hidden" name="meal_type" id="meal_type">
    </form>
</div>

<h1 style="color:white; margin-top:30px;">Token History</h1>

<table>
<thead>
<tr>
<th>Token ID</th>
<th>Meal</th>
<th>Date</th>
<th>Status</th>
<th>Collected At</th>
<th>Used At</th>
</tr>
</thead>

<tbody>
<?php while($row = $tokens->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['token_id']; ?></td>
<td><?php echo $row['meal_type']; ?></td>
<td><?php echo $row['token_date']; ?></td>
<td><?php echo $row['status']; ?></td>
<td><?php echo $row['collected_at']; ?></td>
<td><?php echo $row['used_at']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</body>
</html>