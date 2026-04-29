<?php
include("../includes/auth_warden.php");
include("../db.php");

mysqli_report(MYSQLI_REPORT_OFF);

$warden_id = $_SESSION['user_id'];
$msg = "";
$error = "";

$res = $conn->query("SELECT COUNT(*) AS total FROM Complaint WHERE status='Pending'");
$row = $res ? $res->fetch_assoc() : ["total" => 0];
$comp_count = $row['total'];

$days = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

$mealColumns = [
    "breakfast" => "breakfast",
    "morning_snacks" => "morning_snacks",
    "lunch" => "lunch",
    "evening_snacks" => "evening_snacks",
    "dinner" => "dinner"
];

if (isset($_POST['save_meal'])) {
    $day = $_POST['day_name'];
    $meal_type = $_POST['meal_type'];
    $items = $_POST['items'];

    if (!array_key_exists($meal_type, $mealColumns)) {
        $error = "Invalid meal type selected.";
    } else {
        $column = $mealColumns[$meal_type];

        $checkStmt = $conn->prepare("SELECT plan_id FROM WeeklyMealPlan WHERE day_name = ?");
        $checkStmt->bind_param("s", $day);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows == 0) {
            $insertStmt = $conn->prepare("
                INSERT INTO WeeklyMealPlan 
                (day_name, breakfast, morning_snacks, lunch, evening_snacks, dinner, wuser_id)
                VALUES (?, '', '', '', '', '', ?)
            ");
            $insertStmt->bind_param("si", $day, $warden_id);

            if (!$insertStmt->execute()) {
                $error = "Insert failed: " . $insertStmt->error;
            }
        }

        if ($error == "") {
            $sql = "UPDATE WeeklyMealPlan SET $column = ?, wuser_id = ? WHERE day_name = ?";
            $updateStmt = $conn->prepare($sql);
            $updateStmt->bind_param("sis", $items, $warden_id, $day);

            if ($updateStmt->execute()) {
                header("Location: meal_plan.php?success=1");
                exit();
            } else {
                $error = "Update failed: " . $updateStmt->error;
            }
        }
    }
}

if (isset($_GET['success'])) {
    $msg = "Meal plan updated successfully!";
}

$result = $conn->query("
    SELECT * FROM WeeklyMealPlan
    ORDER BY FIELD(day_name,'Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday')
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customize Meal Plan</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_warden.php"); ?>

<div class="container">
    <h1 class="page-title">Customize Weekly Meal Plan</h1>

    <?php if($msg != "") { ?>
        <div class="success"><?php echo $msg; ?></div>
    <?php } ?>

    <?php if($error != "") { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <div class="premium-form-card">
        <form method="POST">
            <div class="form-row">
                <div class="form-field">
                    <label>Select Day</label>
                    <select name="day_name" required>
                        <option value="">-- Choose Day --</option>
                        <?php foreach($days as $day) { ?>
                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-field">
                    <label>Select Meal</label>
                    <select name="meal_type" required>
                        <option value="">-- Choose Meal --</option>
                        <option value="breakfast">Breakfast</option>
                        <option value="morning_snacks">Morning Snacks</option>
                        <option value="lunch">Lunch</option>
                        <option value="evening_snacks">Evening Snacks</option>
                        <option value="dinner">Dinner</option>
                    </select>
                </div>
            </div>

            <label>Food Items</label>
            <textarea name="items" rows="4" placeholder="Example: Paratha, Egg, Tea" required></textarea>

            <button type="submit" name="save_meal">Save / Update Meal</button>
        </form>
    </div>

    <h1 class="page-title second-title">Current Weekly Routine</h1>

    <div class="routine-board">
        <?php if($result && $result->num_rows > 0) { ?>
            <?php while($row = $result->fetch_assoc()) { ?>
                <div class="routine-card">
                    <div class="routine-day"><?php echo $row['day_name']; ?></div>

                    <div class="meal-slot">
                        <span>Breakfast</span>
                        <p><?php echo $row['breakfast'] != "" ? $row['breakfast'] : "Not set"; ?></p>
                    </div>

                    <div class="meal-slot">
                        <span>Morning Snacks</span>
                        <p><?php echo $row['morning_snacks'] != "" ? $row['morning_snacks'] : "Not set"; ?></p>
                    </div>

                    <div class="meal-slot">
                        <span>Lunch</span>
                        <p><?php echo $row['lunch'] != "" ? $row['lunch'] : "Not set"; ?></p>
                    </div>

                    <div class="meal-slot">
                        <span>Evening Snacks</span>
                        <p><?php echo $row['evening_snacks'] != "" ? $row['evening_snacks'] : "Not set"; ?></p>
                    </div>

                    <div class="meal-slot">
                        <span>Dinner</span>
                        <p><?php echo $row['dinner'] != "" ? $row['dinner'] : "Not set"; ?></p>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="card">
                <p>No meal plan has been added yet.</p>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>