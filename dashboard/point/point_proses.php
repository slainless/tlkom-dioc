<?php

    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;

    require_once $webframe."webf_function.php";

    if (isset($_POST["odw"], $_POST["lpl"], $_POST["rhn"], $_POST["ind"], $_POST["ggu"], $_POST["slg"], $_POST["pls"], $_POST["hcm"], $_POST["gll"], $_POST["g3p"])):
        // Sanitize and validate the data passed in
    
        $odw = filter_input(INPUT_POST, 'odw', FILTER_SANITIZE_NUMBER_FLOAT);
        $lpl = filter_input(INPUT_POST, 'lpl', FILTER_SANITIZE_NUMBER_FLOAT);
        $rhn = filter_input(INPUT_POST, 'rhn', FILTER_SANITIZE_NUMBER_FLOAT);
        $ind = filter_input(INPUT_POST, 'ind', FILTER_SANITIZE_NUMBER_FLOAT);
        $ggu = filter_input(INPUT_POST, 'ggu', FILTER_SANITIZE_NUMBER_FLOAT);
        $slg = filter_input(INPUT_POST, 'slg', FILTER_SANITIZE_NUMBER_FLOAT);
        $pls = filter_input(INPUT_POST, 'pls', FILTER_SANITIZE_NUMBER_FLOAT);
        $hcm = filter_input(INPUT_POST, 'hcm', FILTER_SANITIZE_NUMBER_FLOAT);
        $gll = filter_input(INPUT_POST, 'gll', FILTER_SANITIZE_NUMBER_FLOAT);
        $g3p = filter_input(INPUT_POST, 'g3p', FILTER_SANITIZE_NUMBER_FLOAT);

        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        // 
        if(empty($message)):

            if($_SESSION["level"] == 1):

                if(empty($message)):
                    $prep_stmt = "UPDATE ".$t_point_cfg." SET ORDER_DEWA = ?, LAPUL = ?, RIHANA = ?, MY_INDIHOME = ?, GGU_TUA = ?, SLG = ?, PLASA = ?, HARD_COMPLAIN = ?, GAUL = ?, GGN_3P = ? WHERE ID = 1";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('ssssssssss', $odw, $lpl, $rhn, $ind, $ggu, $slg, $pls, $hcm, $gll, $g3p);
                        $stmt->execute();
                        $stmt->close();

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                    }
                endif;

                if(empty($message)):
                    $prep_stmt = "call nona_upoin()";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->execute();
                        $stmt->close();
       
                        $message = 'Config updated.';
                        $alert = 'success';

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                    }
                endif;

            else:
                $message = "Don't try to hack!";
                $alert = 'danger';
            endif;
        endif;
    endif;