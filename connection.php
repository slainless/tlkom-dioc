<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_incl."function/fetch_setting.php";

    require_once $p_defn;

  $query = new mysqli($my_host, $my_user, $my_pass, $db_name);
  if ($query -> connect_error) {
    echo "DB CONNECTION ERROR";
    exit();
  }
