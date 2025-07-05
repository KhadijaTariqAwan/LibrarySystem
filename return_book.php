<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Return Confirmation</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-image: url("uploads/dashboard-bg.jpg");
      background-size: cover;
      background-position: center;
    }

    .confirmation-box {
      max-width: 500px;
      margin: 100px auto;
      background-color: rgba(0, 0, 0, 0.75);
      padding: 40px;
      text-align: center;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
      color: white;
    }

    .confirmation-box h2 {
      margin-bottom: 15px;
    }

    .confirmation-box p {
      margin-bottom: 25px;
    }

    .confirmation-box a {
      display: inline-block;
      margin: 0 10px;
      padding: 10px 20px;
      text-decoration: none;
      background-color: #3498db;
      color: white;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .confirmation-box a:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  <div class="confirmation-box">
    <h2>Book Returned Successfully!</h2>
    <p>Do you want to write a review for this book?</p>
    <a href="review_form.html">Write a Review</a>
    <a href="dashboard.php">Back to Dashboard</a>
  </div>
</body>
</html>
