<?php
include("../includes/auth_warden.php");
include("../db.php");

$warden_id = $_SESSION['user_id'];
$msg = "";

if (isset($_POST['delete_task'])) {
    $task_id = $_POST['task_id'];

    $conn->query("DELETE FROM StaffTask WHERE task_id='$task_id'");
    $msg = "Completed task deleted successfully!";
}

$comp_count = 0;
$countQuery = $conn->query("SELECT COUNT(*) AS total FROM Complaint WHERE status='Pending'");
if ($countQuery) {
    $countRow = $countQuery->fetch_assoc();
    $comp_count = $countRow['total'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_title = $_POST['task_title'];
    $task_desc = $_POST['task_desc'];
    $task_date = $_POST['task_date'];
    $task_time = $_POST['task_time'];
    $staff_id = $_POST['staff_id'];

    $query = "INSERT INTO StaffTask 
              (task_title, task_desc, task_date, task_time, status, warden_id, staff_id)
              VALUES 
              ('$task_title', '$task_desc', '$task_date', '$task_time', 'Assigned', '$warden_id', '$staff_id')";

if ($conn->query($query)) {
    header("Location: assign_tasks.php?success=1");
    exit();
}
    else {
        $msg = "Error: " . $conn->error;
    }
}

$staffResult = $conn->query("SELECT user_id, name FROM Staff ORDER BY name ASC");

$taskResult = $conn->query("
SELECT 
    t.task_id,
    t.task_title,
    t.task_desc,
    t.task_date,
    t.task_time,
    t.status,
    s.name AS staff_name
FROM StaffTask t
JOIN Staff s ON t.staff_id = s.user_id
ORDER BY t.task_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Tasks</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
    <h1 style="color:white;">Assign Tasks</h1>

    <?php if($msg != "") { ?>
        <div class="success"><?php echo $msg; ?></div>
    <?php } ?>

    <div class="card">
        <form method="POST">
            <label>Task Title</label>
            <input type="text" name="task_title" required>

            <label>Task Description</label>
            <textarea name="task_desc" rows="4" required></textarea>

            <label>Date</label>
            <input type="date" name="task_date" required>

            <label>Time</label>
            <input type="time" name="task_time" required>

            <label>Assign Staff</label>
            <select name="staff_id" required>
                <option value="">-- Select Staff --</option>
                <?php while($staff = $staffResult->fetch_assoc()) { ?>
                    <option value="<?php echo $staff['user_id']; ?>">
                        <?php echo $staff['name']; ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" name="assign_task">Assign Task</button>
        </form>
    </div>

    <h1 style="color:white; margin-top:30px;">Assigned Tasks</h1>

    <table>
        <thead>
            <tr>
                
                <th>Task</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Staff</th>
                <th>Status</th>
				<th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php while($task = $taskResult->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $task['task_title']; ?></td>
                <td><?php echo $task['task_desc']; ?></td>
                <td><?php echo $task['task_date']; ?></td>
                <td><?php echo $task['task_time']; ?></td>
                <td><?php echo $task['staff_name']; ?></td>
                <td><?php echo $task['status']; ?></td>
				<td>
    <?php if ($task['status'] == "Done") { ?>
        <form method="POST" onsubmit="return confirm('Delete this completed task?');">
            <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
            <button type="submit" name="delete_task">Delete</button>
        </form>
    <?php } else { ?>
        <span>Not completed</span>
    <?php } ?>
</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>