<?php
include('database_connection.php');

// Check if the query parameter is set
if (isset($_GET['query'])) {
    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'articles' => "SELECT article_name FROM articles WHERE article_name LIKE '%$searchTerm%'",
        'article_tags' => "SELECT article_id FROM article_tags WHERE article_id LIKE '%$searchTerm%'",
        'categories' => "SELECT category_name FROM categories WHERE category_name LIKE '%$searchTerm%'",
        'comments' => "SELECT content FROM comments WHERE content LIKE '%$searchTerm%'",
        'images' => "SELECT image_url FROM images WHERE image_url LIKE '%$searchTerm%'",
        'likes' => "SELECT like_id FROM likes WHERE like_id LIKE '%$searchTerm%'",
        'roles' => "SELECT role_id FROM roles WHERE role_id LIKE '%$searchTerm%'",
        'tags' => "SELECT tag_id FROM tags WHERE tag_id LIKE '%$searchTerm%'",
        'users' => "SELECT username FROM users WHERE username LIKE '%$searchTerm%'",
        'user_roles' => "SELECT user_role_id FROM user_roles WHERE user_role_id LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($row[array_keys($row)[0]]) . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '" . htmlspecialchars($searchTerm) . "'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
