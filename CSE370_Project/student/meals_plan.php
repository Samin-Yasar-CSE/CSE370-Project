<?php
include("../includes/auth_student.php");
include("../db.php");

$days = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

$plans = [];
$result = $conn->query("SELECT * FROM WeeklyMealPlan");
while ($row = $result->fetch_assoc()) {
    $plans[$row['day_name']] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Meal Plan</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include("../includes/navbar_student.php"); ?>

<div class="container">
<h1 style="color:white;">Weekly Meal Routine</h1>

<div class="routine-board">
<?php foreach($days as $day) { 
    $p = $plans[$day] ?? null;
?>
    <div class="routine-card">
        <div class="routine-day"><?php echo $day; ?></div>

        <?php if($p) { ?>
            <div class="meal-slot">
                <span>Breakfast</span>
                <p><?php echo $p['breakfast']; ?></p>
            </div>

            <div class="meal-slot">
                <span>Morning Snacks</span>
                <p><?php echo $p['morning_snacks']; ?></p>
            </div>

            <div class="meal-slot">
                <span>Lunch</span>
                <p><?php echo $p['lunch']; ?></p>
            </div>

            <div class="meal-slot">
                <span>Evening Snacks</span>
                <p><?php echo $p['evening_snacks']; ?></p>
            </div>

            <div class="meal-slot">
                <span>Dinner</span>
                <p><?php echo $p['dinner']; ?></p>
            </div>
        <?php } else { ?>
            <p>No meal plan added yet.</p>
        <?php } ?>
    </div>
<?php } ?>
</div>

</div>
</body>
</html>