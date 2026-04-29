<?php
include("../includes/auth_warden.php");
include("../db.php");

$msg = "";

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['req_id'];
    $status = $_POST['status'];

    $conn->query("
        UPDATE visitrequest 
        SET status='$status' 
        WHERE req_id='$id'
    ");

    header("Location: visitor_requests.php?updated=1");
    exit();
}

// DELETE
if (isset($_POST['delete'])) {
    $id = $_POST['req_id'];

    $conn->query("
        DELETE FROM visitrequest 
        WHERE req_id='$id'
    ");

    header("Location: visitor_requests.php?deleted=1");
    exit();
}

if (isset($_GET['updated'])) $msg = "Updated successfully!";
if (isset($_GET['deleted'])) $msg = "Deleted successfully!";

// FETCH
$result = $conn->query("
SELECT vr.*, si.name, s.room_no
FROM visitrequest vr
JOIN Student_Info si ON vr.user_id = si.user_id
JOIN Student s ON vr.user_id = s.user_id
ORDER BY vr.req_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Visitor Requests</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
<h1 class="page-title">Visitor Requests</h1>

<?php if($msg) echo "<div class='success'>$msg</div>"; ?>

<table>
<tr>
<th>Name</th>
<th>Room</th>
<th>Relation</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<form method="POST">

<td><?php echo $row['name']; ?></td>
<td><?php echo $row['room_no']; ?></td>
<td><?php echo $row['relation']; ?></td>
<td><?php echo date("M d, Y", strtotime($row['visit_date'])); ?></td>
<td><?php echo date("h:i A", strtotime($row['visit_time'])); ?></td>

<td>
<select name="status">
<option value="Pending" <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
<option value="Approved" <?php if($row['status']=="Approved") echo "selected"; ?>>Approved</option>
<option value="Rejected" <?php if($row['status']=="Rejected") echo "selected"; ?>>Rejected</option>
</select>
</td>

<td>
<input type="hidden" name="req_id" value="<?php echo $row['req_id']; ?>">
<button name="update">Update</button>
<button name="delete">Delete</button>
</td>

</form>
</tr>
<?php } ?>

</table>
</div>
</body>
</html>