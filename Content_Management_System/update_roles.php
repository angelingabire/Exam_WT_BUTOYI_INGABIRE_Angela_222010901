<?php
include('database_connection.php');

// Check if role_id is set in the URL
if(isset($_GET['role_id'])) {
    $role_id = $_GET['role_id'];
    
    // Fetch role details based on role_id
    $stmt_role = $connection->prepare("SELECT * FROM roles WHERE role_id = ?");
    $stmt_role->bind_param("i", $role_id);
    $stmt_role->execute();
    $result_role = $stmt_role->get_result();
    
    if($result_role->num_rows > 0) {
        $row_role = $result_role->fetch_assoc();
        $role_name = $row_role['role_name'];
    } else {
        echo "<script>alert('Role not found.'); window.location.href = 'roles.php';</script>";
        exit(); // Exit if role not found
    }
} else {
    echo "<script>alert('Role ID not provided.'); window.location.href = 'roles.php';</script>";
    exit(); // Exit if role_id is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Role</title>
</head>
<body>
    <h1>Update Role</h1>
    <form method="post">
        <label for="role_id">Role ID:</label>
        <input type="text" id="role_id" name="role_id" value="<?php echo htmlspecialchars($role_id); ?>" readonly><br><br>

        <label for="role_name">Role Name:</label>
        <input type="text" id="role_name" name="role_name" value="<?php echo htmlspecialchars($role_name); ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE roles SET role_name=? WHERE role_id=?");
        $stmt_update->bind_param("si", $role_name, $role_id);

        // Set parameters and execute
        $role_name = $_POST['role_name'];
        
        if ($stmt_update->execute()) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'roles.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
