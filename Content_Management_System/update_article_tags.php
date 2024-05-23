<?php
include('database_connection.php');

// Check if article_tag_id is set in the URL
if(isset($_GET['article_tag_id'])) {
    $article_tag_id = $_GET['article_tag_id'];
    
    // Fetch category details based on article_tag_id
    $stmt_category = $connection->prepare("SELECT * FROM article_tags WHERE article_tag_id = ?");
    $stmt_category->bind_param("i", $article_tag_id);
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();
    
    if($result_category->num_rows > 0) {
        $row_category = $result_category->fetch_assoc();
        $article_id = $row_category['article_id'];
        $tag_id = $row_category['tag_id'];
    } else {
        exitWithError("Article tag not found.");
    }
} else {
    exitWithError("Article tag ID not provided.");
}

// Function to safely exit with an error message
function exitWithError($errorMessage) {
    echo "<script>alert('$errorMessage'); window.location.href = 'article_tags.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update article_tags</title>
</head>
<body>
    <h1>Update article_tags</h1>
    <form method="post">
        <label for="article_id">Article ID:</label>
        <input type="text" id="article_id" name="article_id" value="<?= htmlspecialchars($article_id); ?>" required><br><br>

        <label for="tag_id">Tag ID:</label>
        <input type="text" id="tag_id" name="tag_id" value="<?= htmlspecialchars($tag_id); ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE article_tags SET article_id=?, tag_id=? WHERE article_tag_id=?");
        $stmt_update->bind_param("ssi", $_POST['article_id'], $_POST['tag_id'], $article_tag_id);

        // Execute the update statement
        if ($stmt_update->execute()) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'article_tags.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
