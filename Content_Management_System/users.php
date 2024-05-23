<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Users</title>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css">
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

    /* CSS styles */
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

    /* Hover effect */
    a:hover {
      background-color: white;
      color: black;
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

    /* Extend margin left for search input */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */
      padding: 8px;
    }

    section {
      padding: 71px;
      border-bottom: 1px solid #ddd;
    }

    footer {
      text-align: center;
      padding: 15px;
      background-color: darkgray;
    }
  </style>
</head>
<ul>
    <li><img src="./Images/logo.jpg" width="90" height="60" alt="Logo"></li>

<body style="background-color: #6B6B6B;">
<header>
  <!-- Search form -->
  <form class="d-flex" role="search" action="search.php">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>
  <!-- Navigation menu -->
  <ul style="list-style-type: none; padding: 0;">
    <!-- Logo -->
    <li style="display: inline; margin-right: 10px;">
      <img src="./images/bank-vector-icon.jpg" width="90" height="60" alt="Logo">
    </li>
    <!-- Menu items -->
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

    <!-- Dropdown for settings -->
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li>
  </ul>
</header>

<section>
  <h1><u>Users Form</u></h1>
  <!-- Form to add a new user -->
  <form method="post" onsubmit="return confirmInsert();">
    <label for="user_id">User ID:</label>
    <input type="number" id="user_id" name="user_id"><br><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="registration_date">Registration Date:</label>
    <input type="date" id="registration_date" name="registration_date" required><br><br>

    <input type="submit" name="add" value="Insert">
  </form>

  <?php
  // Include database connection details
  include('database_connection.php');

  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Prepare and bind parameters
      $stmt = $connection->prepare("INSERT INTO users(user_id, username, email, password, registration_date) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("issss", $user_id, $username, $email, $password, $registration_date);

      // Set parameters and execute
      $user_id = $_POST['user_id'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $registration_date = $_POST['registration_date'];
      
      if ($stmt->execute()) {
          echo "New record has been added successfully";
      } else {
          echo "Error: " . $stmt->error;
      }
      $stmt->close();
  }
  $connection->close();
  ?>

  <h2>Table of Users</h2>
  <!-- Displaying user records -->
  <table border="1">
    <tr>
      <th>User Id</th>
      <th>Username</th>
      <th>Email</th>
      <th>Password</th>
      <th>Registration Date</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
    // Include database connection details
    include('database_connection.php');

    // Prepare SQL query to retrieve all users
    $sql = "SELECT * FROM users";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $uid = $row['user_id'];
            echo "<tr>
                  <td>" . $row['user_id'] . "</td>
                  <td>" . $row['username'] . "</td>
                  <td>" . $row['email'] . "</td>
                  <td>" . $row['password'] . "</td>
                  <td>" . $row['registration_date'] . "</td>
                  <td><a style='padding:4px' href='delete_users.php?user_id=$uid'>Delete</a></td> 
                  <td><a style='padding:4px' href='update_users.php?user_id=$uid'>Update</a></td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No data found</td></tr>";
    }
    $connection->close();
    ?>
  </table>
</section>

<footer>
  <center> 
    <b><h2>UR CBE BIT &copy; 2024 &reg;, Designer by: @Angela BUTOYI INGABIRE</h2></b>
  </center>
</footer>
<!-- JavaScript validation for insert data -->
<script>
  function confirmInsert() {
      return confirm('Are you sure you want to insert this record?');
  }
</script>
</body>
</html>
