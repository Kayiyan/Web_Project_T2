

<?php
session_start();
// after login form
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform authentication (this is a simple example, DO NOT use in production)
    if ($username == 'admin' && $password == 'password') {
        // Successful login, set session variables
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        // Invalid credentials, show error message
        echo 'Invalid username or password. Please try again.';
    }
}

?>
