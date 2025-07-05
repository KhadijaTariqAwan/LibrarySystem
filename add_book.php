<?php
include 'db.php';

$title = $_POST['title'];
$author = $_POST['author'];
$category = $_POST['category'];
$isbn = $_POST['isbn'];
$quantity = intval($_POST['quantity']);

// Check if book exists
$sql = "SELECT * FROM books WHERE title = ? AND author = ? AND isbn = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $author, $isbn);
$stmt->execute();
$result = $stmt->get_result();

$action = "";

if ($result->num_rows > 0) {
    // Update quantity
    $update = $conn->prepare("UPDATE books SET quantity = quantity + ? WHERE title = ? AND author = ? AND isbn = ?");
    $update->bind_param("isss", $quantity, $title, $author, $isbn);
    $update->execute();
    $action = "updated";
} else {
    // Insert new book
    $availability = $quantity > 0 ? "Yes" : "No";
    $insert = $conn->prepare("INSERT INTO books (title, author, category, isbn, quantity, availability) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("ssssis", $title, $author, $category, $isbn, $quantity, $availability);
    $insert->execute();
    $action = "added";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Added</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('uploads/dashboard-bg.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .popup {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 40px;
      border-radius: 10px;
      text-align: center;
      color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.6);
    }

    .popup h2 {
      color: #00ffcc;
      font-size: 24px;
      margin-bottom: 10px;
    }

    .popup p {
      font-size: 16px;
    }
  </style>
  <script>
    setTimeout(function() {
      window.location.href = 'dashboard.php';
    }, 3000);
  </script>
</head>
<body>
  <div class="popup">
    <h2>✅ Book <?= $action === "updated" ? "Quantity Updated" : "Added Successfully" ?>!</h2>
    <p>Redirecting to Dashboard...</p>
  </div>
</body>
</html>
