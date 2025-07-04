<?php
include 'db.php';
$query = "%" . $_GET['query'] . "%";

$sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $query, $query);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Search Results</h2><table border='1' cellpadding='8'><tr><th>ID</th><th>Title</th><th>Author</th><th>Category</th><th>ISBN</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td>{$row['author']}</td>
            <td>{$row['category']}</td>
            <td>{$row['isbn']}</td>
          </tr>";
}
echo "</table>";
$conn->close();
?>