<?php
require_once('dbsconnection.php');

// Capture the search query from the GET request
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

if (empty($searchQuery)) {
    echo json_encode([]); // Return empty if no query
    exit;
}

// Prepare SQL query to search for matching product names
$sql = "SELECT product_name FROM products WHERE product_name LIKE ? LIMIT 10";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Database query error']);
    exit;
}

$searchParam = "%" . $searchQuery . "%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row['product_name'];
}

// Return the suggestions as JSON
header('Content-Type: application/json');
echo json_encode($suggestions);
exit;
?>
