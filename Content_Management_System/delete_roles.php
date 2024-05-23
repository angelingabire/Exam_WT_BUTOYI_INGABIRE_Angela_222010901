<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($role_id) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($role_id)">Confirm</button>
            <button onclick="returnToRoles()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(role_id) {
        window.location.href = '?role_id=' + role_id + '&confirm=yes';
    }
    function returnToRoles() {
        window.location.href = 'roles.php';
    }
    </script>
HTML;
}

// Check if role_id is set
if(isset($_REQUEST['role_id'])) {
    $role_id = $_REQUEST['role_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM roles WHERE role_id=?");
        $stmt->bind_param("i", $role_id);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'roles.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "'); window.location.href = 'roles.php';</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($role_id);
    }
} else {
    echo "<script>alert('Role ID is not set.'); window.location.href = 'roles.php';</script>";
}

$connection->close();
?>
