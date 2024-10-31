<?php
session_start();
require('dbsconnection.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Fetch the token and verify status
    $verify_query = "SELECT verification_token, verify_status FROM registered_users WHERE verification_token = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $verify_query);
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $verify_query_run = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);

        // Check if the account is still unverified
        if ($row['verify_status'] == 'unverified') {
            $clicked_token = $row['verification_token'];

            // Update the verify_status to 'verified'
            $update_query = "UPDATE registered_users SET verify_status = 'verified' WHERE verification_token = ? LIMIT 1";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, 's', $clicked_token);
            $update_query_run = mysqli_stmt_execute($stmt);

            if ($update_query_run) {
                echo "
                <script>
                    alert('User Email Verification is Successful');
                    window.location.href = '/POS%20COPY/register.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('User Email Verification is not Successful');
                    window.location.href = '/POS%20COPY/register.php';
                </script>
                ";
            }
        } else {
            echo "
            <script>
                alert('Your Email is already verified');
                window.location.href = '/POS%20COPY/register.php';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Token verification does not exist');
            window.location.href = '/POS%20COPY/register.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('Not Allowed on this page');
        window.location.href = '/POS%20COPY/register.php';
    </script>
    ";
}
?>
