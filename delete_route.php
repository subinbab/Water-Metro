<?php
// Create a PDO connection to the database
$host = 'localhost';
$dbname = 'watermetro';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the route ID is provided
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Delete the route from the Routes table based on the provided ID
        $stmt = $pdo->prepare("DELETE FROM Routes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Redirect to the routes list page
        header('Location: routes.php');
        exit();
    } else {
        echo 'Route ID not provided.';
        exit();
    }
} catch (PDOException $e) {
    // Handle the exception in case of any database error
    echo 'Error: ' . $e->getMessage();
}
?>
