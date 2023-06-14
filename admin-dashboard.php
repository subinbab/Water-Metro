<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 70px;
        }

        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            height: calc(100vh - 70px);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Admin Panel</a>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <h5>Dashboard</h5>
                    <ul>
                        <li><a href="/watermetro/routes.php">Routes</a></li>
                        <li><a href="/watermetro/boats.php">Boats</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="signout.php">Sign Out</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="content">
                    <h2>Welcome to the Admin Dashboard!</h2>
                    <p>This is the main content area of the admin dashboard page.</p>
                    <!-- Add your dashboard content here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
