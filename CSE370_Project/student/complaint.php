<?php
include("../includes/auth_student.php");
include("../db.php");

$user_id = $_SESSION['user_id'];
$msg = "";

// SUBMIT
if (isset($_POST['submit'])) {
    $desc = $conn->real_escape_string($_POST['description']);

    $conn->query("
        INSERT INTO Complaint (description, status, user_id)
        VALUES ('$desc', 'Pending', '$user_id')
    ");

    header("Location: complaint.php?success=1");
    exit();
}

// FETCH
$result = $conn->query("
    SELECT * FROM Complaint 
    WHERE user_id='$user_id' 
    ORDER BY complaint_id DESC
");

if (isset($_GET['success'])) {
    $msg = "Complaint submitted successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Complaint</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_student.php"); ?>

<div class="container">
<h1 class="page-title">Submit Complaint</h1>

<?php if($msg) echo "<div class='success'>$msg</div>"; ?>

<div class="premium-form-card">
<form method="POST">
<label>Description</label>
<textarea name="description" required></textarea>
<button type="submit" name="submit">Submit</button>
</form>
</div>

<h1 class="page-title second-title">My Complaints</h1>

<table>
<tr>
<th>ID</th>
<th>Description</th>
<th>Status</th>
<th>Admin Reply</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['complaint_id']; ?></td>
<td><?php echo $row['description']; ?></td>
<td><?php echo $row['status']; ?></td>
<td><?php echo $row['admin_rv']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>