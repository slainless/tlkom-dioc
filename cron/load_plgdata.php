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
    $c_text = "# LOAD DATA PELANGGAN<br>--------------------</br>";
elseif(isset($c_text) && !$close):
    $c_text = $c_text . "# LOAD DATA PELANGGAN<br>--------------------</br>";
endif;

if(!$close):
    if(!file_exists($p_nonaslv))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_slv_n . "\" NOT FOUND, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_slv_n . "\" FOUND" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonaslv), 0, 4) != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_slv_n . "\" VALID" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(!file_exists($p_nonattn))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_ttn_n . "\" NOT FOUND, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_ttn_n . "\" FOUND" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonattn), 0, 4) != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_ttn_n . "\" VALID" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(!file_exists($p_nonaplt))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_plt_n . "\" NOT FOUND, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_plt_n . "\" FOUND" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonaplt), 0, 4) != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_plt_n . "\" VALID" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(!file_exists($p_nonabsn))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_bsn_n . "\" NOT FOUND, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_bsn_n . "\" FOUND" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonabsn), 0, 4) != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_bsn_n . "\" VALID" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(!file_exists($p_nonaent))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_ent_n . "\" NOT FOUND, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_ent_n . "\" FOUND" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonaent), 0, 4) != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_ent_n . "\" VALID" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(!file_exists($p_nonahc))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_hc_n . "\" NOT FOUND, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_hc_n . "\" FOUND" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonahc), 0, 4) != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_hc_n . "\" VALID" . "<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] READ FILE CONTENT" . "<br>";
    }
endif;


if(!$close):
    if(!file_exists($p_nonag3p))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_g3p_n . "\" NOT FOUND, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_g3p_n . "\" FOUND" . "<br>";
        endif;
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonag3p), 0, 4) != "CONN")
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] INVALID FILE CONTENT, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
    else
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] FILE \"" . $nona_g3p_n . "\" VALID" . "<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] READ FILE CONTENT" . "<br>";
    }
endif;

