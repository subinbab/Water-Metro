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
