<?php

    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;

    require_once $webframe."webf_function.php";

    if (isset($_POST['name'], $_POST['username'], $_POST['p'], $_POST['level'])) {
        // Sanitize and validate the data passed in
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        
        $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
        $level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_NUMBER_INT);

        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (strlen($password) != 128) {
            // The hashed pwd should be 128 characters long.
            // If it's not, something really odd has happened
            $message = 'Invalid password configuration.';
            $alert = 'danger';
        }
        if (empty($level)) {
            // The hashed pwd should be 128 characters long.
            // If it's not, something really odd has happened
            $message = 'Level must not be empty.';
            $alert = 'danger';
        }   

        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        if(empty($message)){
            if($mode == 0 && ($_SESSION["level"] == 1 || $_SESSION["level"] == 2)):
                $prep_stmt = "SELECT id FROM ".$t_members." WHERE username = ? LIMIT 1";
                $stmt = $query->prepare($prep_stmt);
                
                if ($stmt) {
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $stmt->store_result();
                    
                    if ($stmt->num_rows == 1) {
                        // A user with this email address already exists
                        $message = 'Username already exist.';
                        $alert = 'warning';
                    }
                } else {
                    $message = 'Database error.';
                    $alert = 'danger';
                }
            endif;
        }
            
            // TODO: 
            // We'll also have to account for the situation where the user doesn't have
            // rights to do registration, by checking what type of user is attempting to
            // perform the operation.
        if(empty($message)){
            if($mode == 0 && ($_SESSION["level"] == 1 || $_SESSION["level"] == 2)){
                if (empty($error_msg)) {
                    // Create a random salt
                    $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

                    if($_SESSION["level"] == 2 && $level == 1 && $id == $_SESSION["user_id"]){
                        $level = 2;
                    }
                    else if($_SESSION["level"] == 2 && ($level == 1 || $level == 2) && $id != $_SESSION["user_id"]){
                        $level = 3;
                    }

                    // Create salted password 
                    $password = hash('sha512', $password . $random_salt);

                    // Insert the new user into the database 
                    if ($insert_stmt = $query->prepare("INSERT INTO ".$t_members." (username, name, password, salt, level) VALUES (?, ?, ?, ?, ?)")) {
                        $insert_stmt->bind_param('ssssi', $username, $name, $password, $random_salt, $level);
                        // Execute the prepared query.
                        if (! $insert_stmt->execute()) {
                            $message = 'Insert Query failed.';
                            $alert = 'danger';
                        }
                    }
                    header("Location: ".$r_dash."userman/?msg=1");
                    exit();
                }
            }
            elseif(($mode == 2 && ($_SESSION["level"] == 1 || $_SESSION["level"] == 2)) || $mode == 1){
                if (empty($error_msg)) {
                    // Create a random salt
                    $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

                    if($mode == 1){
                        $level = $_SESSION["level"];
                        $id = $_SESSION["user_id"];
                    }
                    else if($_SESSION["level"] == 2 && $level == 1 && $id == $_SESSION["user_id"]){
                        $level = 2;
                    }
                    else if($_SESSION["level"] == 2 && ($level == 1 || $level == 2) && $id != $_SESSION["user_id"]){
                        $level = 3;
                    }

                    // Create salted password 
                    $password = hash('sha512', $password . $random_salt);

                    // Insert the new user into the database 
                    if ($insert_stmt = $query->prepare("UPDATE ".$t_members." SET username = ?, name = ?, password = ?, salt = ?, level = ? WHERE id = ?")) {
                        $insert_stmt->bind_param('ssssii', $username, $name, $password, $random_salt, $level, $id);
                        // Execute the prepared query.
                        if (! $insert_stmt->execute()) {
                            if($mode == 1){
                                $message = 'Update Query failed.';
                                $alert = 'danger';
                            }
                            else if($mode == 2){
                                $message = 'Update Query failed.';
                                $alert = 'danger';
                            }
                        }
                        else {
                            if($mode == 1){
                                header("Location: ".$r_dash."dashboard/?msg=1");
                                exit();
                            }
                            else if($mode == 2){
                                header("Location: ".$r_dash."userman/?msg=2");
                                exit();
                            }
                        }
                    }
                }
            }
        }
    }