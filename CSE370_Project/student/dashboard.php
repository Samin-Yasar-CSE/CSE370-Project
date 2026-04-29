<?php

include("../includes/auth_student.php");
include("../db.php");
include("../includes/navbar_student.php"); 

$ann_count = 0;
$res = $conn->query("SELECT COUNT(*) as total FROM Announcement");
if ($res) {
    $row = $res->fetch_assoc();
    $ann_count = $row['total'];
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT si.name, s.room_no, r.floor, r.type
FROM Student_Info si
JOIN Student s ON si.user_id = s.user_id
LEFT JOIN Room r ON s.room_no = r.room_no
WHERE si.user_id = '$user_id'
";

$result = $conn->query($query);
$data = $result->fetch_assoc();


$ann_count = 0;

$res = $conn->query("
SELECT COUNT(*) AS total
FROM Announcement a
WHERE NOT EXISTS (
    SELECT 1
    FROM Announcement_Reads ar
    WHERE ar.announcement_id = a.announcement_id
    AND ar.user_id = '$user_id'
)
");

if ($res) {
    $row = $res->fetch_assoc();
    $ann_count = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>


<div class="container">
    <h1>Student Dashboard</h1>

    <div class="card">
        <p><b>Name:</b> <?php echo $data['name']; ?></p>
        <p><b>Room No:</b> <?php echo $data['room_no']; ?></p>
        <p><b>Floor:</b> <?php echo $data['floor']; ?></p>
        <p><b>Room Type:</b> <?php echo $data['type']; ?></p>
    </div>
</div>

</body>
</html>