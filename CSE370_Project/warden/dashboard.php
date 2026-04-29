<?php
include("../includes/auth_warden.php");
include("../db.php");

$comp_count = 0;

$countQuery = $conn->query("SELECT COUNT(*) AS total FROM Complaint WHERE status='Pending'");

if ($countQuery) {
    $countRow = $countQuery->fetch_assoc();
    $comp_count = $countRow['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Warden Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
    <h1 style="color:white;">Warden Dashboard</h1>

    <div class="card">
        <h3>Welcome Warden</h3>
        <p>You can manage students, complaints, and announcements from the navigation bar.</p>
    </div>

    <div class="card">
        <h3>Pending Complaints</h3>
        <p>Total Pending Complaints: <?php echo $comp_count; ?></p>
    </div>
</div>

</body>
</html>