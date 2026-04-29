<?php
session_start();
include("../db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "student") {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

// SUBMIT
if (isset($_POST['submit'])) {
    $relation = $_POST['relation'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $conn->query("
        INSERT INTO visitrequest (user_id, relation, visit_date, visit_time, status)
        VALUES ('$user_id','$relation','$date','$time','Pending')
    ");

    header("Location: visitor.php?success=1");
    exit();
}

// DELETE
if (isset($_POST['delete'])) {
    $id = $_POST['req_id'];

    $conn->query("
        DELETE FROM visitrequest 
        WHERE req_id='$id' AND user_id='$user_id'
    ");

    header("Location: visitor.php?deleted=1");
    exit();
}

// FETCH
$result = $conn->query("
    SELECT * FROM visitrequest 
    WHERE user_id='$user_id' 
    ORDER BY req_id DESC
");

if (isset($_GET['success'])) $msg = "Request submitted!";
if (isset($_GET['deleted'])) $msg = "Request deleted!";
?>

<!DOCTYPE html>
<html>
<head>
<title>Visitor Request</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_student.php"); ?>

<div class="container">
<h1 class="page-title">Visitor Request</h1>

<?php if($msg) echo "<div class='success'>$msg</div>"; ?>

<div class="premium-form-card">
<form method="POST">

<label>Relation</label>
<input type="text" name="relation" required>

<div class="form-row">
    <div>
        <label>Date</label>
        <input type="date" name="date" required>
    </div>
    <div>
        <label>Time</label>
        <input type="time" name="time" required>
    </div>
</div>

<button name="submit">Submit</button>
</form>
</div>

<h1 class="page-title second-title">My Requests</h1>

<table>
<tr>
<th>Relation</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['relation']; ?></td>
<td><?php echo $row['visit_date']; ?></td>
<td><?php echo $row['visit_time']; ?></td>
<td><?php echo $row['status']; ?></td>

<td>
<form method="POST">
<input type="hidden" name="req_id" value="<?php echo $row['req_id']; ?>">
<button name="delete">Delete</button>
</form>
</td>
</tr>
<?php } ?>

</table>
</div>
</body>
</html>