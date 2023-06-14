<?php
// Place this code at the beginning of the edit_boat.php file to check if the user is logged in
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: index.php');
    exit();
}

// Check if the boat ID is provided as a parameter
if (!isset($_GET['id'])) {
    // Redirect back to the boats.php page if the ID is not provided
    header('Location: boats.php');
    exit();
}

// Create a PDO connection to the database
$host = 'localhost';
$dbname = 'watermetro';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the boat details based on the provided ID
    $stmt = $pdo->prepare("SELECT * FROM boats WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $boat = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the boat with the provided ID exists
    if (!$boat) {
        // Redirect back to the boats.php page if the boat does not exist
        header('Location: boats.php');
        exit();
    }
} catch (PDOException $e) {
    // Handle the exception in case of any database error
    echo 'Error: ' . $e->getMessage();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated boat details from the form
    $name = $_POST['name'];
    $seatCapacity = $_POST['seatCapacity'];
    $type = $_POST['type'];
    $registrationNumber = $_POST['registrationNumber'];

    // Update the boat details in the database
    $stmt = $pdo->prepare("UPDATE boats SET name = :name, seat_capacity = :seatCapacity, type = :type, registration_number = :registrationNumber WHERE id = :id");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':seatCapacity', $seatCapacity, PDO::PARAM_INT);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':registrationNumber', $registrationNumber, PDO::PARAM_STR);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the boats.php page after successful update
    header('Location: boats.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Boat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 70px;
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
            <div class="col-md-6 offset-md-3">
                <div class="content">
                    <h2>Edit Boat</h2>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $boat['name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="seatCapacity">Seat Capacity:</label>
                            <input type="number" class="form-control" id="seatCapacity" name="seatCapacity" value="<?php echo $boat['seat_capacity']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="type">Type:</label>
                            <input type="text" class="form-control" id="type" name="type" value="<?php echo $boat['type']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="registrationNumber">Registration Number:</label>
                            <input type="text" class="form-control" id="registrationNumber" name="registrationNumber" value="<?php echo $boat['registration_number']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
