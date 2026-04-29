<?php
include("../includes/auth_warden.php");
include("../db.php");

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['complaint_id'];
    $status = $_POST['status'];
    $admin_rv = $conn->real_escape_string($_POST['admin_rv']);

    $conn->query("
        UPDATE Complaint 
        SET status='$status', admin_rv='$admin_rv' 
        WHERE complaint_id='$id'
    ");

    header("Location: complaints.php");
    exit();
}

// DELETE (ONLY RESOLVED)
if (isset($_POST['delete'])) {
    $id = $_POST['complaint_id'];

    $conn->query("
        DELETE FROM Complaint 
        WHERE complaint_id='$id' AND status='Resolved'
    ");

    header("Location: complaints.php");
    exit();
}

// FETCH
$result = $conn->query("
SELECT c.*, si.name, s.room_no
FROM Complaint c
JOIN Student_Info si ON c.user_id = si.user_id
JOIN Student s ON c.user_id = s.user_id
ORDER BY c.complaint_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Complaints</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
<h1 class="page-title">Student Complaints</h1>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Room</th>
<th>Description</th>
<th>Status</th>
<th>Reply</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<form method="POST">

<td><?php echo $row['complaint_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['room_no']; ?></td>
<td><?php echo $row['description']; ?></td>

<td>
<select name="status">
<option value="Pending" <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
<option value="Reviewed" <?php if($row['status']=="Reviewed") echo "selected"; ?>>Reviewed</option>
<option value="Resolved">Resolved</option>
</select>
</td>

<td>
<input type="text" name="admin_rv" value="<?php echo $row['admin_rv']; ?>">
</td>

<td>
<input type="hidden" name="complaint_id" value="<?php echo $row['complaint_id']; ?>">

<button name="update">Update</button>

<?php if($row['status'] == "Resolved") { ?>
<button name="delete" onclick="return confirm('Delete resolved complaint?')">
Delete
</button>
<?php } ?>

</td>

</form>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>