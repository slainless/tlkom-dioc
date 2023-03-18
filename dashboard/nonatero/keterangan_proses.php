<?php

    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;

    require_once $webframe."webf_function.php";

    $ind = $iketerangan = $iexpire = '';

    if (isset($_POST['nd'], $_POST['keterangan'], $_POST['expire'])):
        // Sanitize and validate the data passed in
        $x = 0;
        $nd = filter_input(INPUT_POST, 'nd', FILTER_SANITIZE_NUMBER_INT);
        $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_SPECIAL_CHARS);

        $expire = $_POST['expire'];

        if(!empty($expire)){
            $expire = explode("/", $expire);
            $expire = $expire[2]."-".$expire[1]."-".$expire[0];
        }

        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        // 
        if($_SESSION["level"] < 3):

                if(empty($message)):
                    $prep_stmt = "REPLACE INTO ".$t_nona_ket." VALUES (?, ?, ?)";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('sss', $nd, $keterangan, $expire);
                        $stmt->execute();
                        $stmt->close();

                        $message = 'Data Updated.';
                        $alert = 'success';

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';

                    }
                endif;

        else:
            $message = "Don't try to hack!";
            $alert = 'danger';
            $x++;
        endif;
    endif;