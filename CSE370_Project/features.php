<!DOCTYPE html>
<html>
<head>
    <title>Features - Smart Hostel Ecosystem</title>
    <link rel="stylesheet" href="assets/style.css">

    <style>
        .features-page {
            min-height: 100vh;
            padding: 70px 8%;
            color: white;
        }

        .top-actions {
            margin-bottom: 30px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .top-actions a {
            padding: 12px 22px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 800;
            color: white;
            background: rgba(255,255,255,0.14);
            border: 1px solid rgba(255,255,255,0.35);
            backdrop-filter: blur(12px);
        }

        .top-actions a.login {
            background: #2563eb;
            border: none;
        }

        .section-title {
            text-align: center;
            font-size: 42px;
            margin-bottom: 12px;
            text-shadow: 0 6px 20px rgba(0,0,0,0.65);
        }

        .section-subtitle {
            text-align: center;
            max-width: 780px;
            margin: 0 auto 40px;
            color: #dbeafe;
            line-height: 1.7;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 22px;
        }

        .feature-box {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.24);
            padding: 24px;
            border-radius: 24px;
            backdrop-filter: blur(14px);
            box-shadow: 0 16px 35px rgba(0,0,0,0.28);
            transition: 0.25s;
        }

        .feature-box:hover {
            transform: translateY(-6px);
            background: rgba(37,99,235,0.28);
        }

        .feature-icon {
            font-size: 30px;
            margin-bottom: 12px;
        }

        .feature-box h3 {
            margin-bottom: 10px;
            font-size: 20px;
        }

        .feature-box p {
            color: #dbeafe;
            line-height: 1.6;
            font-size: 14px;
        }

        .footer {
            margin-top: 50px;
            padding: 18px;
            text-align: center;
            color: #cbd5e1;
            background: rgba(0,0,0,0.65);
            border-radius: 18px;
            font-size: 14px;
        }
		
		
		
		      .footer {
    backdrop-filter: blur(8px);
    border-top: 1px solid rgba(255,255,255,0.1);
}


.page-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}


.features-page {
    flex: 1;
}


.footer {
    width: 100%;
    padding: 20px;
    text-align: center;
    background: rgba(0,0,0,0.85);
    color: #cbd5e1;
    font-size: 14px;
}


    </style>


<head>
    <title>Features - Smart Hostel Management System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="page-wrapper">


    <div class="features-page">

        <div class="top-actions">
            <a href="home.php">Back Home</a>
            <a href="login.php" class="login">Login Portal</a>
        </div>

        <h1 class="section-title">Core Features</h1>

        <p class="section-subtitle">
            The Smart Hostel Management System simplifies hostel operations by connecting students,
            wardens, and staff through a centralized digital platform.
        </p>

        <div class="feature-grid">

            <div class="feature-box">
                <div class="feature-icon">🔐</div>
                <h3>Multi-role Login</h3>
                <p>Secure access for Student, Warden, and Staff with role-based dashboards.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">📝</div>
                <h3>Complaint Management</h3>
                <p>Students submit complaints and wardens resolve them efficiently.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">👥</div>
                <h3>Visitor Requests</h3>
                <p>Digital visitor approval system for better hostel security.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">🛠️</div>
                <h3>Service Requests</h3>
                <p>Report and track maintenance issues such as plumbing or electrical faults.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">📢</div>
                <h3>Announcements</h3>
                <p>Wardens post notices and students receive real-time updates.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">✅</div>
                <h3>Task Management</h3>
                <p>Assign tasks to staff and monitor completion progress.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">🍽️</div>
                <h3>Meal Plan</h3>
                <p>Weekly meal schedules managed by the warden for students.</p>
            </div>

            <div class="feature-box">
                <div class="feature-icon">🎟️</div>
                <h3>Meal Tokens</h3>
                <p>Students collect tokens and staff verify meals during duty.</p>
            </div>

        </div>

    </div>


    <footer class="footer">
        © 2026 <strong>Smart Hostel Management System</strong><br>
        Developed by <strong>Samin Yasar</strong>

        <div class="social-links">
            <a href="https://www.linkedin.com/feed/" target="_blank">LinkedIn</a> |
            <a href="https://github.com/Samin-Yasar-CSE" target="_blank">GitHub</a>
        </div>
    </footer>

</div>

</body>
</html>