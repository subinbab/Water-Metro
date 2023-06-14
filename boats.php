<?php
// Place this code at the beginning of the boats.php file to check if the user is logged in
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: index.php');
    exit();
}

$host = 'localhost';
$dbname = 'watermetro';
$username = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize the input values
        $name = $_POST['name'];
        $seatCapacity = $_POST['seatCapacity'];
        $type = $_POST['type'];
        $registrationNumber = $_POST['registrationNumber'];

        // Insert the boat data into the boats table
        $stmt = $pdo->prepare("INSERT INTO boats (name, seat_capacity, type, registration_number) VALUES (:name, :seatCapacity, :type, :registrationNumber)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':seatCapacity', $seatCapacity);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':registrationNumber', $registrationNumber);
        $stmt->execute();

        // Redirect to the boats page
        header('Location: boats.php');
        exit();
    }
} catch (PDOException $e) {
    // Handle the exception in case of any database error
    echo 'Error: ' . $e->getMessage();
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the boats data from the boats table
    $stmt = $pdo->query("SELECT * FROM boats");
    $boats = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle the exception in case of any database error
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boats</title>
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="welcome.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="routes.php">Routes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="boats.php">Boats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
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
            <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h2>Add Boat</h2>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="seatCapacity">Seat Capacity</label>
                            <input type="number" class="form-control" id="seatCapacity" name="seatCapacity" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" class="form-control" id="type" name="type" required>
                        </div>
                        <div class="form-group">
                            <label for="registrationNumber">Registration Number</label>
                            <input type="text" class="form-control" id="registrationNumber" name="registrationNumber" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
                <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Seat Capacity</th>
                                <th>Type</th>
                                <th>Registration Number</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($boats as $boat) { ?>
                                <tr>
                                    <td><?php echo $boat['name']; ?></td>
                                    <td><?php echo $boat['seat_capacity']; ?></td>
                                    <td><?php echo $boat['type']; ?></td>
                                    <td><?php echo $boat['registration_number']; ?></td>
                                    <td><a href="edit_boat.php?id=<?php echo $boat['id']; ?>">Edit</a></td>
                                    <td><a href="delete_boat.php?id=<?php echo $boat['id']; ?>" onclick="return confirm('Are you sure you want to delete this boat?')">Delete</a></td>
                                
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
        </div>
    </div>
    

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
