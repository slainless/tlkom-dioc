<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";

    sec_session_start();

if(login_check($query) && $_SESSION["level"] < 3 && isset($_POST["mode"], $_POST["ignore"], $_POST["limit"], $_POST["ignore"], $_POST["enclose"])):

if($_FILES["uploadfile"]["error"] != 4):

    $ignore = filter_input(INPUT_POST, 'ignore', FILTER_SANITIZE_NUMBER_INT);

    require $p_incl."lib/random.php";

switch ($_POST["mode"]) {
    case '1':
        $mode = "REPLACE";
        break;
    
    case '2':
        $mode = "IGNORE";
        break;

    default:
        $mode = "REPLACE";
        break;
}

switch ($_POST["limit"]) {
    case '1':
        $limit = ";";
        break;
    
    case '2':
        $limit = ",";
        break;

    default:
        $limit = ";";
        break;
}

switch ($_POST["enclose"]) {
    case '1':
        $enclose = '\"';
        break;
    
    case '2':
        $enclose = "\'";
        break;

    default:
        $enclose = '\"';
        break;
}

$target_dir = "temp/";
$bytes = random_bytes(5);
$bytesname = bin2hex($bytes);
$target_file = $target_dir . $bytesname . ".csv";
$fullpath = $p_main . "upload/" . $target_file;
$uploadflag = 1;
// Check file size
if ($_FILES["uploadfile"]["size"] > 10000000) {
    $message['text'] = "File size min. 10MB";
    $message['alert'] = "warning";
    $uploadflag = 0;
}
// Check if $uploadflag is set to 0 by an error
if ($uploadflag == 1) {
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {

        $filter = file_get_contents($target_file);
        $filter = str_replace("\r\n", "\n", $filter);
        file_put_contents($target_file, $filter, LOCK_EX);

        $stmtq = 
        "LOAD DATA INFILE '".$fullpath."' ".$mode." 
            INTO TABLE ".$t_nona_ket." 
            FIELDS TERMINATED BY '".$limit."' 
            OPTIONALLY ENCLOSED BY '".$enclose."' 
            LINES TERMINATED BY '\n' 
            IGNORE ".$ignore." LINES";

        if (mysqli_query($query, $stmtq)) {

            $message['text'] = "Query success.";
            $message['alert'] = "success";

            unlink($fullpath);

        }
        else {
            $message['text'] = "Query failed.";
            $message['alert'] = "danger";

            unlink($fullpath);
        }
    } 
    else {
            $message['text'] = "Upload failed.";
            $message['alert'] = "danger";
    }
}
echo json_encode($message);
endif;
endif;
?>