if(!$close):
    $process = "CREATE TABLE " . $t_nona_tc . "(
    TROUBLE_NO char(10) NOT NULL,
    ID_TIPE tinyint(1) NOT NULL,
    TIPE_CUST varchar(15) NOT NULL,
    SLG tinyint(1) NOT NULL
    )";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] CREATE TABLE \"" . $t_nona_tc . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] CREATE TABLE \"" . $t_nona_tc . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "CREATE TABLE " . $t_nona_hc . "(
    TROUBLE_NO varchar(20) NOT NULL,
    hardcom int(10) NOT NULL DEFAULT '1'
    )";
    if (mysqli_query($query, $process)) // truncate nona hc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] CREATE TABLE \"" . $t_nona_hc . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] CREATE TABLE \"" . $t_nona_hc . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "CREATE TABLE " . $t_nona_g3p . "(
    TROUBLE_NO varchar(20) NOT NULL,
    ggn_3p int(10) NOT NULL DEFAULT '1'
    )";
    if (mysqli_query($query, $process)) // CREATE nona hc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] CREATE TABLE \"" . $t_nona_g3p . "\"<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] CREATE TEMPORARY TABLE" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] CREATE TABLE \"" . $t_nona_g3p . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "LOAD DATA INFILE '" . $p_nonaslv . "'
    INTO TABLE " . $t_nona_tc . " 
    FIELDS TERMINATED BY ';' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 2 LINES
    (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_slv_n . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_slv_n . "\" FAILED, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 1";
    if (mysqli_query($query, $process)) // set load data #1 as silver
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE SILVER" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE SILVER, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "LOAD DATA INFILE '" . $p_nonattn . "'
    INTO TABLE " . $t_nona_tc . " 
    FIELDS TERMINATED BY ';' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 2 LINES
    (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_ttn_n . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_ttn_n . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 2 WHERE ID_TIPE = 0";
    if (mysqli_query($query, $process)) // set load data #1 as silver
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE TITANIUM" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE TITANIUM, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "LOAD DATA INFILE '" . $p_nonaplt . "'
    INTO TABLE " . $t_nona_tc . " 
    FIELDS TERMINATED BY ';' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 2 LINES
    (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_plt_n . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_plt_n . "\" FAILED, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 3 WHERE ID_TIPE = 0";
    if (mysqli_query($query, $process)) // set load data #1 as silver
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE PLATINUM" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE PLATINUM, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "LOAD DATA INFILE '" . $p_nonabsn . "'
    INTO TABLE " . $t_nona_tc . " 
    FIELDS TERMINATED BY ';' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 2 LINES
    (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_bsn_n . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_bsn_n . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 4 WHERE ID_TIPE = 0";
    if (mysqli_query($query, $process)) // set load data #1 as silver
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE BUSINESS" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE BUSINESS, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "LOAD DATA INFILE '" . $p_nonaent . "'
    INTO TABLE " . $t_nona_tc . " 
    FIELDS TERMINATED BY ';' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 2 LINES
    (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_ent_n . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_ent_n . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 5 WHERE ID_TIPE = 0";
    if (mysqli_query($query, $process)) // set load data #1 as silver
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE ENTERPRISE" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE ENTERPRISE, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "LOAD DATA INFILE '" . $p_nonahc . "'
    INTO TABLE " . $t_nona_hc . " 
    FIELDS TERMINATED BY ';' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 2 LINES
    (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_hc . "\" FROM \"" . $nona_hc_n . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_hc . "\" FROM \"" . $nona_hc_n . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "LOAD DATA INFILE '" . $p_nonag3p . "'
    INTO TABLE " . $t_nona_g3p . " 
    FIELDS TERMINATED BY ';' 
    OPTIONALLY ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 2 LINES
    (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_g3p . "\" FROM \"" . $nona_g3p_n . "\"<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] INSERT NEW DATA" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_g3p . "\" FROM \"" . $nona_g3p_n . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET TIPE_CUST = CASE
    WHEN ID_TIPE = 1 THEN 'SILVER'
    WHEN ID_TIPE = 2 THEN 'TITANIUM/GOLD'
    WHEN ID_TIPE = 3 THEN 'PLATINUM'
    WHEN ID_TIPE = 4 THEN 'BUSINESS'
    WHEN ID_TIPE = 5 THEN 'ENTERPRISE'
    END";

    if (mysqli_query($query, $process)) // set tipe_cust with case
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET TIPE_CUST" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET TIPE_CUST, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET SLG = CASE
    WHEN ID_TIPE = 1 THEN '72'
    WHEN ID_TIPE = 2 THEN '48'
    WHEN ID_TIPE = 3 THEN '24'
    WHEN ID_TIPE = 4 THEN '12'
    WHEN ID_TIPE = 5 THEN '6'
    END";

    if (mysqli_query($query, $process)) // set tipe_cust with case
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET SLG" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET SLG, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona . ", " . $t_nona_tc . " 
    SET 
    " . $t_nona . ".TIPE_CUST = " . $t_nona_tc . ".TIPE_CUST,
    " . $t_nona . ".SLG = " . $t_nona_tc . ".SLG
    WHERE 
    " . $t_nona . ".TROUBLE_NO = " . $t_nona_tc . ".TROUBLE_NO";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET SLG FROM \"" . $t_nona_tc . "\"" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET SLG FROM \"" . $t_nona_tc . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona . ", " . $t_nona_hc . " 
    SET 
    " . $t_nona . ".HARDCOM = " . $t_nona_hc . ".hardcom
    WHERE 
    " . $t_nona . ".TROUBLE_NO = " . $t_nona_hc . ".TROUBLE_NO";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET HARDCOM FROM \"" . $t_nona_hc . "\"" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET HARDCOM FROM \"" . $t_nona_hc . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona . ", " . $t_nona_g3p . " 
    SET 
    " . $t_nona . ".GGN_3P_F = " . $t_nona_g3p . ".ggn_3p
    WHERE 
    " . $t_nona . ".TROUBLE_NO = " . $t_nona_g3p . ".TROUBLE_NO";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET HARDCOM FROM \"" . $t_nona_g3p . "\"" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET HARDCOM FROM \"" . $t_nona_g3p . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "
    UPDATE " . $t_nona . " 
    SET GGU = CASE 
    WHEN HARI > 3 AND HARI < 8 THEN 1 
    WHEN HARI > 7 AND HARI < 16 THEN 2 
    WHEN HARI > 15 AND HARI < 22 THEN 3 
    WHEN HARI > 21 AND HARI < 31 THEN 4 
    WHEN HARI > 30 THEN 5 
    END";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET GGU" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET GGU, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "
    UPDATE " . $t_nona . " 
    SET SLG_F = CASE 
    WHEN SLG > JAM THEN 1
    WHEN SLG < JAM THEN 0
    END";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET SLG" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET SLG, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "
    UPDATE " . $t_nona . " 
    SET INDI_F = CASE 
    WHEN CHANNEL = 'MY INDIHOME' THEN 1
    END";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET INDI" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET INDI, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona . ", " . $t_nona_rhn . " 
    SET 
    " . $t_nona . ".RHN_F = 1
    WHERE 
    " . $t_nona . ".TROUBLE_NO = " . $t_nona_rhn . ".TROUBLE_NO";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET RIHANA" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET RIHANA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona . ", " . $t_nona_pls . " 
    SET 
    " . $t_nona . ".PLS_F = 1
    WHERE 
    " . $t_nona . ".TROUBLE_NO = " . $t_nona_pls . ".TROUBLE_NO";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET PLASA" . "<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET PLASA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona . ", " . $t_nona_odw . " 
    SET 
    " . $t_nona . ".ODW_F = 1
    WHERE 
    " . $t_nona . ".TROUBLE_NO = " . $t_nona_odw . ".TROUBLE_NO";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET DEWA" . "<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] UPDATE FLAG PELANGGAN" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona . "\" SET DEWA, PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "DROP TABLE " . $t_nona_tc . ", " . $t_nona_hc . ", " . $t_nona_g3p . "";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] DROP TABLE \"" . $t_nona_tc . "\", \"" . $t_nona_hc . "\", \"" . $t_nona_g3p . "\"" . "<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] DROP TEMPORARY TABLE" . "<br>";
        $c_text = $c_text . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] DROP TABLE \"" . $t_nona_tc . "\", \"" . $t_nona_hc . "\", \"" . $t_nona_g3p . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

mysqli_close($query);
