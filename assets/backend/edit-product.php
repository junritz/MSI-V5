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
function sanitizeInput($conn, $input) {
  return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

// Function to validate uploaded image
function validateImageUpload($file) {
  $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
  if (!in_array($file['type'], $allowed_types)) {
    return 'Invalid image format. Only jpg, png, and webp are allowed.';
  }
  return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and validate form data
  $product_id = sanitizeInput($conn, $_POST['product_id'] ?? null);
  $product_name = sanitizeInput($conn, $_POST['product-name'] ?? null);
  $categories = sanitizeInput($conn, $_POST['categories'] ?? null);
  $stock_count = sanitizeInput($conn, $_POST['product-stock'] ?? null);
  $price = sanitizeInput($conn, $_POST['price'] ?? null);

  // Validate required fields
  if (!$product_id || !$product_name || !$categories || !$stock_count || !$price) {
    $response['message'] = 'All fields are required.';
    echo json_encode($response);
    exit();
  }

  // Get the existing product image before updating
  $query = "SELECT product_img_path FROM products WHERE product_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    $old_image_name = $row['product_img_path']; // Get the old image file name
  } else {
    $response['message'] = 'Product not found.';
    echo json_encode($response);
    exit();
  }
  $stmt->close();

  // Process the image if uploaded
  $product_img_path = $old_image_name; // Default to old image if no new one is uploaded
  if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['product-image'];

    // Validate the uploaded image
    $image_error = validateImageUpload($file);
    if ($image_error) {
      $response['message'] = $image_error;
      echo json_encode($response);
      exit();
    }

    // Generate a new file name and save the file
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_file_name = uniqid() . '.' . $file_extension; // Save only the file name
    $upload_dir = '../uploads/product-img/';
    $upload_path = $upload_dir . $new_file_name;

    // Ensure the upload directory exists
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0755, true);
    }

    // Move the uploaded file
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
      $response['message'] = 'Error uploading the image.';
      echo json_encode($response);
      exit();
    }

    // Set the new image path to be stored in the database
    $product_img_path = $new_file_name;

    // Delete the old image if it exists and isn't the same as the new one
    if ($old_image_name && file_exists($upload_dir . $old_image_name)) {
      unlink($upload_dir . $old_image_name); // Remove the old image from the folder
    }
  }

  // Update the product in the database with sanitized inputs
  $query = "UPDATE products 
            SET product_name = ?, product_img_path = ?, categories = ?, stock_count = ?, price = ?, updated_at = NOW() 
            WHERE product_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssids", $product_name, $product_img_path, $categories, $stock_count, $price, $product_id);

  if ($stmt->execute()) {
    $response['message'] = 'Product updated successfully.';
    $response['status'] = 'success';
  } else {
    error_log("Error updating product: " . $stmt->error); // Log the error
    $response['message'] = 'Error updating the product.';
  }

  // Close the statement and connection
  $stmt->close();
  $conn->close();

  // Return the response as JSON
  echo json_encode($response);
}
