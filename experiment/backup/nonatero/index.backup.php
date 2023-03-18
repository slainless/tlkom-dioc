<?php
/**
 * Copyright (C) 2013 peredur.net
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

  require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
  require $p_svropt;
  require $p_cdash;
  require $p_cnona;
  
  require_once $p_inc . "database/fetch_setting.php";
  require_once $p_inc . "login/fungsi.php";

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>D-IOC | Statistik Pelanggan</title>
        <link rel="stylesheet" href="../styles/main.css" />
        <link rel="stylesheet" href="../../include/styles/reset.css" />
        <link rel="icon" type="image/png" href="../../favicon.ico" sizes="32x32" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h3 class="htext">DASHBOARD</h3>
            </div>
            <div id="main">
                <div id="sidebar">
                    <div class="sidebar">
                        <div class="info"><div class="abs">
                            <div class="status">
                                <div class="square">4
                                </div>
                                <div class="container">
                                    <h3>ADMIN</h3>
                                    <h3 class="bold">SERVER</h3>
                                </div>
                            </div></div>
                        </div>
                        <div class="main">
                            <ul class="list">
                                <li><a href="../">STATISTIK</a></li>
                                <li class="separator"></li>
                                <li><a href="../rock/">ROCK</a></li>
                                <li class="selected">NONATERO</li>
                                <li><a href="../point/">POINT</a></li>
                                <li class="separator"></li>
                                <li><a href="../admin/">SERVER</a></li>
                                <li><a href="$">KELUAR</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="content">
                    <div class="block header">
                        <div class="sub-block col left small">
                            <h3 class="htext con light title un">Database</h3>
                            <h1 class="htext title">Nonatero</h1>
                            <h3 class="htext con light title un">Telkom Makassar</h3>
                        </div>
                        <div class="sub-block right medium">
                            <!-- <a href="statistik/" class="btn medium">
                                <div>
                                    <h3 class="btn main">Statistik</h3>
                                    <h3 class="btn sub">Lengkap</h3>
                                </div>
                            </a> -->
                        </div>
                    </div>
                    <div class="block content">
                        <div class="sub-block stretch top main">
                            <a href="current.php" class="btn stretch main">
                                <div class="btn white large main left">
                                    <div class="sub-btn left">
                                        <div class="container">
                                            <h3 class="btn sub">TABLE</h3>
                                            <h1 class="btn main">CURRENT</h1>
                                        </div>
                                    </div>
                                    <div class="sub-btn right">
                                        <h3 class="btn sub">UPDATE TERAKHIR</h3>
                                        <h3 class="btn sub light">28 NOV 2016, 12:45</h3>
                                    </div>
                                </div>
                                <div class="btn small main right">
                                    <div class="container">
                                        <h2 class="btn sub white">JUMLAH GANGGUAN</h2>
                                        <h1 class="btn main white">336</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="sub-block stretch bottom sub">
                            <div class="sub-block large">
                                <a href="history.php" class="btn stretch main">
                                    <div class="btn white stretch main top">
                                        <h3 class="btn sub">TABLE</h3>
                                        <h1 class="btn main">HISTORY</h1>
                                    </div>
                                    <div class="btn small main bottom">
                                        <h3 class="btn sub">JUMLAH GANGGUAN</h3>
                                        <h3 class="btn sub light">1,289</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="sub-block small">
                                <a href="statistik/" class="btn medium main">
                                <div>
                                    <h3 class="btn main">Statistik</h3>
                                    <h3 class="btn sub">Lengkap</h3>
                                </div>
                                </a>
                                <a href="statistik/" class="btn medium main">
                                <div>
                                    <h3 class="btn main">Statistik</h3>
                                    <h3 class="btn sub">Lengkap</h3>
                                </div>
                                </a>
                                <a href="statistik/" class="btn medium main">
                                <div>
                                    <h3 class="btn main">Statistik</h3>
                                    <h3 class="btn sub">Lengkap</h3>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>
