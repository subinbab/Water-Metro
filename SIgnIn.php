<?php
session_start();

// Database connection details
$servername = "localhost";  // Replace with your database server name
$username = "root";    // Replace with your database username
$password = "";    // Replace with your database password
$dbname = "watermetro";      // Replace with your database name

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    // SQL query to check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User found, set session variables and redirect to a protected page
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['Id'];
        $_SESSION['loggedin'] = true;
        echo $row['Id'];
        $_SESSION['username'] = $row['name'];
        header("Location: welcome.php");
        $error = "Invalid email or password.";
        exit();
    } else {
        // Invalid credentials, display an error message
        $error = "Invalid email or password.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>
<body>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <!-- <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <input type="submit" name="submit" value="Sign In">
    </form> -->
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Sign In</h2>
                        <?php if (isset($error)) { ?>
                            <p class="text-danger text-center"><?php echo $error; ?></p>
                        <?php } ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary" name="submit" value="Sign In">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</body>
</html>