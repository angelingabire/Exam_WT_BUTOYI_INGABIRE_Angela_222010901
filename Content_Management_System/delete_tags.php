<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($tag_id) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($tag_id)">Confirm</button>
            <button onclick="returnToTags()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(tag_id) {
        window.location.href = '?tag_id=' + tag_id + '&confirm=yes';
    }
    function returnToTags() {
        window.location.href = 'tags.php';
    }
    </script>
HTML;
}

// Check if tag_id is set
if(isset($_REQUEST['tag_id'])) {
    $tag_id = $_REQUEST['tag_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM tags WHERE tag_id=?");
        $stmt->bind_param("i", $tag_id);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'tags.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "'); window.location.href = 'tags.php';</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($tag_id);
    }
} else {
    echo "<script>alert('Tag ID is not set.'); window.location.href = 'tags.php';</script>";
}

$connection->close();
?>
