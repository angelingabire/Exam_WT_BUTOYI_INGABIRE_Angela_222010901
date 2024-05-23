<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($lkid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($lkid)">Confirm</button>
            <button onclick="returnToLikes()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(lkid) {
        window.location.href = '?like_id=' + lkid + '&confirm=yes';
    }
    function returnToCategories() {
        window.location.href = 'likes.php';
    }
    </script>
HTML;
}

// Check if like_id is set
if(isset($_REQUEST['like_id'])) {
    $lkid = $_REQUEST['like_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM likes WHERE like_id=?");
        $stmt->bind_param("i", $lkid);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'likes.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "'); window.location.href = 'likes.php';</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($lkid);
    }
} else {
    echo "<script>alert('like_id is not set.'); window.location.href = 'likes.php';</script>";
}

$connection->close();
?>
