<?php
include 'db.php';

$member_id = $_POST['member_id'];
$book_id = $_POST['book_id'];

// Checking if the book exists
$check = $conn->prepare("SELECT quantity FROM books WHERE id = ?");
$check->bind_param("i", $book_id);
$check->execute();
$result = $check->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "<script>alert('Book not found!'); window.location.href='dashboard.php';</script>";
    exit;
}

$current_quantity = (int)$book['quantity'];

if ($current_quantity <= 0) {
    echo "<script>alert('Book is currently unavailable.'); window.location.href='dashboard.php';</script>";
    exit;
}

// Insert transaction
$log = $conn->prepare("INSERT INTO transactions (member_id, book_id, action) VALUES (?, ?, 'borrow')");
$log->bind_param("ii", $member_id, $book_id);
$log->execute();

// Update quantity and availability
$new_quantity = $current_quantity - 1;
$availability = ($new_quantity > 0) ? 'Yes' : 'No';

$update = $conn->prepare("UPDATE books SET quantity = ?, availability = ? WHERE id = ?");
$update->bind_param("isi", $new_quantity, $availability, $book_id);
$update->execute();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Borrowed</title>
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
      background-color: rgba(0, 0, 0, 0.8);
      padding: 40px;
      border-radius: 10px;
      text-align: center;
      color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }

    .popup h2 {
      color: #00ffcc;
      font-size: 24px;
      margin: 0;
    }
  </style>
  <script>
    // Redirect after 3 seconds
    setTimeout(function() {
      window.location.href = 'dashboard.php';
    }, 3000);
  </script>
</head>
<body>
  <div class="popup">
    <h2>✅ Book Borrowed Successfully!</h2>
    <p>Redirecting to dashboard...</p>
  </div>
</body>
</html>



// trigger linguist reanalysisb
