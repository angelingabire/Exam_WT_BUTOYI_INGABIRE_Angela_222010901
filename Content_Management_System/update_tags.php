<?php
include('database_connection.php');

// Check if tag_id is set in the URL
if(isset($_GET['tag_id'])) {
    $tag_id = $_GET['tag_id'];
    
    // Fetch role details based on tag_id
    $stmt_role = $connection->prepare("SELECT * FROM tags WHERE  tag_id = ?");
    $stmt_role->bind_param("i", $tag_id);
    $stmt_role->execute();
    $result_role = $stmt_role->get_result();
    
    if($result_role->num_rows > 0) {
        $row_role = $result_role->fetch_assoc();
        $tag_name = $row_role['tag_name'];
    } else {
        echo "<script>alert('tags not found.'); window.location.href = 'tags.php';</script>";
        exit(); // Exit if role not found
    }
} else {
    echo "<script>alert('tag_id not provided.'); window.location.href = 'tags.php';</script>";
    exit(); // Exit if tag_id is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update tags</title>
</head>
<body>
    <h1>Update tags</h1>
    <form method="post">
        <label for="tag_id">tag_id:</label>
        <input type="text" id="tag_id" name="tag_id" value="<?php echo htmlspecialchars($tag_id); ?>" readonly><br><br>

        <label for="tag_name">tag_name:</label>
        <input type="text" id="tag_name" name="tag_name" value="<?php echo htmlspecialchars($tag_name); ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE tags SET tag_name=? WHERE tag_id=?");
        $stmt_update->bind_param("si", $tag_name, $tag_id);

        // Set parameters and execute
        $tag_name = $_POST['tag_name'];
        
        if ($stmt_update->execute()) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'tags.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
