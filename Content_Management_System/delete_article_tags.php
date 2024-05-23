<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($artid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($artid)">Confirm</button>
            <button onclick="returnToArticletags()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(artid) {
        window.location.href = '?article_tag_id=' + artid + '&confirm=yes';
    }
    function returnToCategories() {
        window.location.href = 'article_tags.php';
    }
    </script>
HTML;
}

// Check if article_tag_idd is set
if(isset($_REQUEST['article_tag_id'])) {
    $artid = $_REQUEST['article_tag_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM article_tags WHERE article_tag_id=?");
        $stmt->bind_param("i", $artid);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'article_tags.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "'); window.location.href = 'article_tags.php';</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($artid);
    }
} else {
    echo "<script>alert('article_tag_id is not set.'); window.location.href = 'article_tags.php';</script>";
}

$connection->close();
?>
