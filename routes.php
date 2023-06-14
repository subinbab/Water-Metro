<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input values
    $placeName = $_POST['placeName'];
    $previousPlaceName = $_POST['previousPlaceName'];
    $nextPlaceName = $_POST['nextPlaceName'];
    $distanceFromPrevious = $_POST['distanceFromPrevious'];
    $distanceToNext = $_POST['distanceToNext'];

    // Create a PDO connection to the database
    $host = 'localhost';
    $dbname = 'watermetro';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to insert data into the Routes table
        $stmt = $pdo->prepare("INSERT INTO Routes (placeName, previousPlaceName, nextPlaceName, distanceFromPrevious, distanceToNext)
                                VALUES (:placeName, :previousPlaceName, :nextPlaceName, :distanceFromPrevious, :distanceToNext)");

        // Bind the parameters with the input values
        $stmt->bindParam(':placeName', $placeName);
        $stmt->bindParam(':previousPlaceName', $previousPlaceName);
        $stmt->bindParam(':nextPlaceName', $nextPlaceName);
        $stmt->bindParam(':distanceFromPrevious', $distanceFromPrevious);
        $stmt->bindParam(':distanceToNext', $distanceToNext);

        // Execute the SQL statement
        $stmt->execute();

        // Redirect to a success page or do any further processing
        header('Location: success.php');
        exit();
    } catch (PDOException $e) {
        // Handle the exception in case of any database error
        echo 'Error: ' . $e->getMessage();
    }
}
?>
<?php
// Create a PDO connection to the database
$host = 'localhost';
    $dbname = 'watermetro';
    $username = 'root';
    $password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the list of routes from the Routes table
    $stmt = $pdo->query("SELECT * FROM Routes");
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle the exception in case of any database error
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOC

<!DOCTYPE html>
<html>
<head>
    <title>Routes</title>
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
                    <h2>Routes</h2>
                    <form method="POST" action="save_route.php" class="col-md-6">
                        <div class="form-group">
                            <label for="placeName">Place Name:</label>
                            <input type="text" class="form-control" id="placeName" name="placeName" required>
                        </div>
                        <div class="form-group">
                            <label for="previousPlaceName">Previous Place Name:</label>
                            <input type="text" class="form-control" id="previousPlaceName" name="previousPlaceName" required>
                        </div>
                        <div class="form-group">
                            <label for="nextPlaceName">Next Place Name:</label>
                            <input type="text" class="form-control" id="nextPlaceName" name="nextPlaceName" required>
                        </div>
                        <div class="form-group">
                            <label for="distanceFromPrevious">Distance from Previous:</label>
                            <input type="number" class="form-control" id="distanceFromPrevious" name="distanceFromPrevious" required>
                        </div>
                        <div class="form-group">
                            <label for="distanceToNext">Distance to Next:</label>
                            <input type="number" class="form-control" id="distanceToNext" name="distanceToNext" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <!-- Add your Routes content here -->
                </div>
                <div>
                <?php if (!empty($routes)): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Place Name</th>
                                    <th>Previous Place Name</th>
                                    <th>Next Place Name</th>
                                    <th>Distance from Previous</th>
                                    <th>Distance to Next</th>
                                    <th>Edit</th>
                                <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($routes as $route): ?>
                                    <tr>
                                        <td><?php echo $route['placeName']; ?></td>
                                        <td><?php echo $route['previousPlaceName']; ?></td>
                                        <td><?php echo $route['nextPlaceName']; ?></td>
                                        <td><?php echo $route['distanceFromPrevious']; ?></td>
                                        <td><?php echo $route['distanceToNext']; ?></td>
                                        <td>
                                            <a href="edit_route.php?id=<?php echo $route['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="delete_route.php?id=<?php echo $route['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No routes found.</p>
                    <?php endif; ?>
    </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
