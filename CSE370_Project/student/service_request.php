<?php
include("../includes/auth_student.php");
include("../db.php");

$user_id = $_SESSION['user_id'];
$msg = "";

if (isset($_POST['submit'])) {
    $type = $_POST['type'];
    $desc = $conn->real_escape_string($_POST['desc']);

    $conn->query("
        INSERT INTO ServiceReq (type, problem_desc, status, user_id)
        VALUES ('$type', '$desc', 'Pending', '$user_id')
    ");

    header("Location: service_request.php?success=1");
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['s_id'];

    $conn->query("
        DELETE FROM ServiceReq 
        WHERE s_id='$id' AND user_id='$user_id'
    ");

    header("Location: service_request.php?deleted=1");
    exit();
}

if (isset($_GET['success'])) {
    $msg = "Service request submitted successfully!";
}

if (isset($_GET['deleted'])) {
    $msg = "Service request deleted successfully!";
}

$result = $conn->query("
    SELECT * FROM ServiceReq 
    WHERE user_id='$user_id' 
    ORDER BY s_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Service Request</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_student.php"); ?>

<div class="container">
    <h1 class="page-title">Service Request</h1>

    <?php if($msg != "") { ?>
        <div class="success"><?php echo $msg; ?></div>
    <?php } ?>

    <div class="premium-form-card">
        <form method="POST">
            <label>Type of Problem</label>
            <select name="type" required>
                <option value="">Select an option...</option>
                <option value="Cleaning">Cleaning</option>
                <option value="Electric">Electric</option>
                <option value="Plumbing">Plumbing</option>
                <option value="Laundry">Laundry</option>
                <option value="Others">Others</option>
            </select>

            <label>Description</label>
            <textarea name="desc" placeholder="Please describe the issue..." required></textarea>

            <button type="submit" name="submit">Submit Request</button>
        </form>
    </div>

    <h1 class="page-title second-title">My Service Requests</h1>

    <table>
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['s_id']; ?></td>
                <td><?php echo htmlspecialchars($row['type']); ?></td>
                <td><?php echo htmlspecialchars($row['problem_desc']); ?></td>
                <td>
                    <span class="status-pill status-<?php echo strtolower($row['status']); ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td>
                    <form method="POST" onsubmit="return confirm('Delete this service request?');">
                        <input type="hidden" name="s_id" value="<?php echo $row['s_id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>