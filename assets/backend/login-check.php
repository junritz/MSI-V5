<?php
// Enable error reporting and log all errors
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');
error_reporting(E_ALL);

// Include database connection
require('dbsconnection.php');
session_start();

// Response array
$response = array(
  'message' => 'An error occurred during the process',
  'status' => 'error'
);

// Function to sanitize data
function sanitizeData($data, $conn)
{
  return mysqli_real_escape_string($conn, htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8'));
}

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
  $email = sanitizeData($_POST['email'], $conn);
  $password = $_POST['password'];

  // Error Handler
  if (empty($email) || empty($password)) {
    $response['message'] = 'All input fields are required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Email is invalid';
  } elseif (strlen($password) > 25) {
    $response['message'] = 'Password is too long';
  } else {
    // Prepare and execute SQL query to fetch user data
    $stmt = $conn->prepare("SELECT ID, full_name, email, password, verify_status, user_type FROM registered_users WHERE email = ?");
    if ($stmt === false) {
      $response['message'] = 'Database error. Please try again later.';
    } else {
      $stmt->bind_param("s", $email);
      if (!$stmt->execute()) {
        $response['message'] = 'Database error. Please try again later.';
      } else {
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
          // Check if password matches the hashed password
          if (password_verify($password, $result['password'])) {
            // Check if account is verified
            if ($result['verify_status'] == 'verified') {
              // Regenerate session and store user data
              session_regenerate_id(true);
              $_SESSION['ID'] = $result['ID'];
              $_SESSION['full_name'] = $result['full_name'];
              $_SESSION['email'] = $result['email'];
              $_SESSION['user_type'] = $result['user_type'];
              $_SESSION['auth_user'] = array(
                'full_name' => $result['full_name'],
                'email' => $result['email']
              );

              // Redirect based on user type
              if ($result['user_type'] == 'admin') {
                $response['status'] = 'success';
                $response['redirect'] = 'admin-dashboard.php';
              } elseif ($result['user_type'] == 'user') {
                $response['status'] = 'success';
                $response['redirect'] = 'user-products.php';
              } else {
                $response['message'] = 'Unauthorized access.';
              }
            } else {
              $response['message'] = 'Account is not verified.';
            }
          } else {
            $response['message'] = 'Email or Password is incorrect.';
          }
        } else {
          $response['message'] = 'Email not found.';
        }
      }
    }
  }
} else {
  $response['message'] = 'Invalid request method or missing input.';
}

// Return response as JSON
echo json_encode($response);
