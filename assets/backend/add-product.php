<?php
require_once('dbsconnection.php');

// Initialize response structure
$response = array(
  'message' => 'An error occurred during the process',
  'status' => 'error'
);

// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');
error_reporting(E_ALL);

// Function to sanitize input
function sanitizeInput($conn, $input)
{
  return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

// Generate a short unique ID for product_id with company-related prefix
function generate_short_id()
{
  $company_acronym = 'MPS'; // Marcomedia Products and Services
  $short_uuid = substr(uniqid(), 0, 8); // Get first 8 characters of a unique ID
  return $company_acronym . '-' . $short_uuid;
}

// Function to validate uploaded image
function validateImageUpload($file)
{
  $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
  $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  if (!in_array($file_ext, $allowed_types)) {
    return 'Invalid file type. Allowed types: jpg, jpeg, png, webp.';
  }
  return null;
}

// Check if the request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if required fields are set
  if (isset($_POST['product-name'], $_FILES['product-image'], $_POST['categories'], $_POST['stocks-count'], $_POST['price'], $_POST['discount-percentage'])) {

    // Sanitize input data
    $product_name = sanitizeInput($conn, $_POST['product-name']);
    $categories = sanitizeInput($conn, $_POST['categories']);
    $stock_count = (int) $_POST['stocks-count'];
    $price = (int) $_POST['price'];
    $discount_percentage = (float) $_POST['discount-percentage'];

    // Generate a shortened ID for the product_id column
    $product_id = generate_short_id();

    // Handle file upload
    $target_dir = '../uploads/product-img/';
    $image = $_FILES['product-image'];

    // Validate image file
    $image_error = validateImageUpload($image);
    if ($image_error) {
      $response['message'] = $image_error;
      echo json_encode($response);
      exit();
    }

    // Generate a unique name for the file
    $unique_file_name = uniqid() . '_' . basename($image['name']);
    $target_file = $target_dir . $unique_file_name;

    // Ensure the upload directory exists
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0755, true);
    }

    // Move the file to the designated folder
    if (!move_uploaded_file($image['tmp_name'], $target_file)) {
      $error = 'Failed to upload the image: ' . $image['error'];
      error_log($error);
      $response['message'] = 'Failed to upload the image.';
      echo json_encode($response);
      exit();
    }

    // Prepare SQL statement with placeholders, including the new discount_percentage field
    $stmt = $conn->prepare("INSERT INTO products (product_id, product_name, product_img_path, categories, stock_count, price, discount_percentage, created_at) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    if ($stmt) {
      // Bind sanitized parameters to the prepared statement
      $stmt->bind_param('ssssiid', $product_id, $product_name, $unique_file_name, $categories, $stock_count, $price, $discount_percentage);

      // Execute the statement
      if ($stmt->execute()) {
        // On successful product creation
        $response['message'] = 'Product added successfully!';
        $response['status'] = 'success';
      } else {
        // Error during product insertion
        error_log('Error inserting product into the database: ' . $stmt->error);
        $response['message'] = 'Error inserting product into the database.';
      }
      $stmt->close();
    } else {
      // Error preparing the SQL statement
      error_log('Database query preparation failed: ' . $conn->error);
      $response['message'] = 'Database query preparation failed.';
    }
  } else {
    // Missing required fields
    error_log('Missing required fields: product-name, product-image, categories, stocks-count, price, discount-percentage');
    $response['message'] = 'Please fill all required fields.';
  }
}

// Set content-type header to application/json
header('Content-Type: application/json');
echo json_encode($response);
