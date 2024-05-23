<?php
include('database_connection.php');

// Check if user_role_id is set in the URL
if (isset($_GET['user_role_id'])) {
    $user_role_id = $_GET['user_role_id'];
    
    // Fetch role details based on user_role_id
    $stmt_role = $connection->prepare("SELECT * FROM user_roles WHERE user_role_id = ?");
    $stmt_role->bind_param("i", $user_role_id);
    $stmt_role->execute();
    $result_role = $stmt_role->get_result();
    
    if ($result_role->num_rows > 0) {
        $row_role = $result_role->fetch_assoc();
        $user_id = $row_role['user_id'];
        $role_id = $row_role['role_id'];
    } else {
        echo "<script>alert('user_roles not found.'); window.location.href = 'user_roles.php';</script>";
        exit(); // Exit if role not found
    }
} else {
    echo "<script>alert('user_role_id not provided.'); window.location.href = 'user_roles.php';</script>";
    exit(); // Exit if user_role_id is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update user_roles</title>
</head>
<body>
    <h1>Update user_roles</h1>
    <form method="post">
        <label for="user_role_id">user_role_id:</label>
        <input type="text" id="user_role_id" name="user_role_id" value="<?php echo htmlspecialchars($user_role_id); ?>" readonly><br><br>

        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" required><br><br>

        <label for="role_id">Role ID:</label>
        <input type="text" id="role_id" name="role_id" value="<?php echo htmlspecialchars($role_id); ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Set parameters and execute
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];
        
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE user_roles SET user_id=?, role_id=? WHERE user_role_id=?");
        $stmt_update->bind_param("iii", $user_id, $role_id, $user_role_id);

        if ($stmt_update->execute()) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'user_roles.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
