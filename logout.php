<?php

require_once "./inc/dbconnection.php";
require_once "./functions/functions.php";

// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

if (isset($_COOKIE[session_name()])) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Clear cache to prevent sensitive data from being stored
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Notify other tabs of logout via localStorage
echo '<script>
    localStorage.setItem("logout-event", "logout-" + Math.random());
    window.location.href = "login.php";
</script>';
exit;
