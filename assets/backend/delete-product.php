<?php
require_once('dbsconnection.php');

// Enable error logging and set the error log file
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');
error_reporting(E_ALL); 

$response = array(
    'message' => 'An error occurred during the process',
    'status' => 'error'
);

function log_error($message, $exception = null) {
    $errorMessage = $message;
    if ($exception) {
        $errorMessage .= ": " . $exception->getMessage();
    }
    error_log($errorMessage);
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if product_id is set and not empty
        if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
            // Sanitize the input
            $product_id = $_POST['product_id'];

            // Prepare a query to check if the product exists and retrieve the image path
            $stmt = $conn->prepare("SELECT product_img_path FROM products WHERE product_id = ? AND deleted_at IS NULL");
            if ($stmt === false) {
                throw new Exception("Error preparing the select statement: " . $conn->error);
            }
            $stmt->bind_param("s", $product_id);

            if (!$stmt->execute()) {
                throw new Exception("Error executing the select query: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $image_filename = $row['product_img_path'];
                $image_path = '../uploads/product-img/' . $image_filename;

                // Check if the image file exists and attempt to delete it
                if (file_exists($image_path)) {
                    if (!unlink($image_path)) {
                        throw new Exception("Failed to delete image at path: " . $image_path);
                    }
                } else {
                    throw new Exception("Image file does not exist at path: " . $image_path);
                }

                // Soft delete the product by updating the deleted_at column
                $stmt_update = $conn->prepare("UPDATE products SET deleted_at = NOW() WHERE product_id = ?");
                if ($stmt_update === false) {
                    throw new Exception("Error preparing the update statement: " . $conn->error);
                }

                $stmt_update->bind_param("s", $product_id);
                if (!$stmt_update->execute()) {
                    throw new Exception("Error executing the update query: " . $stmt_update->error);
                }

                if ($stmt_update->affected_rows > 0) {
                    $response['message'] = "Product soft-deleted and associated image deleted successfully";
                    $response['status'] = "success";
                } else {
                    $response['message'] = "Failed to soft-delete the product. No changes made.";
                }

                $stmt_update->close();
            } else {
                $response['message'] = "No product found with the given ID or the product is already deleted";
            }

            $result->free();
            $stmt->close();
        } else {
            $response['message'] = "Invalid product ID";
        }
    } else {
        $response['message'] = "Invalid request method";
    }
} catch (Exception $e) {
    log_error($response['message'], $e);  
    $response['message'] = $e->getMessage();  
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
