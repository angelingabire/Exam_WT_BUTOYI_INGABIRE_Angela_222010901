<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($coid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($coid)">Confirm</button>
            <button onclick="returnToComments()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(coid) {
        window.location.href = '?comment_id=' + coid + '&confirm=yes';
    }
    function returnToComments() {
        window.location.href = 'comments.php';
    }
    </script>
HTML;
}

// Check if comment_id is set
if(isset($_REQUEST['comment_id'])) {
    $coid = $_REQUEST['comment_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM comments WHERE comment_id=?");
        $stmt->bind_param("i", $coid);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'comments.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "'); window.location.href = 'comments.php';</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($coid);
    }
} else {
    echo "<script>alert('Comment ID is not set.'); window.location.href = 'comments.php';</script>";
}

$connection->close();
?>
