<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$search = $_GET['search'] ?? null;

if ($search) {
    $searchTerm = "%" . $search . "%";
    $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ?");
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM books");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Khadija's Library</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial;
      background: #f8f8f8;
      padding: 20px;
    }
    header {
      background: #2c3e50;
      color: white;
      padding: 10px 20px;
      margin-bottom: 20px;
    }
    nav a {
      margin-right: 20px;
      color: white;
      text-decoration: none;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #e0e0e0;
    }
    .back-link {
      margin-bottom: 15px;
      display: inline-block;
    }
  </style>
</head>
<body class="dashboard-page">

<header>
  <nav>
    <a href="add_book.html">Add Books</a>
    <a href="dashboard.php">Show Books</a>
    <a href="borrow_book.html">Borrow Books</a>
    <a href="search_book.html">Search Books</a>
    <a href="delete_book_list.php">Delete Book</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<h2>All Books</h2>

<?php if ($search): ?>
  <p class="back-link"><a href="dashboard.php">🔙 Back to All Books</a></p>
<?php endif; ?>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Author</th>
      <th>Genre</th>
      <th>Quantity</th>
      <th>Availability</th>
      <th>ISBN</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['author'] ?></td>
        <td><?= $row['category'] ?? 'N/A' ?></td>
        <td><?= $row['quantity'] ?? '0' ?></td>
        <td><?= ($row['availability'] === 'Yes') ? 'Yes' : 'No' ?></td>
        <td><?= $row['isbn'] ?? 'N/A' ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>
