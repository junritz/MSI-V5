<?php

// Enable error reporting and logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

// Include required files
require_once('dbsconnection.php');
require('generate-pdf.php');

// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['ID'])) {
    logError('User not logged in');
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Error logging function
function logError($message, $context = [])
{
    $context_str = json_encode($context);
    error_log("ERROR: $message | Context: $context_str");
}

// Utility functions
function sanitizeInput($conn, $input)
{
    return mysqli_real_escape_string($conn, trim($input));
}

function generateOrderID()
{
    return 'ORD-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
}

function fetchVatPercentage($conn)
{
    $vat_query = "SELECT vat_percentage FROM vat_settings WHERE ID = 1";
    $vat_result = mysqli_query($conn, $vat_query);
    if (!$vat_result || mysqli_num_rows($vat_result) == 0) {
        logError('Failed to fetch VAT settings');
        throw new Exception('Failed to fetch VAT settings');
    }
    $vat_data = mysqli_fetch_assoc($vat_result);
    return (float)$vat_data['vat_percentage'];
}

// Validate and process the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve and sanitize form data
        $full_name = sanitizeInput($conn, $_POST['full_name']);
        $contact_number = sanitizeInput($conn, $_POST['contact_number']);
        $address = sanitizeInput($conn, $_POST['address']);
        $email = sanitizeInput($conn, $_POST['email']);
        $downpayment = (int)sanitizeInput($conn, $_POST['downpayment']);
        $cart_items = json_decode($_POST['cart_items'], true);

        // Check if cart_items are present
        if (!$cart_items || !isset($cart_items['product_id'], $cart_items['product_name'],  $cart_items['price'], $cart_items['quantity'], $cart_items['total_price'])) {
            logError('Invalid cart items data', ['cart_items' => $_POST['cart_items']]);
            throw new Exception('Invalid cart items data');
        }

        // Fetch VAT percentage
        $vat_percentage = fetchVatPercentage($conn);

        // Calculate VAT and total amount (including VAT)
        $product_price = (float)$cart_items['price'];
        $quantity = (int)$cart_items['quantity'];
        $product_name = $cart_items['product_name'];
        $vat_amount = ($product_price * $vat_percentage) / 100;
        $total_amount = ($product_price + $vat_amount) * $quantity;

        // Prepare data to store in user_orders table
        $order_ID = generateOrderID();
        $user_id = $_SESSION['ID'];
        $product_id = sanitizeInput($conn, $cart_items['product_id']);
        $order_date = date('Y-m-d H:i:s');
        $order_status = 'Pending';

        // Insert the order into the database
        $insert_order_query = "
            INSERT INTO user_orders (
                order_ID, user_id, full_name, email, contact_number, address,
                product_id, product_price, quantity, vat, total_amount, downpayment,
                order_date, order_status
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";
        $stmt = mysqli_prepare($conn, $insert_order_query);
        if (!$stmt) {
            logError('Failed to prepare statement', ['error' => mysqli_error($conn)]);
            throw new Exception('Failed to prepare statement');
        }

        mysqli_stmt_bind_param(
            $stmt,
            'sisssssiidddss',
            $order_ID,
            $user_id,
            $full_name,
            $email,
            $contact_number,
            $address,
            $product_id,
            $product_price,
            $quantity,
            $vat_amount,
            $total_amount,
            $downpayment,
            $order_date,
            $order_status
        );

        if (mysqli_stmt_execute($stmt)) {
            // Save PDF-related data to session before generating PDF
            $_SESSION['pdf_data'] = [
                'order_id' => $order_ID,
                'order_date' => $order_date,
                'customer_name' => $full_name,
                'address' => $address,
                'contact_number' => $contact_number,
                'email' => $email,
                'products' => $cart_items,
                'vat_percentage' => $vat_percentage,
                'total_amount' => $total_amount,
                'downpayment' => $downpayment,
            ];

            // Prepare data for PDF generation
            $products = [
                [
                    'product_id' => $product_id,
                    'product_name' => $product_name,
                    'quantity' => $quantity,
                    'price' => $product_price,
                    'total' => $total_amount
                ]
            ];
            $subtotal = $product_price * $quantity;
            $shipping_cost = 0;
            $discount_amount = 0;
            $balance_due = $total_amount - $downpayment;

            $pdf_base64 = generatePDF(
                $order_ID,
                $order_date,
                $full_name,
                $address,
                $contact_number,
                $email,
                $products,
                $subtotal,
                $vat_amount,
                $downpayment,
                $shipping_cost,
                $total_amount,
                $balance_due,
                $vat_percentage,
                $discount_amount
            );

            echo json_encode([
                'status' => 'success',
                'message' => 'Order placed and PDF generated successfully',
                'orderId' => $order_ID,
                'pdf' => $pdf_base64
            ]);
        } else {
            logError('Failed to execute prepared statement', ['order_ID' => $order_ID]);
            throw new Exception('Failed to save order');
        }
    } catch (Exception $e) {
        logError($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    logError('Invalid request method', ['method' => $_SERVER['REQUEST_METHOD']]);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
