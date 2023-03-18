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
    $c_text = "# UPDATE DATA CMDF > NONATERO<br>--------------------</br>";
elseif(isset($c_text) && !$close):
    $c_text = $c_text . "# UPDATE DATA CMDF > NONATERO<br>--------------------</br>";
endif;

if(!$close):
    $process = "UPDATE nonatero join (select cmdf_plg.CMDF, cmdf_plg.ND from cmdf_plg) AS CMDF_TABLE SET nonatero.CMDF_RL = CMDF_TABLE.CMDF WHERE CMDF_TABLE.ND IN (nonatero.ND_TELP, nonatero.ND_INT)";

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
    $process = "UPDATE nonatero join (select * from cmdf_sto) AS CMDF_TABLE ON nonatero.CMDF = CMDF_TABLE.CMDF SET nonatero.STO = CMDF_TABLE.STO, nonatero.MITRA = CMDF_TABLE.MITRA, nonatero.SEGMEN = CMDF_TABLE.SEGMEN, nonatero.JENIS = CMDF_TABLE.JENIS";
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

echo $c_text;

mysqli_close($query);
