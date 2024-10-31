<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: home.php");
    exit();
}
session_regenerate_id(true);
$user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
$admin_pages = [
    'admin-dashboard.php',
    'admin-appointment.php',
    'admin-create-news.php',
    'admin-payment-record.php',
    'admin-sidebar.php',
    'admin-registered-users.php',
    'admin-create-products.php',
    'admin-patient-record.php'
];
$current_page = basename($_SERVER['PHP_SELF']);
if ($user_type !== 'admin' && in_array($current_page, $admin_pages)) {
    header("Location: register.php");
    exit();
}
