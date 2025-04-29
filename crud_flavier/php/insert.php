<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year_published = $_POST['year_published'];
    $status = $_POST['status'];

    // SQL query to insert the book into the database
    $sql = "INSERT INTO books (title, author, genre, year_published, status) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the query
        $stmt->bind_param("sssis", $title, $author, $genre, $year_published, $status);

        // Execute the query and handle success or failure
        if ($stmt->execute()) {
            header("Location: /CRUD_FLAVIER/crud_flavier/index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
