<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our Images</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: pink;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
     
    }
    section{
    padding:71px;
    border-bottom: 1px solid #ddd;
    }
    footer{
    text-align: center;
    padding: 15px;
    background-color:darkgray;
    }

  </style>
   <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
  </head>

  <header>

<body bgcolor="#808080" ;>
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./images/bank-vector-icon.jpg" width="90" height="60" alt="Logo">
  </li>
        <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./articles.php">ARTICLES</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./article_tags.php">ARTICLE TAGS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./categories.php">CATEGORIES</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./comments.php">COMMENTS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./images.php">IMAGES</a></li>
     <li style="display: inline; margin-right: 10px;"><a href="./likes.php">LIKES</a></li>
     <li style="display: inline; margin-right: 10px;"><a href="./roles.php">ROLES</a></li>
     <li style="display: inline; margin-right: 10px;"><a href="./tags.php">TAGS</a></li>
     <li style="display: inline; margin-right: 10px;"><a href="./users.php">USERS</a></li>
     <li style="display: inline; margin-right: 10px;"><a href="./user_roles.php">USER ROLES</a></li>
    
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>
</header>
<section>

    <h1><u> Images Form </u></h1>
    <form method="post" onsubmit="return confirmInsert();">
            
        <label for="image_id">Image id:</label>
        <input type="number" id="image_id" name="image_id"><br><br>

        <label for="image_url">Image url</label>
        <input type="name" id="image_url" name="image_url" required><br><br>

        <label for="article_id">Article id:</label>
        <input type="number" id="article_id" name="article_id" required><br><br>

        <input type="submit" name="add" value="Insert">
      

    </form>


<?php
// Connection details
include('database_connection.php');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO images(image_id,image_url,article_id) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $image_id, $image_url,$article_id);
    // Set parameters and execute
    $image_id= $_POST['image_id'];
    $image_url = $_POST['image_url'];
    $article_id = $_POST['article_id'];
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>

<?php
// Connection details
include('database_connection.php');

// SQL query to fetch data from the images table
$sql = "SELECT * FROM images";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of Categories</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Table of Images</h2></center>
    <table border="6">
        <tr>
            <th>Image id</th>
            <th>Image url</th>
            <th>Article id</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Define connection parameters
        include('database_connection.php');


        // Prepare SQL query to retrieve all images
        $sql = "SELECT * FROM images";
        $result = $connection->query($sql);

        // Check if there are any categories
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $image_id = $row['image_id']; // Fetch the image_id
                echo "<tr>
                    <td>" . $row['image_id'] . "</td>
                    <td>" . $row['image_url'] . "</td>
                    <td>" . $row['article_id'] . "</td>
                    <td><a style='padding:4px' href='delete_images.php?image_id=$image_id'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_images.php?image_id=$image_id'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
</body>

    </section>


  
<footer>
  <center> 
    <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by: @Angela BUTOYI INGABIRE</h2></b>
  </center>
</footer>
</body>
</html> 