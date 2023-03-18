<?php
require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
require $p_svropt;
require $p_cnona;

require $p_inc . "database/fetch_setting.php";

if(!isset($close)){
    $close = false;
}

if(!$close):
    if(!file_exists($p_nonadata)) {
        if(!isset($c_text)) {
            $c_text = "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_save_n . "\" NOT FOUND, PROCESS TERMINATED...";
        }
        else {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_save_n . "\" NOT FOUND, PROCESS TERMINATED...";
        }
        $close = true;
    }
    else {
        if(!isset($c_text)) {
            $c_text = "[SUCCESS] FILE \"" . $nona_save_n . "\" FOUND" . "<br>";
        }
        else {
            $c_text = $c_text . "[SUCCESS] FILE \"" . $nona_save_n . "\" FOUND" . "<br>";
        }
    }
endif;

if(!$close):
    $check_result = substr(file_get_contents($p_nonadata), 0, 4);
    if($check_result != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FILE CONTENT VALID" . "<br>";
    }
endif;

if(!$close):
    $process = "REPLACE INTO " . $t_nona_h . " SELECT * FROM " . $t_nona . "";
    if (mysqli_query($que_nona, $process)) // replace nonatero > history
    {
        $c_text = $c_text . "[SUCCESS] REPLACE INTO \"" . $t_nona_h . "\" FROM \"" . $t_nona . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] REPLACE INTO \"" . $t_nona_h . "\" FROM \"" . $t_nona . "\", PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "TRUNCATE TABLE " . $t_nona . "";
    if (mysqli_query($que_nona, $process)) // truncate nonatero
    {
        $c_text = $c_text . "[SUCCESS] TRUNCATE TABLE \"" . $t_nona . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] TRUNCATE TABLE \"" . $t_nona . "\", PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "
    LOAD DATA INFILE '" . $p_nonadata . "'
    INTO TABLE " . $t_nona . "
    FIELDS TERMINATED BY ';' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 2 LINES";
    if (mysqli_query($que_nona, $process)) // load from alldata to nonatero
    {
        $c_text = $c_text . "[SUCCESS] LOAD DATA INTO \"" . $t_nona . "\" FROM \"" . $nona_save_n . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona . "\" FROM \"" . $nona_save_n . "\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_nona . " AS nona_count";
    if ($stmt = $que_nona->prepare("" . $process . "")) {
        $stmt->execute();
        $stmt->bind_result($nona_count);

        $stmt->fetch();
        $stmt->close();

        $c_text = $c_text . "[SUCCESS] COUNT ROW TABLE \"" . $t_nona . "\"" . "<br>";
    }
    else {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] COUNT ROW TABLE \"" . $t_nona . "\"" . " FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_stat . "
    SET 
    nonatero = ?
    WHERE id = 1";
    if ($stmt = $que_nona->prepare("" . $process . "")) {
        $stmt->bind_param("i", $nona_count); 
        $stmt->execute();   // Execute the prepared query.

        $c_text = $c_text . "[SUCCESS] UPDATE COUNT STATISTIC FOR \"" . $t_nona . "\"" . "<br>";
    }
    else {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE COUNT STATISTIC FOR \"" . $t_nona . "\"" . "<br>";
    }
endif;

mysqli_close($que_nona);
