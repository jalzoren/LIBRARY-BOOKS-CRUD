<?php
include 'database.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $book_id = (int)$_GET['id'];

    $stmt = $conn->prepare("DELETE FROM books WHERE book_id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        header("Location: /CRUD_FLAVIER/crud_flavier/index.php"); // Correctly add a semicolon here
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No book ID specified.";
}

$conn->close();
?>
