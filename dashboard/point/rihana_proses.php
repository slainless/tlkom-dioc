<?php

    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;

    require_once $webframe."webf_function.php";

    $itiket = $ind = $inama = $iperihal = $imedia = $ikomplain = $icp = $istatus = $iketerangan = $itanggal = $iflag = '';

    if (isset($_POST['tiket'], $_POST['nd'], $_POST['nama'], $_POST['cp'], $_POST['perihal'], $_POST['media'], $_POST['status'], $_POST['komplain'], $_POST['keterangan'], $_POST['tanggal'], $_POST['mode'])):
        // Sanitize and validate the data passed in
        $x = 0;
        $tiket = filter_input(INPUT_POST, 'tiket', FILTER_SANITIZE_STRING);
        $nd = filter_input(INPUT_POST, 'nd', FILTER_SANITIZE_NUMBER_INT);
        
        $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
        $cp = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_NUMBER_INT);

        $perihal = filter_input(INPUT_POST, 'perihal', FILTER_SANITIZE_SPECIAL_CHARS);
        $media = filter_input(INPUT_POST, 'media', FILTER_SANITIZE_NUMBER_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $komplain = filter_input(INPUT_POST, 'komplain', FILTER_SANITIZE_SPECIAL_CHARS);
        $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_SPECIAL_CHARS);
        $tanggal = $_POST["tanggal"];
        $flag = filter_input(INPUT_POST, 'flag', FILTER_SANITIZE_EMAIL);

        $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_NUMBER_INT);

        if(empty($status)){
            $message = "Status is empty";
            $alert = "warning";
            $x++;
        }

        if(!empty($tanggal)){
            $tanggal = explode("/", $tanggal);
            $tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
        }

        if(empty($media)){
            $message = "Media is empty";
            $alert = "warning";
            $x++;
        }

        if(strpos($flag, "rgb") !== false){
            $flag = '';
        }

        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        // 
        if(empty($message)):

            switch($status){

                case 1:
                    $status = 'In Progress';
                    break;
                case 2:
                    $status = 'Not Handled';
                    break;

            }

            switch($media){

                case 1:
                    $media = 'Email';
                    break;
                case 2:
                    $media = 'Twitter';
                    break;
                case 3:
                    $media = 'Facebook';
                    break;

            }

            if($mode == 0 && $_SESSION["level"] < 3):

                $prep_stmt = "SELECT * FROM ".$t_nona_rhn." WHERE TROUBLE_NO = ? LIMIT 1";
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
                    $prep_stmt = "INSERT INTO ".$t_nona_rhn." VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('sssssssssss', $tiket, $nd, $nama, $perihal, $media, $komplain, $cp, $status, $keterangan, $tanggal, $flag);
                        $stmt->execute();
                        $stmt->close();

                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                        $x++;
                    }
                endif;

                if(empty($message)):
                    $prep_stmt = "UPDATE ".$t_nona." SET RHN_F = 1 WHERE TROUBLE_NO = ?";
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
                    $prep_stmt = "UPDATE ".$t_point." SET RHN_F = 1 WHERE TROUBLE_NO = ?";
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
                    $prep_stmt = "UPDATE ".$t_nona_rhn." SET ND = ?, NAMA = ?, PERIHAL = ?, MEDIA = ?, KOMPLAIN = ?, CP_PENGIRIM = ?, STATUS = ?, KETERANGAN = ?, TANGGAL = ?, FLAG_COLOR = ? WHERE TROUBLE_NO = ?";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        $stmt->bind_param('sssssssssss', $nd, $nama, $perihal, $media, $komplain, $cp, $status, $keterangan, $tanggal, $flag, $tiket);
                        $stmt->execute();
                        
                        $message = 'Data updated.';
                        $alert = 'success';
                        $mode = 0;
                        $itiket = $ind = $inama = $iperihal = $imedia = $ikomplain = $icp = $istatus = $iketerangan = $itanggal = $iflag = '';
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