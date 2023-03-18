<?php

function cdt_create($value, $field, $array){

    $pcs_space = " = ";

    $processor = $value;
    $pcs_field = $field;

    $pcs_array = $array;
    $pcs_arlen = count($pcs_array);

    if($processor == 0){
        return "1";
    }
    else {
        for($x = 0; $x < $pcs_arlen; $x++) {
            /*$pcs_arlen_nd = count($pcs_array[$x]);

            for($y = 0; $y < $pcs_arlen_nd; $y++) {
                    
            }*/
            if($processor == $pcs_array[$x][0]) {
                return $pcs_field.$pcs_space.$pcs_array[$x][2];
            }
        }
    }
}

    $_GET["tiket"] = 3;

    $op_tiket = array(
        array(0,"# Tipe Tiket",1),
        array(1,"Fisik","FISIK"),
        array(2,"Billing","BILLING"),
        array(3,"Logic","LOGIC"),
        array(4,"Non-Teknis","NON-TEKNIS"),
    );

    $result = cdt_create(0, "TIPE_TIKET", $op_tiket);


?>