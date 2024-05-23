<?php
include('database_connection.php');

// Check if category_id is set in the URL
if(isset($_GET['category_id'])) {
    $cid = $_GET['category_id'];
    
    // Fetch category details based on category_id
    $stmt_category = $connection->prepare("SELECT * FROM categories WHERE category_id = ?");
    $stmt_category->bind_param("i", $cid);
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();
    
    if($result_category->num_rows > 0) {
        $row_category = $result_category->fetch_assoc();
        $category_name = $row_category['category_name'];
        $category_code = $row_category['category_code'];
    } else {
        echo "<script>alert('Category not found.'); window.location.href = 'categories.php';</script>";
        exit(); // Exit if category not found
    }
} else {
    echo "<script>alert('Category ID not provided.'); window.location.href = 'categories.php';</script>";
    exit(); // Exit if category_id is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Category</title>
</head>
<body>
    <h1>Update Category</h1>
    <form method="post">
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" value="<?php echo $category_name; ?>" required><br><br>

        <label for="category_code">Category Code:</label>
        <input type="text" id="category_code" name="category_code" value="<?php echo $category_code; ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters for update
        $stmt_update = $connection->prepare("UPDATE categories SET category_name=?, category_code=? WHERE category_id=?");
        $stmt_update->bind_param("ssi", $category_name, $category_code, $cid);

        // Set parameters and execute
        $category_name = $_POST['category_name'];
        $category_code = $_POST['category_code'];
        
        if ($stmt_update->execute() == TRUE) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'categories.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt_update->error . "');</script>";
        }
        $stmt_update->close();
    }
    $connection->close();
    ?>
</body>
</html>
