<?php

    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;

    require_once $webframe."webf_function.php";

    if (isset($_POST['tiket'], $_POST['remove'])) {
        // Sanitize and validate the data passed in
        
        $id = filter_input(INPUT_POST, 'tiket', FILTER_SANITIZE_STRING);
        $remove = filter_input(INPUT_POST, 'remove', FILTER_SANITIZE_NUMBER_INT);

        if (empty($id)) {
            // The hashed pwd should be 128 characters long.
            // If it's not, something really odd has happened
            $message = "Tiket is empty";
            $alert = 'warning';
        }

        if(empty($message) && $remove == 1):
            $prep_stmt = "SELECT TROUBLE_NO FROM ".$t_nona_rhn." WHERE TROUBLE_NO = ? LIMIT 1";
            $stmt = $query->prepare($prep_stmt);
            
            if ($stmt) {
                $stmt->bind_param('s', $id);
                $stmt->execute();
                $stmt->bind_result($tiket);
                $stmt->fetch();

                if (empty($id)) {
                // The hashed pwd should be 128 characters long.
                // If it's not, something really odd has happened
                    $message = "Data empty.";
                    $alert = 'danger';
                }

                $stmt->close();

            }
            else {
                $message = 'Query Select failed.';
                $alert = 'danger';
            }
        endif;

        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        if(empty($message) && $remove == 1){

            if($_SESSION["level"] < 3):
                $prep_stmt = "DELETE FROM ".$t_nona_rhn." WHERE TROUBLE_NO = ?";
                $stmt = $query->prepare($prep_stmt);
                
                if ($stmt) {
                    $stmt->bind_param('s', $id);
                    $stmt->execute();

                    $stmt->close();
                }
                else {
                    $message = 'Query Remove failed.';
                    $alert = 'danger';
                }

                if(empty($message)):
                    $prep_stmt = "UPDATE ".$t_nona." SET RHN_F = 0 WHERE TROUBLE_NO = ?";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('s', $id);
                        $stmt->execute();
                        $stmt->close();

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                    }
                endif;

                if(empty($message)):
                    $prep_stmt = "UPDATE ".$t_point." SET RHN_F = 0 WHERE TROUBLE_NO = ?";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('s', $id);
                        $stmt->execute();
                        $stmt->close();

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                    }
                endif;

                if(empty($message)):
                    $prep_stmt = "call nona_upoin_single(?)";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('s', $id);
                        $stmt->execute();
                        $stmt->close();
       
                        $message = 'Data removed.';
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
        }


            
    }