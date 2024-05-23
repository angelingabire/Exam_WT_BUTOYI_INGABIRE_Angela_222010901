<?php
include('database_connection.php');

// Check if like_id is set in the URL
if(isset($_GET['like_id'])) {
    $cid = $_GET['like_id'];
    
    // Fetch category details based on like_id
    $stmt_category = $connection->prepare("SELECT * FROM likes WHERE like_id = ?");
    $stmt_category->bind_param("i", $cid);
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();
    
    if($result_category->num_rows > 0) {
        $row_category = $result_category->fetch_assoc();
        $article_id = $row_category['article_id'];
        $user_id = $row_category['user_id'];
         $liked_at = $row_category['liked_at'];
    } else {
        echo "<script>alert('likes not found.'); window.location.href = 'likes.php';</script>";
        exit(); // Exit if category not found
    }
} else {
    echo "<script>alert('like_id not provided.'); window.location.href = 'likes.php';</script>";
    exit(); // Exit if like_idd is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update likes</title>
</head>
<body>
    <h1>Update likes</h1>
    <form method="post">
         <label for="like_idd">like_id:</label>
        <input type="number" id="like_id" name="like_id" value="<?php echo $like_id; ?>" required><br><br>
        <label for="article_id">article_id:</label>
        <input type="number" id="article_id" name="article_id" value="<?php echo $article_id; ?>" required><br><br>
        <label for="user_id">user_id:</label>
        <input type="number" id="user_id" name="user_id" value="<?php echo $user_id; ?>" required><br><br>
        <label for="liked_at">liked_at:</label>
        <input type="date" id="liked_at" name="liked_at" value="<?php echo $liked_at; ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE likes SET article_id=?, user_id=?,liked_at=? WHERE like_id=?");
        $stmt_update->bind_param("ssii", $article_id, $user_id,$liked_at, $like_id);

        // Set parameters and execute
        $article_id = $_POST['article_id'];
        $user_id = $_POST['user_id'];
        $liked_at = $_POST['liked_at'];
        
        if ($stmt_update->execute() == TRUE) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'likes.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
 
