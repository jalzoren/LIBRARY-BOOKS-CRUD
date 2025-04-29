<?php
include 'database.php';

if (isset($_GET['id'])) {
    $book_id = (int)$_GET['id'];

    $sql = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No ID provided.";
    exit;
}
?>

