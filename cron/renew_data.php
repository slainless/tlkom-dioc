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
    $c_text = "# LOAD DATA POINT<br>--------------------</br>";
elseif(isset($c_text) && !$close):
    $c_text = $c_text . "# LOAD DATA POINT<br>--------------------</br>";
endif;

if(!$close):
    $process = "TRUNCATE " . $t_point . "";
    if (mysqli_query($query, $process)) // replace nonatero > history
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] TRUNCATE TABLE \"" . $t_point . "\"<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] REMOVE OLD DATA" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] TRUNCATE TABLE \"" . $t_point . "\", PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "REPLACE INTO " . $t_point . " (GAUL30_BACK, LAPUL, TROUBLE_NO, JAM, HARI, CHANNEL, HARDCOM, SLG, GGU, INDI_F, SLG_F, ODW_F, RHN_F, PLS_F, TIPE_CUST, CMDF_RL, JENIS, MITRA, STO, SEGMEN, ND_TELP, ND_INT, GGN_3P_F)
    SELECT GAUL30_BACK, LAPUL, TROUBLE_NO, JAM, HARI, CHANNEL, HARDCOM, SLG, GGU, INDI_F, SLG_F, ODW_F, RHN_F, PLS_F, TIPE_CUST, CMDF_RL, JENIS, MITRA, STO, SEGMEN, ND_TELP, ND_INT, GGN_3P_F FROM " . $t_nona . "";
    if (mysqli_query($query, $process)) // truncate nonatero
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] REPLACE INTO \"" . $t_point . "\" FROM \"" . $t_nona . "\"<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] INSERT NEW DATA" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] REPLACE INTO \"" . $t_point . "\" FROM \"" . $t_nona . "\", PROCESS TERMINATED...";
        $close = true;
    }
endif;

mysqli_close($query);
