<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($article_id) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($article_id)">Confirm</button>
            <button onclick="returnToArticles()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(article_id) {
        window.location.href = '?article_id=' + article_id + '&confirm=yes';
    }
    function returnToArticles() {
        window.location.href = 'articles.php';
    }
    </script>
HTML;
}

// Check if article_id is set
if(isset($_REQUEST['article_id'])) {
    $cid = $_REQUEST['article_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM articles WHERE article_id=?");
        $stmt->bind_param("i", $arid);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'articles.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($article_id);
    }
} else {
    echo "<script>alert('article_id is not set.'); window.location.href = 'articles.php';</script>";
}

$connection->close();
?>
