<?php
// Connection details
include('database_connection.php');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving form data
    $UserID = $_POST['user_id'];
    $Username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $UserType = $_POST['registration_date'];
    
    // Preparing SQL query
    $sql = "INSERT INTO users (user_id, username, email, password, registration_date) 
    VALUES ('$user_id', '$username', '$email', '$password', '$registration_date')";

    // Executing SQL query
    if ($connection->query($sql) === TRUE) {
        // Redirecting to login page on successful registration
        header("Location: login.html");
        exit();
    } else {
        // Displaying error message if query execution fails
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Closing database connection
$connection->close();
?>
