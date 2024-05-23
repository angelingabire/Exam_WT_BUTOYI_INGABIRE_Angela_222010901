<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($image_id) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($image_id)">Confirm</button>
            <button onclick="returnToImages()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(image_id) {
        window.location.href = '?image_id=' + image_id + '&confirm=yes';
    }
    function returnToImages() {
        window.location.href = 'images.php';
    }
    </script>
HTML;
}

// Check if image_id is set
if(isset($_GET['image_id'])) {
    $image_id = $_GET['image_id'];
    
    // Check for confirmation response
    if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM images WHERE image_id=?");
        $stmt->bind_param("i", $image_id);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'images.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "'); window.location.href = 'images.php';</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($image_id);
    }
} else {
    echo "<script>alert('image_id is not set.'); window.location.href = 'images.php';</script>";
}

$connection->close();
?>
