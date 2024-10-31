<?php
// Enable error reporting and log all errors
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');
error_reporting(E_ALL);

// Include database connection and email sender
require('dbsconnection.php');
require('send-email.php');

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

// Function to generate verification token
function generateToken()
{
  return bin2hex(random_bytes(32)); // 64-character token
}

// Function to generate unique user ID
function generateUserId($conn)
{
  do {
    $userId = uniqid('user_'); // Generates a unique user_id
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM registered_users WHERE user_id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
  } while ($result['count'] > 0); // Repeat if the generated ID already exists
  return $userId;
}

// Function to generate verification email template
function generateVerificationEmailTemplate($fullName, $verifyToken)
{
  return "
    <html>
    <body style='font-family: Arial, sans-serif; background-color: #f2f4f8; margin: 0; padding: 0; text-align: center;'>
        <div style='background-color: #ffffff; width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
            <div style='background-color: #f2f4f8; padding: 20px; border-radius: 8px 8px 0 0; text-align: center;'>
                <img src='cid:logo' alt='Gym Logo' style='max-width: 100px; display: block; margin: 0 auto;' />
            </div>
            <div style='padding: 20px; text-align: left;'>
                <h2 style='color: #333333;'>Dear $fullName,</h2>
                <p style='color: #555555;'>Thank you for registering to Gym. To complete your registration and verify your email address, please click the button below:</p>
                <a href='http://localhost/POS%20COPY/assets/backend/verify-status.php?token=$verifyToken' style='background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Click here to verify</a>
                <p style='color: #555555;'>Thank you for using our service.</p>
            </div>
            <div style='padding: 10px; font-size: 12px; color: #777777; text-align:center;'>
                This is a system-generated email. Please do not reply.
            </div>
        </div>
    </body>
    </html>
    ";
}

// Function to log errors
function logError($message)
{
  error_log($message); // Logs the message to php-error.log
}

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (
    isset($_POST['fullName'], $_POST['email'], $_POST['password'], $_POST['confirm_password']) &&
    isset($_POST['terms-condition-check']) && $_POST['terms-condition-check'] == 'on'
  ) {
    $fullName = sanitizeData($_POST['fullName'], $conn);
    $email = sanitizeData($_POST['email'], $conn);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form fields
    if (!preg_match('/^[a-zA-Z]+(?:\s[a-zA-Z]+)*\.?\s?[a-zA-Z]+$/', $fullName)) {
      $response['message'] = 'Full name is in an invalid format.';
    } elseif (strlen($fullName) < 5 || strlen($fullName) > 25) {
      $response['message'] = 'Full name must be between 5 and 25 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $response['message'] = 'Email is not valid.';
    } elseif ($password !== $confirmPassword) {
      $response['message'] = 'Passwords do not match.';
    } elseif (strlen($password) <= 5 || strlen($password) >= 25 || !preg_match('/[A-Z]+/', $password) || !preg_match('/[0-9]+/', $password)) {
      $response['message'] = 'Password must be between 6-24 characters and include at least one capital letter and one number.';
    } else {
      try {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM registered_users WHERE email = ?");
        if (!$stmt) {
          throw new Exception('Prepare statement failed: ' . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['count'] > 0) {
          $response['message'] = 'Email is already taken.';
        } else {
          $verify_token = generateToken();
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          $verify_status = 'unverified';
          $user_type = 'user';
          $user_id = generateUserId($conn); // Generate unique user_id

          // Insert into registered_users table
          $stmt = $conn->prepare("INSERT INTO registered_users (user_id, full_name, email, password, verify_status, verification_token, user_type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp(), current_timestamp())");
          if (!$stmt) {
            throw new Exception('Prepare statement failed: ' . $conn->error);
          }
          $stmt->bind_param("sssssss", $user_id, $fullName, $email, $hashedPassword, $verify_status, $verify_token, $user_type);

          if ($stmt->execute()) {
            $emailBody = generateVerificationEmailTemplate($fullName, $verify_token);
            $verificationMessage = sendEmail($email, 'Email Verification from Gym', $emailBody, '', ['path' => '../images/icons/logo.png', 'cid' => 'logo']);

            if (strpos($verificationMessage, 'Message has been sent') !== false) {
              $response['status'] = 'success';
              $response['message'] = 'Congrats, registered successfully. Please check your email to verify your account.';
            } else {
              $response['message'] = 'Registration successful but failed to send verification email.';
            }
          } else {
            logError('Failed to insert user: ' . $stmt->error);
            $response['message'] = 'Error in registration. Please try again.';
          }
        }
      } catch (Exception $e) {
        logError("Error: " . $e->getMessage());
        $response['message'] = 'Database error. Please try again.';
      }
    }
  } else {
    $response['message'] = 'Invalid request. Missing required fields or terms & conditions not accepted.';
  }
} else {
  $response['message'] = 'Invalid request method.';
}

$conn->close();

// Return the response as JSON
echo json_encode($response);
