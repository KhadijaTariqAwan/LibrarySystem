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
      background: url('uploads/dashboard-bg.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      font-family: Arial, sans-serif;
      color: white;
    }

    header {
      background: rgba(44, 62, 80, 0.95);
      padding: 15px 30px;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin-right: 25px;
      font-weight: bold;
      font-size: 16px;
    }

    h2 {
      margin-left: 40px;
      margin-top: 30px;
      font-size: 28px;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
    }

    .back-link {
      margin-left: 40px;
      margin-bottom: 10px;
      display: inline-block;
      font-weight: bold;
    }

    table {
      width: 95%;
      margin: 30px auto;
      border-collapse: collapse;
      background-color: rgba(0, 0, 0, 0.6);
      color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    th {
      background-color: rgba(255, 255, 255, 0.1);
      font-weight: bold;
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    a.back-link {
      color: white;
      font-size: 16px;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
    }

    /* ✅ Success Popup */
    .success-popup {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #2ecc71;
      color: white;
      padding: 15px 25px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      font-size: 16px;
      z-index: 9999;
      animation: fadeOut 5s ease forwards;
    }

    @keyframes fadeOut {
      0% { opacity: 1; }
      80% { opacity: 1; }
      100% { opacity: 0; display: none; }
    }
  </style>
</head>
<body>

<header>
  <nav>
    <a href="add_book.html">Add Books</a>
    <a href="dashboard.php">Show Books</a>
    <a href="borrow_book.html">Borrow Books</a>
    <a href="return_book.html">Return Book</a>
    <a href="search_book.html">Search Books</a>
    <a href="delete_book_list.php">Delete Book</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<h2>All Books</h2>

<?php if ($search): ?>
  <p class="back-link"><a class="back-link" href="dashboard.php">🔙 Back to All Books</a></p>
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

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <div class="success-popup">✅ New book added successfully!</div>
<?php endif; ?>

</body>
</html>
