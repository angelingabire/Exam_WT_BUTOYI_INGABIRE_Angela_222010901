<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our Articles</title>
  <style>
/* Table style */
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: pink;
    }

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
    <ul>
    <li><img src="./Images/logo.jpg" width="90" height="60" alt="Logo"></li>

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
  <h1><u>Articles Form</u></h1>
  <form method="post" onsubmit="return confirmInsert();">
    <label for="article_id">Article ID:</label>
    <input type="number" id="article_id" name="article_id" required><br><br>

    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="content">Content:</label>
    <input type="text" id="content" name="content" required><br><br>

    <label for="category_id">Category ID:</label>
    <input type="number" id="category_id" name="category_id" required><br><br>

    <label for="user_id">User ID:</label>
    <input type="number" id="user_id" name="user_id" required><br><br>

    <label for="created_at">Created At:</label>
    <input type="date" id="created_at" name="created_at" required><br><br>

    <input type="submit" name="add" value="Insert">
  </form>
</section>

<?php
// Connection details
include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO articles(article_id, title, content, category_id, user_id, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssis", $article_id, $title, $content, $category_id, $user_id, $created_at);

    // Set parameters and execute
    $article_id = $_POST['article_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $user_id = $_POST['user_id'];
    $created_at = $_POST['created_at'];

    if ($stmt->execute()) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>

<section>
  <center><h2>Table of Articles</h2></center>
  <table border="1">
    <tr>
      <th>Article ID</th>
      <th>Title</th>
      <th>Content</th>
      <th>Category ID</th>
      <th>User ID</th>
      <th>Created At</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
    // Connection details
    include('database_connection.php');

    // SQL query to fetch data from the articles table
    $sql = "SELECT * FROM articles";
    $result = $connection->query($sql);

    // Check if there are any articles
    if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            $article_id = $row['article_id'];
            echo "<tr>
                <td>" . $row['article_id'] . "</td>
                <td>" . $row['title'] . "</td>
                <td>" . $row['content'] . "</td>
                <td>" . $row['category_id'] . "</td>
                <td>" . $row['user_id'] . "</td>
                <td>" . $row['created_at'] . "</td>
                <td><a href='delete_articles.php?article_id=$article_id'>Delete</a></td>
                <td><a href='update_articles.php?article_id=$article_id'>Update</a></td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No data found</td></tr>";
    }
    $connection->close();
    ?>
  </table>
</section>

<footer>
  <center>
    <b><h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Angela BUTOYI INGABIRE</h2></b>
  </center>
</footer>
</body>
</html>
