<?php
session_start();

require_once 'connectDB.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform authentication 
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

// Handle file upload
if (isset($_FILES['fileToUpload'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Search method
if (isset($_GET['q'])) {
    $search_term = $_GET['q'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
    $search_term = "%$search_term%";
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Name: " . htmlspecialchars($row["name"]) . " - Description: " . htmlspecialchars($row["description"]) . "<br>";
        }
    } else {
        echo "No results found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Team 2 Page</title>
    <link rel="stylesheet" type="text/css" href="color.css">
</head>
<body>
    <h1>Login</h1>
    <form action="form.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
