<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year_published = $_POST['year_published'];
    $status = $_POST['status'];

    $sql = "INSERT INTO books (title, author, genre, year_published, status) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssis", $title, $author, $genre, $year_published, $status);

        if ($stmt->execute()) {
            header("Location: /CRUD_FLAVIER/crud_flavier/index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
