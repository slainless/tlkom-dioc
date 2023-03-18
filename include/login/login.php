<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
  require $p_svropt;
  require $p_cdash;
  require_once 'fungsi.php';

sec_session_start();

if (isset($_POST['user'], $_POST['p'])) {
    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p'];
    
    if (login($user, $password, $que_dash) == true) {
        header("Location: ../../dashboard/");
        exit();
    } else {
        header('Location: ../../login/index.php?error=1');
        exit();
    }
} else {
    header('Location: ../../login/error.php?err=Could not process login');
    exit();
}