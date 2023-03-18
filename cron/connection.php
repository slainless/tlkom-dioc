<?php
    require_once "path_definer.php";

    require "server_config.php";
    require "fetch_setting.php";

    require_once "global_define.php";

  $query = new mysqli($my_host, $my_user, $my_pass, $db_name);
  if ($query -> connect_error) {
    echo "DB CONNECTION ERROR";
    exit();
  }
