<?php

    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;

    require_once $webframe."webf_function.php";

    if (isset($_POST['id'])) {
        // Sanitize and validate the data passed in
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        if (empty($id)) {
            // The hashed pwd should be 128 characters long.
            // If it's not, something really odd has happened
            $message = 'ID is empty.';
            $alert = 'warning';
        }

        $prep_stmt = "SELECT level FROM ".$t_members." WHERE id = ? LIMIT 1";
        $stmt = $query->prepare($prep_stmt);
        
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($level);
            $stmt->fetch();

            $stmt->close();

        }
        else {
            $message = 'Query Select failed.';
            $alert = 'danger';
        }

        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        if(empty($message)){

            if($_SESSION["level"] == 1 || ($_SESSION["level"] == 2 && $level > 2)):
                $prep_stmt = "DELETE FROM ".$t_members." WHERE id = ?";
                $stmt = $query->prepare($prep_stmt);
                
                if ($stmt) {
                    $stmt->bind_param('i', $id);
                    $stmt->execute();

                    $stmt->close();
                    $message = 'User removed.';
                    $alert = 'success';
                }
                else {
                    $message = 'Query Remove failed.';
                    $alert = 'danger';
                    echo $prep_stmt;
                    echo $level;
                    echo $id;
                }

            else:
                $message = "Don't try to hack!";
                $alert = 'danger';
            endif;
        }
            
    }