<?php
$staff_id = $_SESSION['user_id'];

$task_count = 0;
$token_duty_count = 0;

$res = $conn->query("
    SELECT COUNT(*) AS total 
    FROM StaffTask 
    WHERE staff_id='$staff_id' AND status!='Done'
");

if ($res) {
    $row = $res->fetch_assoc();
    $task_count = $row['total'];
}

$res = $conn->query("
    SELECT COUNT(*) AS total
    FROM TokenDuty td
    WHERE td.staff_id='$staff_id'
    AND EXISTS (
        SELECT 1
        FROM DailyMealToken dmt
        WHERE dmt.token_date = td.duty_date
        AND dmt.meal_type = td.meal_type
        AND dmt.status = 'Collected'
    )
");

if ($res) {
    $row = $res->fetch_assoc();
    $token_duty_count = $row['total'];
}
?>

<div class="navbar">
    <a href="/CSE370_Project/staff/dashboard.php">Dashboard</a>

    <a href="/CSE370_Project/staff/my_tasks.php">
        My Tasks
        <?php if($task_count > 0) { ?>
            <span class="badge"><?php echo $task_count; ?></span>
        <?php } ?>
    </a>

    <a href="/CSE370_Project/staff/token_duty.php">
        Token Duty
        <?php if($token_duty_count > 0) { ?>
            <span class="badge"><?php echo $token_duty_count; ?></span>
        <?php } ?>
    </a>

    <a href="/CSE370_Project/staff/warden_details.php">Warden Details</a>
    <a href="/CSE370_Project/logout.php">Logout</a>
</div>