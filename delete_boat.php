<?php
// Place this code at the beginning of the delete_boat.php file to check if the user is logged in
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

    // Delete the boat from the database based on the provided ID
    $stmt = $pdo->prepare("DELETE FROM boats WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the boats.php page after successful deletion
    header('Location: boats.php');
    exit();
} catch (PDOException $e) {
    // Handle the exception in case of any database error
    echo 'Error: ' . $e->getMessage();
}
?>
