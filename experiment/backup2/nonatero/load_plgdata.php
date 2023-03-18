<?php
require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
require $p_svropt;
require $p_cnona;

require $p_inc . "database/fetch_setting.php";

if(!isset($close)){
    $close = false;
}

if(!$close):
    if(!file_exists($p_nonaslv))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_slv_n . "\" NOT FOUND, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FILE \"" . $nona_slv_n . "\" FOUND" . "<br>";
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonaslv), 0, 4) != "CONN")
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
    if(!file_exists($p_nonattn))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_ttn_n . "\" NOT FOUND, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FILE \"" . $nona_ttn_n . "\" FOUND" . "<br>";
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonattn), 0, 4) != "CONN")
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
    if(!file_exists($p_nonaplt))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_plt_n . "\" NOT FOUND, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FILE \"" . $nona_plt_n . "\" FOUND" . "<br>";
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonaplt), 0, 4) != "CONN")
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
    if(!file_exists($p_nonabsn))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_bsn_n . "\" NOT FOUND, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FILE \"" . $nona_bsn_n . "\" FOUND" . "<br>";
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonabsn), 0, 4) != "CONN")
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
    if(!file_exists($p_nonaent))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_ent_n . "\" NOT FOUND, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FILE \"" . $nona_ent_n . "\" FOUND" . "<br>";
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonaent), 0, 4) != "CONN")
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
    if(!file_exists($p_nonahc))
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] FILE \"" . $nona_hc_n . "\" NOT FOUND, PROCESS TERMINATED...";
        $close = true;
    }
    else
    {
        $c_text = $c_text . "[SUCCESS] FILE \"" . $nona_hc_n . "\" FOUND" . "<br>";
    }
endif;

if(!$close):
    if(substr(file_get_contents($p_nonahc), 0, 4) != "CONN")
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
    $process = "TRUNCATE TABLE " . $t_nona_tc . "";
    if (mysqli_query($que_nona, $process)) // truncate nona tc
    {
        $c_text = $c_text . "[SUCCESS] TRUNCATE TABLE \"" . $t_nona_tc . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] TRUNCATE TABLE \"" . $t_nona_tc . "\", PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "TRUNCATE TABLE " . $t_nona_hc . "";
    if (mysqli_query($que_nona, $process)) // truncate nona hc
    {
        $c_text = $c_text . "[SUCCESS] TRUNCATE TABLE \"" . $t_nona_hc . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] TRUNCATE TABLE \"" . $t_nona_hc . "\", PROCESS TERMINATED...";
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
    if (mysqli_query($que_nona, $process)) // truncate nona tc
    {
        $c_text = $c_text . "[SUCCESS] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_slv_n . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_slv_n . "\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 1";
    if (mysqli_query($que_nona, $process)) // set load data #1 as silver
    {
        $c_text = $c_text . "[SUCCESS] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 1 WHERE ID_TIPE = DEFAULT" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 1 WHERE ID_TIPE = DEFAULT FAILED, PROCESS TERMINATED...";
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
    (@dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, TROUBLE_NO, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy, @dummy)";
    if (mysqli_query($que_nona, $process)) // truncate nona tc
    {
        $c_text = $c_text . "[SUCCESS] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_ttn_n . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_ttn_n . "\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 2 WHERE ID_TIPE = 0";
    if (mysqli_query($que_nona, $process)) // set load data #1 as silver
    {
        $c_text = $c_text . "[SUCCESS] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 2 WHERE ID_TIPE = DEFAULT" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 2 WHERE ID_TIPE = DEFAULT FAILED, PROCESS TERMINATED...";
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
    if (mysqli_query($que_nona, $process)) // truncate nona tc
    {
        $c_text = $c_text . "[SUCCESS] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_plt_n . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_plt_n . "\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 3 WHERE ID_TIPE = 0";
    if (mysqli_query($que_nona, $process)) // set load data #1 as silver
    {
        $c_text = $c_text . "[SUCCESS] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 3 WHERE ID_TIPE = DEFAULT" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 3 WHERE ID_TIPE = DEFAULT FAILED, PROCESS TERMINATED...";
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
    if (mysqli_query($que_nona, $process)) // truncate nona tc
    {
        $c_text = $c_text . "[SUCCESS] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_bsn_n . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_bsn_n . "\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 4 WHERE ID_TIPE = 0";
    if (mysqli_query($que_nona, $process)) // set load data #1 as silver
    {
        $c_text = $c_text . "[SUCCESS] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 4 WHERE ID_TIPE = DEFAULT" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 4 WHERE ID_TIPE = DEFAULT FAILED, PROCESS TERMINATED...";
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
    if (mysqli_query($que_nona, $process)) // truncate nona tc
    {
        $c_text = $c_text . "[SUCCESS] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_ent_n . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_tc . "\" FROM \"" . $nona_ent_n . "\" FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE " . $t_nona_tc . " SET ID_TIPE = 5 WHERE ID_TIPE = 0";
    if (mysqli_query($que_nona, $process)) // set load data #1 as silver
    {
        $c_text = $c_text . "[SUCCESS] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 5 WHERE ID_TIPE = DEFAULT" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET ID_TIPE = 5 WHERE ID_TIPE = DEFAULT FAILED, PROCESS TERMINATED...";
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
    if (mysqli_query($que_nona, $process)) // truncate nona tc
    {
        $c_text = $c_text . "[SUCCESS] LOAD DATA INTO \"" . $t_nona_hc . "\" FROM \"" . $nona_hc_n . "\"<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] LOAD DATA INTO \"" . $t_nona_hc . "\" FROM \"" . $nona_hc_n . "\" FAILED, PROCESS TERMINATED...";
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

    if (mysqli_query($que_nona, $process)) // set tipe_cust with case
    {
        $c_text = $c_text . "[SUCCESS] UPDATE TABLE \"" . $t_nona_tc . "\" SET TIPE_CUST VIA CASE OF ID_TIPE" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET TIPE_CUST VIA CASE OF ID_TIPE FAILED, PROCESS TERMINATED...";
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

    if (mysqli_query($que_nona, $process)) // set tipe_cust with case
    {
        $c_text = $c_text . "[SUCCESS] UPDATE TABLE \"" . $t_nona_tc . "\" SET SLG VIA CASE OF ID_TIPE" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE TABLE \"" . $t_nona_tc . "\" SET SLG VIA CASE OF ID_TIPE FAILED, PROCESS TERMINATED...";
        $close = true;
    }
endif;

mysqli_close($que_nona);
