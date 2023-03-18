<?php
    require_once "path_definer.php";

    require $p_conf;
    require_once $p_conn;

    require "function.php";
    require_once $p_incl."function/fetch_setting.php";
    require_once $webframe."webf_function.php";

    $path_level = 2;
    $path_type = 1;

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['username'], $_POST['p'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p']; // The hashed password.
    
    if (login($username, $password, $query) == true) {
        header("Location: /dioc/dashboard/");
        exit();
    } else {
        header("Location: /dioc/login/?error=1");
        exit();
    }
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../error.php?err=Could not process login');
    exit();
}