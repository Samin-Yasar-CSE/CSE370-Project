<?php
include("../includes/auth_staff.php");
include("../db.php");

$staff_id = $_SESSION['user_id'];
$msg = "";

if (isset($_POST['done'])) {
    $task_id = $_POST['task_id'];

    $conn->query("UPDATE StaffTask SET status='Done' WHERE task_id='$task_id' AND staff_id='$staff_id'");
    $msg = "Task marked as done!";
}

$query = "
SELECT 
    t.task_id,
    t.task_title,
    t.task_desc,
    t.task_date,
    t.task_time,
    t.status,
    w.name AS warden_name
FROM StaffTask t
JOIN Warden w ON t.warden_id = w.user_id
WHERE t.staff_id = '$staff_id'
ORDER BY t.task_id DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Tasks</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_staff.php"); ?>

<div class="container">
    <h1 style="color:white;">My Tasks</h1>

    <?php if($msg != "") { ?>
        <div class="success"><?php echo $msg; ?></div>
    <?php } ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Assigned By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['task_id']; ?></td>
                <td><?php echo $row['task_title']; ?></td>
                <td><?php echo $row['task_desc']; ?></td>
                <td><?php echo $row['task_date']; ?></td>
                <td><?php echo $row['task_time']; ?></td>
                <td><?php echo $row['warden_name']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php if($row['status'] != "Done") { ?>
                        <form method="POST">
                            <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
                            <button type="submit" name="done">Done</button>
                        </form>
                    <?php } else { ?>
                        <span class="read-label">Completed</span>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>