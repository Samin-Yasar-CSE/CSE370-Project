<?php
include("../includes/auth_student.php");
include("../db.php");

$user_id = $_SESSION['user_id'];

if (isset($_POST['mark_read'])) {
    $announcement_id = $_POST['announcement_id'];

    $conn->query("
        INSERT IGNORE INTO Announcement_Reads (user_id, announcement_id)
        VALUES ('$user_id', '$announcement_id')
    ");
}

if (isset($_POST['delete_announcement'])) {
    $announcement_id = $_POST['announcement_id'];

    $conn->query("DELETE FROM Announcement_Reads WHERE announcement_id='$announcement_id'");
    $conn->query("DELETE FROM Announcement WHERE announcement_id='$announcement_id'");
}

$query = "
SELECT 
    a.announcement_id,
    a.m_text,
    a.date_post,
    ar.user_id AS read_status
FROM Announcement a
LEFT JOIN Announcement_Reads ar
    ON a.announcement_id = ar.announcement_id
    AND ar.user_id = '$user_id'
ORDER BY a.announcement_id DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Announcements</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_student.php"); ?>

<div class="container">
<h1 style="color:white;">Announcements</h1>

<?php while($row = $result->fetch_assoc()) { ?>
    <div class="card">
        <p><?php echo $row['m_text']; ?></p>
        <small><b>Date:</b> <?php echo $row['date_post']; ?></small>

        <br><br>

        <?php if ($row['read_status'] == null) { ?>
            <form method="POST" style="margin-bottom:10px;">
                <input type="hidden" name="announcement_id" value="<?php echo $row['announcement_id']; ?>">
                <button type="submit" name="mark_read">Mark as Read</button>
            </form>
        <?php } else { ?>
            <span class="read-label">Read</span>
            <br><br>
        <?php } ?>

        <form method="POST">
            <input type="hidden" name="announcement_id" value="<?php echo $row['announcement_id']; ?>">
            <button type="submit" name="delete_announcement" onclick="return confirm('Delete this announcement permanently?')">Delete</button>
        </form>
    </div>
<?php } ?>

</div>
</body>
</html>