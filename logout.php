<?php
session_start();
// Clear session data and redirect to login page
session_unset();
session_destroy();
header('Location: login.php');
exit;
?>