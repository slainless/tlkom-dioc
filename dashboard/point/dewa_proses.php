<?php

    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;

    require_once $webframe."webf_function.php";

    $itiket = $ind = $idewa = $iketerangan = $iperbaikan = $iflag = '';

    if (isset($_POST['tiket'], $_POST['nd'], $_POST['dewa'], $_POST['keterangan'], $_POST['perbaikan'], $_POST['flag'], $_POST['mode'])):
        // Sanitize and validate the data passed in
        $x = 0;
        $tiket = filter_input(INPUT_POST, 'tiket', FILTER_SANITIZE_STRING);
        $nd = filter_input(INPUT_POST, 'nd', FILTER_SANITIZE_NUMBER_INT);
        
        $dewa = filter_input(INPUT_POST, 'dewa', FILTER_SANITIZE_STRING);

        $perbaikan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_SPECIAL_CHARS);
        $keterangan = filter_input(INPUT_POST, 'perbaikan', FILTER_SANITIZE_SPECIAL_CHARS);
        $flag = filter_input(INPUT_POST, 'flag', FILTER_SANITIZE_EMAIL);

        $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_NUMBER_INT);

        if(strpos($flag, "rgb") !== false){
            $flag = '';
        }

        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        // 
        if(empty($message)):

            if($mode == 0 && $_SESSION["level"] < 3):

                $prep_stmt = "SELECT * FROM ".$t_nona_odw." WHERE TROUBLE_NO = ? LIMIT 1";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('s', $tiket);
                        $stmt->execute();
                        $stmt->store_result();
                        
                        if ($stmt->num_rows == 1) {
                            // A user with this email address already exists
                            $message = 'Data already exist.';
                            $alert = 'warning';
                            $x++;
                        }
                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                        $x++;
                    }

                if(empty($message)):
                    $prep_stmt = "INSERT INTO ".$t_nona_odw." VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('ssssss', $tiket, $nd, $dewa, $keterangan, $perbaikan, $flag);
                        $stmt->execute();
                        $stmt->close();
                    
                        $x++;

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                        $x++;
                    }
                endif;

                if(empty($message)):
                    $prep_stmt = "UPDATE ".$t_nona." SET ODW_F = 1 WHERE TROUBLE_NO = ?";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('s', $tiket);
                        $stmt->execute();
                        $stmt->close();

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                        $x++;
                    }
                endif;

                if(empty($message)):
                    $prep_stmt = "UPDATE ".$t_point." SET ODW_F = 1 WHERE TROUBLE_NO = ?";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('s', $tiket);
                        $stmt->execute();
                        $stmt->close();

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                        $x++;
                    }
                endif;

                if(empty($message)):
                    $prep_stmt = "call nona_upoin_single(?)";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('s', $tiket);
                        $stmt->execute();
                        $stmt->close();
       
                        $message = 'Data inserted.';
                        $alert = 'success';
                        $x++;

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                        $x++;
                    }
                endif;

            elseif($mode == 1 && $_SESSION["level"] < 3):

                if(empty($message)):
                    $prep_stmt = "UPDATE ".$t_nona_odw." SET ND = ?, DEWA = ?, KETERANGAN = ?, PERBAIKAN = ?, FLAG_COLOR = ? WHERE TROUBLE_NO = ?";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('ssssss', $nd, $dewa, $keterangan, $perbaikan, $flag, $tiket);
                        $stmt->execute();
                        
                        $message = 'Data edited.';
                        $alert = 'success';
                        $mode = 0;
                        $itiket = $ind = $idewa = $iketerangan = $iperbaikan = $iflag = '';
                        $x++;

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                        $x++;
                    }
                endif;

            else:
                $message = "Don't try to hack!";
                $alert = 'danger';
                $x++;
            endif;
        endif;
    endif;