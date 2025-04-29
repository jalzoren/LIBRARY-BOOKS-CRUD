<?php
include '../crud_flavier/php/database.php';

$edit_mode = false;
$edit_book = [
    'book_id' => '',
    'title' => '',
    'author' => '',
    'genre' => '',
    'year_published' => '',
    'status' => 'Available'
];

// Check if we're in edit mode
if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $edit_id = (int)$_GET['edit_id'];

    // Get the book details from the database to prefill the form
    $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $edit_book = $result->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PLP LIBRARY MANAGEMENT RECORDS</title>
    <link rel="stylesheet" href="../crud_flavier/css/style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>

  <body>
    <div class="container">
      <form method="get" action="index.php">
        <div class="header">
          <h2>Library Management System</h2>
          <i class="bx bxs-info-circle"></i>
        </div>
        <hr />
      </form>
<!--
                <div class="categories">
          <label for="title">Search Book Records:</label>
          <input class="search-recs"
                type="text"
                id="search-recs"
                name="title"
                placeholder="Search the Title of the Book:" />
          
          <button class="search" type="submit"> <i class='bx bx-search-alt-2'></i>Search</button>
        </div>
-->
<form action="../crud_flavier/php/<?php echo $edit_mode ? 'update.php' : 'insert.php'; ?>" method="post" id="bookForm">
    <?php if ($edit_mode): ?>
        <input type="hidden" name="book_id" value="<?php echo $edit_book['book_id']; ?>">
    <?php endif; ?>

    <div class="form-grid">
        <div class="form-group">
            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter the Title of the Book" required value="<?php echo htmlspecialchars($edit_book['title']); ?>" />
        </div>

        <div class="form-group">
            <label for="author">Book Author:</label>
            <input type="text" id="author" name="author" placeholder="Enter the Author Name" required value="<?php echo htmlspecialchars($edit_book['author']); ?>" />
        </div>

        <div class="form-group">
            <label for="status">Book Status:</label>
            <select id="status" name="status" required>
                <option value="Available" <?php echo $edit_book['status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                <option value="Borrowed" <?php echo $edit_book['status'] == 'Borrowed' ? 'selected' : ''; ?>>Borrowed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="genre">Book Genre:</label>
            <input type="text" id="genre" name="genre" placeholder="Enter the Book Genre" required value="<?php echo htmlspecialchars($edit_book['genre']); ?>" />
        </div>

        <div class="form-group">
            <label for="year">Year Published:</label>
            <input type="number" id="year" name="year_published" placeholder="Enter the Year Published" min="1000" max="<?php echo date('Y'); ?>" required value="<?php echo htmlspecialchars($edit_book['year_published']); ?>" />
        </div>

        <div class="form-group button">
            <button type="submit" class="submit" id="addBookBtn">
                <?php echo $edit_mode ? 'Update Book' : '+ Add Book Record'; ?>
            </button>
        </div>
    </div>
</form>


      <div class="data">
        <table class="styled-table" id="dataTable">
          <thead>
            <tr>
              <th>BookID</th>
              <th>Title</th>
              <th>Author</th>
              <th>Genre</th>
              <th>Year Published</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include '../crud_flavier/php/database.php';

            $sql = "SELECT book_id, title, author, genre, year_published, status FROM books ORDER BY book_id ASC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['book_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['author']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row['genre']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row['year_published']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row['status']) . "</td>"; 
                echo "<td class='action-cell'>";
                echo "<button onclick=\"window.location.href='index.php?edit_id=" . (int)$row['book_id'] . "'\">Edit</button>";
                echo "<button onclick=\"deleteRecord(" . (int)$row['book_id'] . ")\">Delete</button>";
                echo "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='7'>No books found.</td></tr>";
            }

            $conn->close();
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <script>
  function deleteRecord(book_id) {
    if (confirm("Are you sure you want to delete this record?")) {
      window.location.href = "php/delete.php?id=" + book_id;
    }
  }
</script>

  </body>
</html>
