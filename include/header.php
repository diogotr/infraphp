<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../main/login.php");
    exit;
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
  // last request was more than 30 minutes ago
  // Unset all of the session variables
  $_SESSION = array();
  
  session_unset();     // unset $_SESSION variable for the run-time 
  session_destroy();   // destroy session data in storage
  header("location: ../main/login.php");
  exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infrasoft Systems</title>

    <!-- Styles -->
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">   
    <link href="../static/css/datatables.min.css" rel="stylesheet">
    <!-- Javascript -->
    <script src="../static/js/jquery-3.7.1.min.js"></script>
    <script src="../static/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/69a08c5f0e.js" crossorigin="anonymous"></script>
    <script src="../static/js/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../static/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../static/img/favicon-16x16.png">
 
</head>

<body class="bg-dark">
    
  <nav class="navbar navbar-expand-md mb-3 navbar-dark" style="background-color:#000000;">
    <div class="container-fluid">
      <a class="navbar-brand" href="../main/home.php">Infrasoft Systems</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" href="../tasks">Tasks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../contacts">Contacts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Systems</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../users">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Integration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../main/logout.php">Logout</a>
          </li>          
        </ul>        
      </div>
    </div>
  </nav>