<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $p_incl."function/fetch_setting.php";

    if(!isset($close)){
        $close = false;
    }

    if(!isset($debug)){
        $debug = false;
    }

if(!isset($c_text) && !$close):
    $c_text = "# UPDATE DATA CMDF > NONATERO<br>--------------------</br>";
elseif(isset($c_text) && !$close):
    $c_text = $c_text . "# UPDATE DATA CMDF > NONATERO<br>--------------------</br>";
endif;

if(!$close):
    $process = "UPDATE ".$t_nona." join (select ".$t_nona_cmdf.".CMDF, ".$t_nona_cmdf.".ND from ".$t_nona_cmdf.") AS CMDF_TABLE ON ".$t_nona.".ND_TELP = CMDF_TABLE.ND or ".$t_nona.".ND_INT = CMDF_TABLE.ND SET ".$t_nona.".CMDF_RL = CMDF_TABLE.CMDF ";
    if (mysqli_query($query, $process)) // truncate nona tc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE DATA \"" . $t_nona . "\" FROM \"" . $t_nona_cmdf . "\"<br>";
        endif;
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE DATA \"" . $t_nona . "\" FROM \"" . $t_nona_cmdf . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

if(!$close):
    $process = "UPDATE ".$t_nona." join (select * from ".$t_nona_sto.") AS CMDF_TABLE ON ".$t_nona.".CMDF = CMDF_TABLE.CMDF SET ".$t_nona.".STO = CMDF_TABLE.STO, ".$t_nona.".MITRA = CMDF_TABLE.MITRA, ".$t_nona.".SEGMEN = CMDF_TABLE.SEGMEN, ".$t_nona.".JENIS = CMDF_TABLE.JENIS";
    if (mysqli_query($query, $process)) // truncate nona hc
    {
        if($debug == true):
            $c_text = $c_text . "[DEBUG&nbsp;&nbsp;] UPDATE INFO CMDF \"" . $t_nona . "\"<br>";
        endif;
        $c_text = $c_text . "[SUCCESS] UPDATE DATA CMDF > NONATERO" . "<br>";
    }
    else
    {
        $c_text = $c_text . "[ERROR&nbsp;&nbsp;] UPDATE INFO CMDF \"" . $t_nona . "\", PROCESS TERMINATED..." . "</br>";
        $close = true;
    }
endif;

mysqli_close($query);
