<?php
// get-tax-record.php
session_start();
require_once('../backend/dbsconnection.php');

// Initialize response array
$response = [
  'status' => 'error',
  'message' => 'No VAT record found',
  'vat_percentage' => null,
];

// Fetch the VAT percentage from the vat_settings table
$query = "SELECT vat_percentage FROM vat_settings LIMIT 1";
$result = mysqli_query($conn, $query);

// Check if the query was successful and returned a result
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $response['status'] = 'success';
  $response['vat_percentage'] = $row['vat_percentage'];
  $response['message'] = 'VAT record found';
} else {
  $response['message'] = 'No VAT record exists';
}

// Return the response as a JSON object
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
