<?php
    require_once "path_definer.php";

    require "server_config.php";
    require "fetch_setting.php";
    require "connection.php";

    if(!isset($close)){
        $close = false;
    }

    if(!isset($debug)){
        $debug = false;
    }

if(!isset($c_text) && !$close):
    $c_text = "# LOAD DATA NONATERO<br>--------------------</br>";
elseif(isset($c_text) && !$close):
    $c_text = $c_text . "# LOAD DATA NONATERO<br>--------------------</br>";
endif;

if(!$close):
    if(!file_exists($p_nonadata)) {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_save_n . "\" NOT FOUND, PROCESS TERMINATED...";
        $close = true;
    }
    else {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_save_n . "\" FOUND" . "<br>";
        endif;
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
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE CONTENT VALID" . "<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] READ FILE CONTENT" . "<br>";
    }
endif;

if(!$close):
    $process = "REPLACE INTO " . $t_nona_h . " SELECT * FROM " . $t_nona . "";
    if (mysqli_query($query, $process)) // replace nonatero > history
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] REPLACE INTO \"" . $t_nona_h . "\" FROM \"" . $t_nona . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] REPLACE INTO \"" . $t_nona_h . "\" FROM \"" . $t_nona . "\", PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "TRUNCATE TABLE " . $t_nona . "";
    if (mysqli_query($query, $process)) // truncate nonatero
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] TRUNCATE TABLE \"" . $t_nona . "\"<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] REMOVE OLD DATA" . "<br>";
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
    if (mysqli_query($query, $process)) // load from alldata to nonatero
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona . "\" FROM \"" . $nona_save_n . "\"<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] INSERT NEW DATA" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona . "\" FROM \"" . $nona_save_n . "\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_nona . " AS nona_count";
    if ($stmt = $query->prepare("" . $process . "")) {
        $stmt->execute();
        $stmt->bind_result($nona_count);

        $stmt->fetch();
        $stmt->close();

        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] COUNT ROW TABLE \"" . $t_nona . "\"" . "<br>";
        endif;
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
    if ($stmt = $query->prepare("" . $process . "")) {
        $stmt->bind_param("i", $nona_count); 
        $stmt->execute();   // Execute the prepared query.

        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE COUNT STATISTIC FOR \"" . $t_nona . "\"" . "<br>";
        endif;
        $c_text = $c_text . "--------------------" . "<br>";
    }
    else {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE COUNT STATISTIC FOR \"" . $t_nona . "\"" . "<br>";
    }
endif;

mysqli_close($query);
