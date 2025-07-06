<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Books - Khadija's Library</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: url('uploads/dashboard-bg.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    
    header {
      background: #2c3e50;
      padding: 15px;
      color: white;
    }

    nav a {
      color: white;
      margin-right: 20px;
      text-decoration: none;
      font-weight: bold;
    }

    .container {
      background-color: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(6px);
      margin: 40px auto;
      padding: 25px;
      border-radius: 25px;
      width: 95%;
      color: #fff;
    }

    h2 {
      color: #fff;
      font-size: 32px;
      font-weight: bold;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      color: #fff;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    th {
      background-color: rgba(0, 0, 0, 0.8);
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      text-shadow: 1px 1px 2px #000;
    }

    td {
      background-color: rgba(255, 255, 255, 0.05);
    }

    button {
      padding: 6px 12px;
      background-color: #3498db;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
    }

    button:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>

<header>
  <nav>
    <a href="dashboard.php">Dashboard</a>
  </nav>
</header>

<div class="container">
  <h2>Delete Books</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>ISBN</th>
        <th>Quantity</th>
        <th>Availability</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['author'] ?></td>
        <td><?= $row['category'] ?? 'N/A' ?></td>
        <td><?= $row['isbn'] ?? 'N/A' ?></td>
        <td><?= $row['quantity'] ?? '0' ?></td>
        <td><?= ($row['availability'] === 'Yes') ? 'Yes' : 'No' ?></td>
        <td>
          <form action="delete_book.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
            <input type="hidden" name="book_id" value="<?= $row['id'] ?>">
            <button type="submit">Remove</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
