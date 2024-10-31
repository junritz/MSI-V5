<?php
require_once('../backend/dbsconnection.php');

// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');
error_reporting(E_ALL);

// Pagination, search, and category inputs
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : ''; // Get the category from the request
$limit = 50; // Number of items per page
$offset = ($page - 1) * $limit;

// Prepare the SQL query to fetch products with pagination, search, and category filter
$sql = "SELECT product_id, product_name, categories, price, stock_count, product_img_path, discount_percentage
        FROM products 
        WHERE product_name LIKE ?";

$params = []; // Array to store parameters
$param_types = "s"; // Start with the search parameter type (string)
$searchParam = "%" . $search . "%";
$params[] = $searchParam; // Add search parameter to params array

// Handle category filtering if a category is selected
if (!empty($category)) {
  $categoryList = explode(",", $category);
  $categoryConditions = array_map(function () {
    return "categories LIKE ?";
  }, $categoryList);

  $sql .= " AND (" . implode(" OR ", $categoryConditions) . ")";

  // Add each category to the parameters
  foreach ($categoryList as $cat) {
    $param_types .= "s"; // Each category is a string
    $params[] = "%" . $cat . "%"; // Add category with LIKE wildcards
  }
}

$sql .= " LIMIT ? OFFSET ?";
$param_types .= "ii"; // Add types for limit and offset
$params[] = $limit;
$params[] = $offset;

$stmt = $conn->prepare($sql);

// Check if prepare() was successful
if (!$stmt) {
  echo json_encode(['status' => 'error', 'message' => 'Database query error']);
  exit;
}

// Bind parameters using the unpacked params array
$stmt->bind_param($param_types, ...$params);

// Execute the SQL query
if (!$stmt->execute()) {
  echo json_encode(['status' => 'error', 'message' => 'Database execution error']);
  exit;
}

// Fetch result set
$result = $stmt->get_result();

$products = [];
$base_image_path = 'assets/uploads/product-img/'; // Path for product images

// Process each product
while ($row = $result->fetch_assoc()) {
  $row['image_url'] = $base_image_path . $row['product_img_path']; // Full image path
  $products[] = $row;
}

// Fetch total number of products for pagination
$count_sql = "SELECT COUNT(*) AS total FROM products WHERE product_name LIKE ?";
$param_types_count = "s";
$params_count = [$searchParam]; // Same search parameter

if (!empty($category)) {
  $count_sql .= " AND (" . implode(" OR ", $categoryConditions) . ")";
  foreach ($categoryList as $cat) {
    $param_types_count .= "s"; // Each category is a string
    $params_count[] = "%" . $cat . "%";
  }
}

$count_stmt = $conn->prepare($count_sql);

if (!$count_stmt) {
  echo json_encode(['status' => 'error', 'message' => 'Database count query error']);
  exit;
}

$count_stmt->bind_param($param_types_count, ...$params_count);

if (!$count_stmt->execute()) {
  echo json_encode(['status' => 'error', 'message' => 'Database count execution error']);
  exit;
}

// Get the total count
$count_result = $count_stmt->get_result();
$total = $count_result->fetch_assoc()['total'];

// Prepare the response
$response = [
  'status' => 'success',
  'products' => $products,
  'total' => $total,
  'current_page' => $page,
  'total_pages' => ceil($total / $limit),
];

// Send the response as JSON
echo json_encode($response);
