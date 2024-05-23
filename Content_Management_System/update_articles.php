<?php
include('database_connection.php');

// Check if article_id is set in the URL
if(isset($_GET['article_id'])) {
    $article_id = $_GET['article_id'];
    
    // Fetch category details based on article_id
    $stmt_category = $connection->prepare("SELECT * FROM articles WHERE article_id = ?");
    $stmt_category->bind_param("i", $article_id);
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();
    
    if($result_category->num_rows > 0) {
        $row_category = $result_category->fetch_assoc();
        $article_id = $row_category['article_id'];
        $title = $row_category['title'];
        $content = $row_category['content'];
        $category_id = $row_category['category_id'];
        $user_id = $row_category['user_id'];
        $created_at = $row_category['created_at'];
    } else {
        exitWithError("Article tag not found.");
    }
} else {
    exitWithError("article_id not provided.");
}

// Function to safely exit with an error message
function exitWithError($errorMessage) {
    echo "<script>alert('$errorMessage'); window.location.href = 'articles.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update  articles</title>
</head>
<body>
    <h1>Update articles</h1>
    <form method="post">
        <label for="article_id">Article ID:</label>
        <input type="text" id="article_id" name="article_id" value="<?= htmlspecialchars($article_id); ?>" required><br><br>

        <label for="title">title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($title); ?>" required><br><br>
         <label for="content">content:</label>
        <input type="text" id="content" name="content" value="<?= htmlspecialchars($content); ?>" required><br><br>
         <label for="category_id">category_id:</label>
        <input type="text" id="category_id" name="category_id" value="<?= htmlspecialchars($category_id); ?>" required><br><br>
         <label for="user_id">user_id:</label>
        <input type="text" id="user_id" name="user_id" value="<?= htmlspecialchars($user_id); ?>" required><br><br>
         <label for="created_at">created_at:</label>
        <input type="date" id="created_at" name="created_at" value="<?= htmlspecialchars($created_at); ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE  articles SET title=?,content=?,category_id=?,user_id=?,created_at=? WHERE article_id=?");
        $stmt_update->bind_param("ssiiss",$title ,$content ,$category_id ,$user_id, $created_at, $article_id);

        // Execute the update statement
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category_id = $_POST['category_id'];
        $user_id = $_POST['user_id'];
        $created_at = $_POST['created_at'];

        if ($stmt_update->execute()) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'articles.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
