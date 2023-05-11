<?php
// Connect to the MySQL database
$conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

// Check for errors
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// If the login form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the submitted email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the query with a bound parameter for the email address
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the email parameter to the statement
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Retrieve the result
    $result = mysqli_stmt_get_result($stmt);

    // If the query fails, show an error message
    if (!$result) {
        die('Failed to retrieve user record from database');
    }

    // If no matching user record was found, show an error message
    if (mysqli_num_rows($result) == 0) {
        die('Invalid email or password');
    }

    // Retrieve the user record as an associative array
    $user = mysqli_fetch_assoc($result);

    // Hash the submitted password using the same algorithm and salt as the stored password
    $hashed_password = hash('sha256', $password . $user['salt']);

    // If the hashed password matches the stored password, the user is authenticated
    if ($hashed_password == $user['password']) {
        // Redirect the user to the protected content of your site
        header('Location: protected_page.php');
        exit();
    } else {
        // If the password doesn't match, show an error message
        die('Invalid email or password');
    }
}


