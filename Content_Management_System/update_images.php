<?php
include('database_connection.php');

// Check if image_id is set in the URL
if(isset($_GET['image_id'])) {
    $iid = $_GET['image_id'];
    
    // Fetch image details based on image_id
    $stmt_image = $connection->prepare("SELECT * FROM images WHERE image_id = ?");
    $stmt_image->bind_param("i", $iid);
    $stmt_image->execute();
    $result_image = $stmt_image->get_result();
    
    if($result_image->num_rows > 0) {
        $row_image = $result_image->fetch_assoc();
        $image_url = $row_image['image_url'];
        $article_id = $row_image['article_id'];
    } else {
        echo "<script>alert('Image not found.'); window.location.href = 'images.php';</script>";
        exit(); // Exit if image not found
    }
} else {
    echo "<script>alert('Image ID not provided.'); window.location.href = 'images.php';</script>";
    exit(); // Exit if image_id is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Image</title>
</head>
<body>
    <h1>Update Image</h1>
    <form method="post">
        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($image_url); ?>" required><br><br>

        <label for="article_id">Article ID:</label>
        <input type="text" id="article_id" name="article_id" value="<?php echo htmlspecialchars($article_id); ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE images SET image_url=?, article_id=? WHERE image_id=?");
        $stmt_update->bind_param("ssi", $image_url, $article_id, $iid);

        // Set parameters and execute
        $image_url = $_POST['image_url'];
        $article_id = $_POST['article_id'];
        
        if ($stmt_update->execute() == TRUE) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'images.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
