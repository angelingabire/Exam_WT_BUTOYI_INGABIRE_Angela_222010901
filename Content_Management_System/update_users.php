<?php
include('database_connection.php');

// Check if user_id is set in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    // Fetch user details based on user_id
    $stmt_user = $connection->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    
    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $username = $row_user['username'];
        $email = $row_user['email'];
        $password = $row_user['password'];
        $registration_date = $row_user['registration_date'];
    } else {
        echo "<script>alert('User not found.'); window.location.href = 'users.php';</script>";
        exit(); // Exit if user not found
    }
} else {
    echo "<script>alert('User ID not provided.'); window.location.href = 'users.php';</script>";
    exit(); // Exit if user_id is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>
    <h1>Update User</h1>
    <form method="post">
        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" readonly><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required><br><br>

        <label for="registration_date">Registration Date:</label>
        <input type="date" id="registration_date" name="registration_date" value="<?php echo htmlspecialchars($registration_date); ?>" readonly><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Set parameters and execute
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE users SET username=?, email=?, password=? WHERE user_id=?");
        $stmt_update->bind_param("sssi", $username, $email, $password, $user_id);

        if ($stmt_update->execute()) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'users.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
