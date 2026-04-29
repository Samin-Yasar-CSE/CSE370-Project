<?php
include("../includes/auth_warden.php");
include("../db.php");

// Update status
if (isset($_POST['update'])) {
    $id = $_POST['s_id']; // Changed to match Student table
    $status = $_POST['status'];

    $conn->query("UPDATE ServiceReq SET status='$status' WHERE s_id='$id'"); // Changed table and ID name
}

// Delete request
if (isset($_POST['delete'])) {
    $id = $_POST['s_id']; // Changed to match Student table
    $conn->query("DELETE FROM ServiceReq WHERE s_id='$id'"); // Changed table and ID name
}

// Fetch data
$result = $conn->query("
    SELECT sr.*, si.name 
    FROM ServiceReq sr
    JOIN Student_Info si ON sr.user_id = si.user_id
    ORDER BY sr.s_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Service Requests</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
    <h1 style="color:white;">Service Requests</h1>

    <table>
        <thead>
            <tr>
                <th>Student</th>
                <th>Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <form method="POST">

                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['type']; ?></td> <td><?php echo $row['problem_desc']; ?></td> <td>
                    <select name="status">
                        <option value="Pending" <?php if($row['status']=="Pending") echo "selected"; ?>>Pending</option>
                        <option value="Approved" <?php if($row['status']=="Approved") echo "selected"; ?>>Approved</option>
                        <option value="Rejected" <?php if($row['status']=="Rejected") echo "selected"; ?>>Rejected</option>
                    </select>
                </td>

                <td>
                    <input type="hidden" name="s_id" value="<?php echo $row['s_id']; ?>"> <button name="update">Update</button>
                    <button name="delete" onclick="return confirm('Delete this request?')">Delete</button>
                </td>

                </form>
            </tr>
            <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>