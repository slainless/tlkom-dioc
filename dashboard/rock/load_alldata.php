<?php
require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
require $p_svropt;
require $p_cnona;

require $p_inc . "database/fetch_setting.php";

if(!isset($close)){
    $close = false;
}

if(!$close):
    if(!file_exists($p_rockdata)) {
        if(!isset($c_text)) {
            $c_text = "[ERROR&nbsp;&nbsp;] FILE \"" . $rock_save_n . "\" NOT FOUND, PROCESS TERMINATED...";
        }
        else {
            $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $rock_save_n . "\" NOT FOUND, PROCESS TERMINATED...";
        }
        $close = true;
    }
    else {
        if(!isset($c_text)) {
            $c_text = "[SUCCESS] FILE \"" . $rock_save_n . "\" FOUND" . "<br>";
        }
        else {
            $c_text = $c_text . "[SUCCESS] FILE \"" . $rock_save_n . "\" FOUND" . "<br>";
        }
    }
endif;

if(!$close):
    $check_result = substr(file_get_contents($p_rockdata), 0, 4);
    if($check_result != "regi") {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED...";
        $close = true;
    }
    else {
        $c_text = $c_text . "[SUCCESS] FILE CONTENT VALID" . "<br>";
    }
endif;

if(!$close):
    $process = "REPLACE INTO " . $t_rock_h . " SELECT * FROM " . $t_rock . "";
    if (mysqli_query($que_nona, $process)) {
        $c_text = $c_text . "[SUCCESS] REPLACE INTO \"" . $t_rock_h . "\" FROM \"" . $t_rock . "\"<br>";
    }
    else {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] REPLACE INTO \"" . $t_rock_h . "\" FROM \"" . $t_rock . "\", PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "TRUNCATE TABLE " . $t_rock . "";
    if (mysqli_query($que_nona, $process)) {
        $c_text = $c_text . "[SUCCESS] TRUNCATE TABLE \"" . $t_rock . "\"<br>";
    }
    else {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] TRUNCATE TABLE \"" . $t_rock . "\", PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "
    LOAD DATA INFILE '" . $p_rockdata . "'
    INTO TABLE " . $t_rock . "
    FIELDS TERMINATED BY '\t' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 1 LINES";
    if (mysqli_query($que_nona, $process)) {
        $c_text = $c_text . "[SUCCESS] LOAD DATA INTO \"" . $t_rock . "\" FROM \"" . $rock_save_n . "\"<br>";
    }
    else {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_rock . "\" FROM \"" . $rock_save_n . "\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_rock . " AS rock_count";
    if ($stmt = $que_nona->prepare("" . $process . "")) {
        $stmt->execute();
        $stmt->bind_result($rock_count);

        $stmt->fetch();
        $stmt->close();

        $c_text = $c_text . "[SUCCESS] COUN&T ROW TABLE \"" . $t_rock . "\"" . "<br>";
    }
    else {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] COUNT ROW TABLE \"" . $t_rock . "\"" . " FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_stat . "
    SET 
    rock = ?
    WHERE id = 1";
    if ($stmt = $que_nona->prepare("" . $process . "")) {
        $stmt->bind_param("i", $rock_count); 
        $stmt->execute();   // Execute the prepared query.

        $c_text = $c_text . "[SUCCESS] UPDATE COUNT STATISTIC FOR \"" . $t_rock . "\"" . "<br>";
    }
    else {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE COUNT STATISTIC FOR \"" . $t_rock . "\"" . "<br>";
    }
endif;

mysqli_close($que_nona);
