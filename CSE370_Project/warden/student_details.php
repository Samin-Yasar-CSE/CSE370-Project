<?php

include("../includes/auth_warden.php");
include("../db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "warden") {
    header("Location: ../login.php");
    exit();
}

$comp_count = 0;
$countResult = $conn->query("SELECT COUNT(*) AS total FROM Complaint WHERE status='Pending'");

if ($countResult) {
    $countRow = $countResult->fetch_assoc();
    $comp_count = $countRow['total'];
}

$query = "
SELECT si.user_id, si.name, si.email, si.phone, s.room_no, r.floor, r.type
FROM Student_Info si
JOIN Student s ON si.user_id = s.user_id
LEFT JOIN Room r ON s.room_no = r.room_no
";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Details</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
    <h1>Student Details</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Room</th>
            <th>Floor</th>
            <th>Type</th>
        </tr>
    </thead>

    <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['room_no']; ?></td>
            <td><?php echo $row['floor']; ?></td>
            <td><?php echo $row['type']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>

</body>
</html>