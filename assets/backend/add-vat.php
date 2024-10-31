<?php
// add-vat.php
session_start();
require_once('dbsconnection.php');

// Initialize default response
$response = array(
  'message' => 'Form submission failed',
  'status' => 'error'
);

// Function to sanitize input
function sanitizeData($data, $conn)
{
  return mysqli_real_escape_string($conn, htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if 'vat_percentage' is provided
  if (isset($_POST['vat_percentage'])) {
    $vat_percentage = sanitizeData($_POST['vat_percentage'], $conn);

    // Validate VAT percentage (must be between 0 and 100)
    if (is_numeric($vat_percentage) && $vat_percentage >= 0 && $vat_percentage <= 100) {

      // Check if any record exists in the vat_settings table
      $checkQuery = "SELECT id FROM vat_settings LIMIT 1";
      $result = mysqli_query($conn, $checkQuery);

      if (mysqli_num_rows($result) > 0) {
        // Record exists, update the first (only) record
        $updateQuery = "UPDATE vat_settings SET vat_percentage = ?, updated_at = NOW()";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('d', $vat_percentage); // 'd' for decimal
        if ($stmt->execute()) {
          $response['status'] = 'success';
          $response['message'] = 'VAT percentage updated successfully.';
        } else {
          $response['message'] = 'Failed to update VAT percentage.';
        }
        $stmt->close();
      } else {
        // No record exists, insert a new record
        $insertQuery = "INSERT INTO vat_settings (vat_percentage, updated_at) VALUES (?, NOW())";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('d', $vat_percentage);
        if ($stmt->execute()) {
          $response['status'] = 'success';
          $response['message'] = 'VAT percentage inserted successfully.';
        } else {
          $response['message'] = 'Failed to insert VAT percentage.';
        }
        $stmt->close();
      }
    } else {
      $response['message'] = 'Invalid VAT percentage. Please enter a value between 0 and 100.';
    }
  } else {
    $response['message'] = 'VAT percentage not provided.';
  }
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
