<?php
session_start();
include("db.php");




if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == "student") {
        header("Location: student/dashboard.php");
        exit();
    } elseif ($_SESSION['role'] == "warden") {
        header("Location: warden/dashboard.php");
        exit();
    } elseif ($_SESSION['role'] == "staff") {
        header("Location: staff/dashboard.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == "student") {
        $query = "SELECT * FROM Student_Info WHERE user_id='$user_id' AND password='$password'";
        $redirect = "student/dashboard.php";
    } elseif ($role == "warden") {
        $query = "SELECT * FROM Warden WHERE user_id='$user_id' AND password='$password'";
        $redirect = "warden/dashboard.php";
    } elseif ($role == "staff") {
        $query = "SELECT * FROM Staff WHERE user_id='$user_id' AND password='$password'";
        $redirect = "staff/dashboard.php";
    }

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
        header("Location: " . $redirect);
        exit();
    } else {
        $error = "Invalid User ID, Password, or Role!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Smart Hostel</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="login-box">
    <h1>Smart Hostel</h1>
    <h2>Login</h2>

    <?php if(isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

<form method="POST">

    <div class="form-group">
        <label>User ID</label>
        <input type="text" name="user_id" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" id="password" required>
    </div>

    <div class="form-group show-password">
        <input type="checkbox" onclick="showPassword()">
        <span>Show Password</span>
    </div>

    <div class="form-group">
        <label>Login As</label>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="student">Student</option>
            <option value="warden">Warden</option>
            <option value="staff">Staff</option>
        </select>
    </div>

    <button type="submit">Login</button>

</form>
</div>

<script src="assets/script.js"></script>
</body>
</html>