<?php
    require_once "path_definer.php";

    require_once $p_conf;
    require_once $p_conn;
    require_once $p_incl."function/fetch_setting.php";


if(isset($_POST["insert"])):

    $array = $_POST["insert"];

    $pcs_arlen = count($array);

    $sto_list->data_seek(0);

    $op_sto = array();

    $op_sto[0][0] = "0";
    $op_sto[0][1] = "0";

    $x = 1;
    while($row = $sto_list->fetch_assoc()) {
        if($row["CMDF"] != ''){
            $op_sto[$x][0] = $x;
            $op_sto[$x][1] = $row["CMDF"];

            $x++;
        }
    }       

    $pcs_arlen_sto = count($op_sto);
    
    $z = 0;
    for($x = 0; $x < $pcs_arlen; $x++) {

            if(strlen($array[$x][1]) > 4 || strlen($array[$x][1]) < 13) {

                for($y = 0; $y < $pcs_arlen_sto; $y++) {

                    if($array[$x][2] == $op_sto[$y][0]) {

                        $nd = $array[$x][1];
                        $cmdf = $op_sto[$y][1];

                        if(empty($nd) && empty($cmdf)){
                            break;
                        }

                        if(empty($cmdf)){
                            $message[$z] = $array[$x][1]." - STO must not be empty.";
                            $alert[$z] = "warning";
                            break;
                        }

                        if ($stmt = $query->prepare("REPLACE INTO ".$t_nona_cmdf." (ND, CMDF)
                        VALUES (?, ?)")) {

                                $stmt->bind_param("ss", $nd, $cmdf); 
                                $stmt->execute();   // Execute the prepared query.
                                
                                $stmt->close();
                        }
                        else {
                            $message[$z] = $array[$x][1]." - query failed.";
                            $alert[$z] = "danger";
                            break;
                        }

                        if ($stmt = $query->prepare("UPDATE ".$t_nona_cmdf.",".$t_nona_sto." SET 
                        ".$t_nona_cmdf.".JENIS = ".$t_nona_sto.".JENIS,
                        ".$t_nona_cmdf.".MITRA = ".$t_nona_sto.".MITRA,
                        ".$t_nona_cmdf.".STO = ".$t_nona_sto.".STO,
                        ".$t_nona_cmdf.".SEGMEN = ".$t_nona_sto.".SEGMEN
                        WHERE ".$t_nona_cmdf.".CMDF = ".$t_nona_sto.".CMDF AND ".$t_nona_cmdf.".ND = ?")) {

                                $stmt->bind_param("s", $nd); 
                                $stmt->execute();   // Execute the prepared query.
                                
                                $stmt->close();
                        }
                        else {
                            $message[$z] = $array[$x][1]." - query failed.";
                            $alert[$z] = "danger";
                            break;
                        }

                        if ($stmt = $query->prepare("
                        UPDATE ".$t_point." join (SELECT * FROM ".$t_nona_cmdf." WHERE ND = ?) AS CMDF SET 
                        ".$t_point.".CMDF_RL = CMDF.CMDF,
                        ".$t_point.".JENIS = CMDF.JENIS,
                        ".$t_point.".MITRA = CMDF.MITRA,
                        ".$t_point.".STO = CMDF.STO,
                        ".$t_point.".SEGMEN = CMDF.SEGMEN
                        WHERE ".$t_point.".ND_TELP = ?
                        OR ".$t_point.".ND_INT = ?")) {

                                $stmt->bind_param("sss", $nd, $nd, $nd); 
                                $stmt->execute();   // Execute the prepared query.
                                
                                $stmt->close();

                        }
                        else {
                            $message[$z] = $array[$x][1]." - query failed.";
                            $alert[$z] = "danger";
                        }

                        if ($stmt = $query->prepare("
                        UPDATE ".$t_nona." join (SELECT * FROM ".$t_nona_cmdf." WHERE ND = ?) AS CMDF SET 
                        ".$t_nona.".CMDF_RL = CMDF.CMDF,
                        ".$t_nona.".JENIS = CMDF.JENIS,
                        ".$t_nona.".MITRA = CMDF.MITRA,
                        ".$t_nona.".STO = CMDF.STO,
                        ".$t_nona.".SEGMEN = CMDF.SEGMEN
                        WHERE ".$t_nona.".ND_TELP = ?
                        OR ".$t_nona.".ND_INT = ?")) {

                                $stmt->bind_param("sss", $nd, $nd, $nd); 
                                $stmt->execute();   // Execute the prepared query.
                                
                                $stmt->close();

                                $message[$z] = $array[$x][1]." - data inserted.";
                                $alert[$z] = "success";

                        }
                        else {
                            $message[$z] = $array[$x][1]." - query failed.";
                            $alert[$z] = "danger";
                        }

                        break;
                    }
                    else {
                        $message[$z] = $array[$x][1]." - data STO masukan salah.";
                        $alert[$z] = "danger";
                    }
                }

            }
            else {
                # return false strlen too long/short;
                $message[$z] = $array[$x][1]." - data minimal 5 - 12 digit.";
                $alert[$z] = "danger";
            }
    $z++;
    }
endif;