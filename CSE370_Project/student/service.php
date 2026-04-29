<?php
include("../includes/auth_student.php");
include("../db.php");

$user_id = $_SESSION['user_id'];
$msg = "";

// ADD REQUEST
if (isset($_POST['submit'])) {
    $type = $_POST['type'];
    $desc = $_POST['desc'];

    $conn->query("
        INSERT INTO ServiceReq (type, problem_desc, status, user_id)
        VALUES ('$type','$desc','Pending','$user_id')
    ");

    // FIXED: Redirecting to the new file name
    header("Location: service.php");
    exit();
}

// DELETE REQUEST
if (isset($_POST['delete'])) {
    $id = $_POST['s_id'];

    $conn->query("
        DELETE FROM ServiceReq 
        WHERE s_id='$id' AND user_id='$user_id'
    ");

    // FIXED: Redirecting to the new file name
    header("Location: service.php");
    exit();
}

// FETCH
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
    
    <style>
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        
        /* Fixes the invisible box issue */
        .card {
            background-color: #2c3e50; 
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }

        /* Fixes gaps between labels and boxes */
        .form-group {
            margin-bottom: 18px; 
        }

        .card label {
            display: block;
            color: #ffffff;
            margin-bottom: 8px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* Fixes input styling so they are clearly visible */
        .card select, .card textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            box-sizing: border-box; 
            background-color: #ffffff;
            color: #333;
            font-size: 14px;
        }

        .card textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Button styling for better spacing and look */
        .submit-btn {
            padding: 12px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            margin-top: 10px;
            transition: 0.3s;
        }
        .submit-btn:hover { background-color: #2ecc71; }

        .delete-btn {
            padding: 8px 12px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover { background-color: #c0392b; }

        /* Table UI improvements */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
            color: #2c3e50;
        }
        th { background-color: #34495e; color: #ffffff; }
    </style>
</head>
<body>

<?php include("../includes/navbar_student.php"); ?>

<div class="container">
    <h1 style="color:white; margin-bottom: 20px;">Service Request</h1>

    <div class="card">
        <form method="POST">
            <div class="form-group">
                <label>Type of Problem</label>
                <select name="type" required>
                    <option value="" disabled selected>Select an option...</option>
                    <option value="Cleaning">Cleaning</option>
                    <option value="Electric">Electric</option>
                    <option value="Plumbing">Plumbing</option>
					<option value="Plumbing">Laundry</option>
					<option value="Plumbing">Others</option>
                </select>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="desc" placeholder="Please describe the issue in detail..." required></textarea>
            </div>

            <button type="submit" name="submit" class="submit-btn">Submit Request</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($row['type']); ?></strong></td>
                <td><?php echo htmlspecialchars($row['problem_desc']); ?></td>
                <td>
                    <span style="font-weight: bold; color: <?php echo ($row['status'] == 'Pending') ? '#f39c12' : (($row['status'] == 'Approved') ? '#27ae60' : '#e74c3c'); ?>;">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td>
                    <form method="POST" style="margin: 0;">
                        <input type="hidden" name="s_id" value="<?php echo $row['s_id']; ?>">
                        <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this request?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>
</body>
</html>