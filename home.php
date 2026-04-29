<!DOCTYPE html>
<html>
<head>
    <title>Smart Hostel Management System</title>
    <link rel="stylesheet" href="assets/style.css">

		<style>
    .home-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: white;
    }

    .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        padding: 0 5%;
    }

    .content-box {
        max-width: 800px;
        margin-bottom: 10vh;
    }

    .content-box h1 {
        font-size: 36px;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 30px;
        text-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }

    .content-box p {
        font-size: 18px;
        line-height: 1.6;
        color: #e5e7eb;
        margin-bottom: 40px;
        max-width: 810px;
    }

    .home-buttons {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .home-btn {
        padding: 12px 32px;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .home-btn.primary {
        background: #2563eb;
        color: white;
        border: 2px solid #2563eb;
        box-shadow: 0 6px 16px rgba(37,99,235,0.25);
    }

    .home-btn.primary:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37,99,235,0.35);
    }

    .home-btn.secondary {
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.25);
        color: white;
        backdrop-filter: blur(8px);
    }

    .home-btn.secondary:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.4);
        transform: translateY(-2px);
    }

    @media(max-width: 768px) {
        .main-content {
            padding: 40px 5%;
        }

        .content-box {
            margin-bottom: 5vh;
        }

        .content-box h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .content-box p {
            font-size: 16px;
            margin-bottom: 32px;
        }
    }
</style>
</head>

<body>

<div class="home-wrapper">

    <!-- LEFT-ALIGNED CONTENT -->
    <div class="main-content">
        <div class="content-box">
            <h1>Smart Hostel Management System</h1>

            <p>
             A centralized digital platform designed to streamline hostel operations
             and enhance communication between students, wardens, and staff. It replaces traditional manual processes
             with an efficient, real-time system for managing complaints, visitor approvals, and service requests,
             along with announcements, staff task coordination, and structured meal management.

            </p>

            <div class="home-buttons">
                <a href="login.php" class="home-btn primary">Login Portal</a>
                <a href="features.php" class="home-btn secondary">Explore Features</a>
            </div>
        </div>
    </div>

    <!-- FOOTER (UNCHANGED) -->
    <footer class="footer">
        © 2026 <strong>Smart Hostel Management System</strong><br>
        Developed by <strong>TEAM A-W-S</strong>

        <div class="social-links">
            <a href="https://www.linkedin.com/feed/" target="_blank">LinkedIn</a> |
            <a href="https://github.com/Samin-Yasar-CSE" target="_blank">GitHub</a>
        </div>
    </footer>

</div>

</body>
</html>