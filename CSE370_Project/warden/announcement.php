<?php

include("../includes/auth_warden.php");
include("../db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "warden") {
    header("Location: ../login.php");
    exit();
}

$res = $conn->query("SELECT COUNT(*) AS total FROM Complaint WHERE status='Pending'");
$row = $res->fetch_assoc();
$comp_count = $row['total'];

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['text'];
    $user = $_SESSION['user_id'];

    if (!empty($text)) {
        $conn->query("INSERT INTO Announcement (m_text, date_post, wuser_id)
                      VALUES ('$text', CURDATE(), '$user')");
        $msg = "Posted!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Announcement</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
<h1 style="color:white;">Post Announcement</h1>

<?php if($msg) echo "<div class='success'>$msg</div>"; ?>

<div class="card">
<form method="POST">
<textarea name="text" required></textarea>
<button type="submit">Post</button>
</form>
</div>

</div>
</body>
</html>