<?php
require_once('../backend/dbsconnection.php');
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');
error_reporting(E_ALL);

// Pagination and search variables
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 50;
$offset = ($page - 1) * $limit;
$base_image_path = 'assets/uploads/product-img/';

// Main SQL query to fetch product data
$sql = "
  SELECT product_id, product_name, categories, price, stock_count, product_img_path, 
         discount_percentage, created_at, updated_at
  FROM products";

// Modify SQL query based on search input
if (!empty($search)) {
    $sql .= " WHERE (product_id LIKE ? OR LOWER(product_name) LIKE LOWER(?))";
    $search_param = '%' . $search . '%';  // Use wildcard for partial matching
}

// Append ordering and pagination
$sql .= " ORDER BY product_name ASC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log('Query preparation failed: ' . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Query preparation failed']);
    exit;
}

// Bind parameters based on search type
if (!empty($search)) {
    $stmt->bind_param("ssii", $search_param, $search_param, $limit, $offset);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}

// Execute and fetch results
if (!$stmt->execute()) {
    error_log('Query execution failed: ' . $stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Query execution failed']);
    exit;
}

$result = $stmt->get_result();
$products = [];
while ($row = $result->fetch_assoc()) {
    $row['image_url'] = $base_image_path . $row['product_img_path'];
    $products[] = $row;
}

// Total count for pagination
$count_sql = "SELECT COUNT(*) AS total FROM products";
if (!empty($search)) {
    $count_sql .= " WHERE (product_id LIKE ? OR LOWER(product_name) LIKE LOWER(?))";
}
$count_stmt = $conn->prepare($count_sql);
if (!$count_stmt) {
    error_log('Count query preparation failed: ' . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Count query preparation failed']);
    exit;
}

if (!empty($search)) {
    $count_stmt->bind_param("ss", $search_param, $search_param);
}

if (!$count_stmt->execute()) {
    error_log('Count query execution failed: ' . $count_stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Count query execution failed']);
    exit;
}

$count_result = $count_stmt->get_result();
$total = $count_result->fetch_assoc()['total'];

// Prepare response
$response = [
    'status' => 'success',
    'products' => $products,
    'total' => $total,
    'current_page' => $page,
    'total_pages' => ceil($total / $limit),
];

// Send JSON response
echo json_encode($response);

// Close statements and connection
$stmt->close();
$count_stmt->close();
$conn->close();
