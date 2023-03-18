<?php
    require_once "path_definer.php";

    require "server_config.php";

  include_once "fetch_nona_query.php";
  include_once "fetch_rock_query.php";
  include_once "fetch_nona_plg_query.php";
  
  require "global_default.php";
  
  $cookies_n = "cookies.txt";
  $nona_save_n = "nona_alldata.csv";
  $rock_save_n = "rock_alldata.csv";
  
  $nona_slv_n = "nona_data_slv.csv";
  $nona_ttn_n = "nona_data_ttn.csv";
  $nona_plt_n = "nona_data_plt.csv";
  $nona_bsn_n = "nona_data_bsn.csv";
  $nona_ent_n = "nona_data_ent.csv";

  $nona_hc_n = "nona_data_hc.csv";
  $nona_g3p_n = "nona_data_g3p.csv";
  
  $vhead = "CONN_OK";
  
  
// <-- Login Credentials -->

  // data login nonatero
  $nona_user = "850052";
  $nona_pass = "Taurus555";
  
  // data login rock
  $rock_user = "623459";
  $rock_pass = "Merpati01";
  
// <-- Link -->

  $nona_llink = "http://nonatero.telkom.co.id/";
  $nona_flink = $nona_llink . "file_down_mart_nona_csv_new.php";
  
  $rock_llink = "http://rock.telkom.co.id/login.php";
  $rock_flink = "http://rock.telkom.co.id/downloadreport.php";
  
// <-- POST Query -->
  
  $nona_lpost = "entered_user=" . $nona_user . "&entered_password=" . $nona_pass;
  $nona_fpost = "vsql=" . $nona_fq . "&vhead=" . $vhead . "&vfile=" . $vhead;

  $nona_fslv = "vsql=" . $slv_fq . "&vhead=" . $vhead . "&vfile=" . $vhead;
  $nona_fttn = "vsql=" . $ttn_fq . "&vhead=" . $vhead . "&vfile=" . $vhead;
  $nona_fplt = "vsql=" . $plt_fq . "&vhead=" . $vhead . "&vfile=" . $vhead;
  $nona_fbsn = "vsql=" . $bsn_fq . "&vhead=" . $vhead . "&vfile=" . $vhead;
  $nona_fent = "vsql=" . $ent_fq . "&vhead=" . $vhead . "&vfile=" . $vhead;
  $nona_fhc = "vsql=" . $hc_fq . "&vhead=" . $vhead . "&vfile=" . $vhead;
  $nona_fg3p = "vsql=" . $g3p_fq . "&vhead=" . $vhead . "&vfile=" . $vhead;
  
  $rock_lpost = "usr=" . $rock_user . "&pwd=" . $rock_pass;
  $rock_fpost = "sql=" . $rock_fq;

// <-- Table List -->

  $t_nona = "nonatero";
  $t_nona_h = "nona_history";
  
  $t_nona_tc = "nona_plg_tc";
  $t_nona_hc = "nona_plg_hc";
  $t_nona_g3p = "nona_plg_g3p";

  $t_nona_cmdf = "cmdf_plg";
  $t_nona_sto = "cmdf_sto";

  $t_stat = "statistik";
  
  $t_nona_rhn = "nona_vip_rihana";
  $t_nona_pls = "nona_vip_plasa";
  $t_nona_odw = "nona_vip_dewa";
  
  $t_rock = "rock";
  $t_rock_h = "rock_history";

  $t_members = "members";

  $t_point = "point";
  $t_point_cfg = "point_config";
  
// <-- don't touch me! -->
  
  $p_cookies = $p_incl."function/".$cookies_n;
  $p_nonadata = $p_main."nonatero/".$nona_save_n;
  $p_rockdata = $p_main."rock/".$rock_save_n;
  
  $p_nonaslv = $p_main."nonatero/".$nona_slv_n;
  $p_nonattn = $p_main."nonatero/".$nona_ttn_n;
  $p_nonaplt = $p_main."nonatero/".$nona_plt_n;
  $p_nonabsn = $p_main."nonatero/".$nona_bsn_n;
  $p_nonaent = $p_main."nonatero/".$nona_ent_n;
  $p_nonahc = $p_main."nonatero/".$nona_hc_n;
  $p_nonag3p = $p_main."nonatero/".$nona_g3p_n;
  