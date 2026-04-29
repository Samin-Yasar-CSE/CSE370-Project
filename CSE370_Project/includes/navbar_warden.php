<?php
$comp_count = 0;
$visitor_count = 0;
$service_count = 0;

$res = $conn->query("SELECT COUNT(*) AS total FROM Complaint WHERE status='Pending'");
if ($res) {
    $row = $res->fetch_assoc();
    $comp_count = $row['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM visitrequest WHERE status='Pending'");
if ($res) {
    $row = $res->fetch_assoc();
    $visitor_count = $row['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM ServiceReq WHERE status='Pending'");
if ($res) {
    $row = $res->fetch_assoc();
    $service_count = $row['total'];
}
?>

<div class="navbar">
    <a href="/CSE370_Project/warden/dashboard.php">Dashboard</a>
    <a href="/CSE370_Project/warden/student_details.php">Students</a>

    <a href="/CSE370_Project/warden/complaints.php">
        Complaints
        <?php if($comp_count > 0) { ?>
            <span class="badge"><?php echo $comp_count; ?></span>
        <?php } ?>
    </a>

    <a href="/CSE370_Project/warden/visitor_requests.php">
        Visitor Requests
        <?php if($visitor_count > 0) { ?>
            <span class="badge"><?php echo $visitor_count; ?></span>
        <?php } ?>
    </a>

    <a href="/CSE370_Project/warden/service_requests.php">
        Service Requests
        <?php if($service_count > 0) { ?>
            <span class="badge"><?php echo $service_count; ?></span>
        <?php } ?>
    </a>

    <a href="/CSE370_Project/warden/announcement.php">Announcement</a>
    <a href="/CSE370_Project/warden/staff_list.php">Staff List</a>
    <a href="/CSE370_Project/warden/assign_tasks.php">Assign Tasks</a>
    <a href="/CSE370_Project/warden/meal_plan.php">Meal Plan</a>
    <a href="/CSE370_Project/warden/token_duty.php">Token Duty</a>
    <a href="/CSE370_Project/logout.php">Logout</a>
</div>