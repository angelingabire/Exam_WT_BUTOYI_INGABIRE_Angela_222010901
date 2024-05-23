<?php
include('database_connection.php');

// Check if comment_id is set in the URL
if(isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];
    
    // Fetch comment details based on comment_id
    $stmt_comment = $connection->prepare("SELECT * FROM comments WHERE comment_id = ?");
    $stmt_comment->bind_param("i", $comment_id);
    $stmt_comment->execute();
    $result_comment = $stmt_comment->get_result();
    
    if($result_comment->num_rows > 0) {
        $row_comment = $result_comment->fetch_assoc();
        $article_id = $row_comment['article_id'];
        $user_id = $row_comment['user_id'];
        $content = $row_comment['content'];
        $created_at = $row_comment['created_at'];
    } else {
        exitWithError("Comment not found.");
    }
} else {
    exitWithError("Comment ID not provided.");
}

// Function to safely exit with an error message
function exitWithError($errorMessage) {
    echo "<script>alert('$errorMessage'); window.location.href = 'comments.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Comment</title>
</head>
<body>
    <h1>Update Comment</h1>
    <form method="post">
        <label for="comment_id">Comment ID:</label>
        <input type="number" id="comment_id" name="comment_id" value="<?= htmlspecialchars($comment_id); ?>" readonly><br><br>

        <label for="article_id">Article ID:</label>
        <input type="number" id="article_id" name="article_id" value="<?= htmlspecialchars($article_id); ?>" readonly><br><br>

        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" value="<?= htmlspecialchars($user_id); ?>" readonly><br><br>

        <label for="content">Content:</label>
        <textarea id="content" name="content" required><?= htmlspecialchars($content); ?></textarea><br><br>

        <label for="created_at">Created At:</label>
        <input type="date" id="created_at" name="created_at" value="<?= htmlspecialchars($created_at); ?>" readonly><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE comments SET content=? WHERE comment_id=?");
        $stmt_update->bind_param("si", $_POST['content'], $comment_id);

        // Execute the update statement
        if ($stmt_update->execute()) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'comments.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
