<?php
include("../includes/auth_warden.php");
include("../db.php");

$warden_id = $_SESSION['user_id'];

$comp_count = 0;
$countQuery = $conn->query("SELECT COUNT(*) AS total FROM Complaint WHERE status='Pending'");
if ($countQuery) {
    $countRow = $countQuery->fetch_assoc();
    $comp_count = $countRow['total'];
}

$wardenQuery = "SELECT * FROM Warden WHERE user_id='$warden_id'";
$wardenResult = $conn->query($wardenQuery);
$warden = $wardenResult->fetch_assoc();

$staffQuery = "SELECT * FROM Staff ORDER BY user_id ASC";
$staffResult = $conn->query($staffQuery);
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff List</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
<h1 style="color:white;">Staff List</h1>

<div class="card">
    <h3>Warden Details</h3>
    <p><b>ID:</b> <?php echo $warden['user_id']; ?></p>
    <p><b>Name:</b> <?php echo $warden['name']; ?></p>
    <p><b>Email:</b> <?php echo $warden['email']; ?></p>
    <p><b>Phone:</b> <?php echo $warden['phone']; ?></p>
</div>

<table>
<thead>
<tr>
<th>Staff ID</th>
<th>Name</th>
<th>Phone</th>
<th>Assigned Service ID</th>
</tr>
</thead>

<tbody>
<?php while($row = $staffResult->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['user_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['phone']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</body>
</html>