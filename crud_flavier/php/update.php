<?php
include 'database.php'; // Make sure the path is correct

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['book_id'])) {
    $book_id = (int)$_POST['book_id'];
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre = trim($_POST['genre']);
    $year_published = trim($_POST['year_published']);
    $status = trim($_POST['status']);

    if ($title && $author && $genre && $year_published && $status) {
        $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, genre = ?, year_published = ?, status = ? WHERE book_id = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssssi", $title, $author, $genre, $year_published, $status, $book_id);

        if ($stmt->execute()) {
            header("Location: /CRUD_FLAVIER/crud_flavier/index.php"); // Correctly add a semicolon here
            exit(); // Now properly separate with exit() after the header
        } else {
            echo "Update failed: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields must be filled.";
    }
} else {
    echo "Invalid request or missing book ID.";
}

$conn->close();
?>
