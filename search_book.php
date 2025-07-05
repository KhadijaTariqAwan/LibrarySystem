<?php
include 'db.php';

$field = $_GET['field'] ?? 'all';
$search = "%" . $_GET['query'] . "%";

if ($field === 'title') {
    $sql = "SELECT * FROM books WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
} elseif ($field === 'author') {
    $sql = "SELECT * FROM books WHERE author LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
} elseif ($field === 'category') {
    $sql = "SELECT * FROM books WHERE category LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
} else {
    $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $search, $search, $search);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: url('uploads/dashboard-bg.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
      color: white;
      margin: 0;
      padding: 20px;
    }

    .container {
      background-color: rgba(0, 0, 0, 0.65);
      padding: 30px;
      margin: 50px auto;
      width: 90%;
      border-radius: 10px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      text-shadow: 1px 1px 2px black;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      color: white;
      background-color: rgba(255, 255, 255, 0.05);
    }

    th, td {
      padding: 12px;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    th {
      background-color: rgba(0, 0, 0, 0.5);
    }

    a.back-link {
      display: inline-block;
      margin-top: 20px;
      font-weight: bold;
      color: #fff;
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Search Results</h2>

  <?php if ($result->num_rows > 0): ?>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Availability</th>
        <th>ISBN</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['title'] ?></td>
          <td><?= $row['author'] ?></td>
          <td><?= $row['category'] ?></td>
          <td><?= $row['quantity'] ?></td>
          <td><?= $row['availability'] ?></td>
          <td><?= $row['isbn'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p>No books found for the search term.</p>
  <?php endif; ?>

  <a class="back-link" href="dashboard.php">🔙 Back to Dashboard</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
