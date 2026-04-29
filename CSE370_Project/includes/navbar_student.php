<?php
$user_id = $_SESSION['user_id'];

$ann_count = 0;

$res = $conn->query("
    SELECT COUNT(*) AS total
    FROM Announcement a
    WHERE NOT EXISTS (
        SELECT 1
        FROM Announcement_Reads ar
        WHERE ar.announcement_id = a.announcement_id
        AND ar.user_id = '$user_id'
    )
");

if ($res) {
    $row = $res->fetch_assoc();
    $ann_count = $row['total'];
}
?>

<div class="navbar">
    <a href="/CSE370_Project/student/dashboard.php">Dashboard</a>
    <a href="/CSE370_Project/student/complaint.php">Complaint</a>
    <a href="/CSE370_Project/student/visitor.php">Visitor</a>
    <a href="/CSE370_Project/student/service_request.php">Service</a>

    <a href="/CSE370_Project/student/announcements.php">
        Announcements
        <?php if($ann_count > 0) { ?>
            <span class="badge"><?php echo $ann_count; ?></span>
        <?php } ?>
    </a>

    <a href="/CSE370_Project/student/meals_plan.php">Meal Plan</a>
    <a href="/CSE370_Project/student/meal_token.php">Meal Token</a>
    <a href="/CSE370_Project/logout.php">Logout</a>
</div>