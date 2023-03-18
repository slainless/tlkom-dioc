<?php
    require "server_config_global.php";

    // setting database

    $db_name = "nonatero";

    $my_host = "localhost";
    $my_user = "root";
    $my_pass = "123";

    // <-- struktur file -->

    $file_koneksi       = "connection.php";
    $file_define_global = "global_define.php";
    
    $folder_dashboard   = "dioc";

    $folder_utama       = "dashboard";
    $folder_include     = "include";
    $folder_login       = "login";

    // <-- don't touch me! -->

    $p_conn = $_SERVER["DOCUMENT_ROOT"]."/".$folder_dashboard."/".$file_koneksi;
    $p_defn = $_SERVER["DOCUMENT_ROOT"]."/".$folder_dashboard."/".$file_define_global;

    $p_dash = $_SERVER["DOCUMENT_ROOT"]."/".$folder_dashboard."/";

    $p_main = $_SERVER["DOCUMENT_ROOT"]."/".$folder_dashboard."/".$folder_utama."/";
    $p_incl = $_SERVER["DOCUMENT_ROOT"]."/".$folder_dashboard."/".$folder_include."/";
    $p_logn = $_SERVER["DOCUMENT_ROOT"]."/".$folder_dashboard."/".$folder_login."/";

    $r_conn = "/".$folder_dashboard."/".$file_koneksi;
    $r_defn = "/".$folder_dashboard."/".$file_define_global;

    $r_dash = "/".$folder_dashboard."/";

    $r_main = "/".$folder_dashboard."/".$folder_utama."/";
    $r_incl = "/".$folder_dashboard."/".$folder_include."/";
    $r_logn = "/".$folder_dashboard."/".$folder_login."/";

    require "webframe_definer.php";
    


