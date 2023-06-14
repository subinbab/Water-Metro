<?php
// Create a PDO connection to the database
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
        $id = $_POST['id'];
        $placeName = $_POST['placeName'];
        $previousPlaceName = $_POST['previousPlaceName'];
        $nextPlaceName = $_POST['nextPlaceName'];
        $distanceFromPrevious = $_POST['distanceFromPrevious'];
        $distanceToNext = $_POST['distanceToNext'];

        // Update the route in the Routes table
        $stmt = $pdo->prepare("UPDATE Routes SET placeName = :placeName, previousPlaceName = :previousPlaceName, nextPlaceName = :nextPlaceName, distanceFromPrevious = :distanceFromPrevious, distanceToNext = :distanceToNext WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':placeName', $placeName);
        $stmt->bindParam(':previousPlaceName', $previousPlaceName);
        $stmt->bindParam(':nextPlaceName', $nextPlaceName);
        $stmt->bindParam(':distanceFromPrevious', $distanceFromPrevious);
        $stmt->bindParam(':distanceToNext', $distanceToNext);
        $stmt->execute();

        // Redirect to the routes list page
        header('Location: routes.php');
        exit();
    } else {
        // Check if the route ID is provided
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Fetch the route data from the Routes table based on the provided ID
            $stmt = $pdo->prepare("SELECT * FROM Routes WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $route = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the route exists
            if (!$route) {
                echo 'Route not found.';
                exit();
            }
        } else {
            echo 'Route ID not provided.';
            exit();
        }
    }
} catch (PDOException $e) {
    // Handle the exception in case of any database error
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Route</title>
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
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h2>Edit Route</h2>
                    <form method="POST" action="edit_route.php">
                        <input type="hidden" name="id" value="<?php echo $route['id']; ?>">
                        <div class="form-group">
                            <label for="placeName">Place Name</label>
                            <input type="text" class="form-control" id="placeName" name="placeName" value="<?php echo $route['placeName']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="previousPlaceName">Previous Place Name</label>
                            <input type="text" class="form-control" id="previousPlaceName" name="previousPlaceName" value="<?php echo $route['previousPlaceName']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nextPlaceName">Next Place Name</label>
                            <input type="text" class="form-control" id="nextPlaceName" name="nextPlaceName" value="<?php echo $route['nextPlaceName']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="distanceFromPrevious">Distance from Previous</label>
                            <input type="text" class="form-control" id="distanceFromPrevious" name="distanceFromPrevious" value="<?php echo $route['distanceFromPrevious']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="distanceToNext">Distance to Next</label>
                            <input type="text" class="form-control" id="distanceToNext" name="distanceToNext" value="<?php echo $route['distanceToNext']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="routes.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
