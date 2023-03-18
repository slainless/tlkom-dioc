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
        <link rel="stylesheet" href="styles/main.css" />
        <link rel="stylesheet" href="../include/styles/reset.css" />

        <link rel="stylesheet" href="statistik/chartist.css">
        <link rel="stylesheet" href="statistik/chartist-plugin-tooltip.css">

        <script src="statistik/chartist.js"></script>
        <script src="statistik/chartist-plugin-tooltip.js"></script>
        <link rel="icon" type="image/png" href="../favicon.ico" sizes="32x32" />
        <style>
            .ct-grid {
                stroke-dasharray: 2px;
            }
            .ct-chart {
                background-color: white;
                font-stretch: condensed;
                border-radius: 15px;
            }
            .ct-series-a .ct-line {
                stroke: #EA495F;
            }
            .ct-series-a .ct-point {
                stroke: #EA495F;
            }
            .ct-label {
                fill: rgba(0, 0, 0, 0.4);
                color: rgba(234, 73, 95, 1);
                font-size: 0.85rem;
                letter-spacing: 0.5px;
                line-height: 1;
                text-transform: uppercase;
            }
        </style>
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
                                <li class="selected">STATISTIK</li>
                                <li class="separator"></li>
                                <li><a href="rock/">ROCK</a></li>
                                <li><a href="nonatero/">NONATERO</a></li>
                                <li><a href="point/">POINT</a></li>
                                <li class="separator"></li>
                                <li><a href="admin/">SERVER</a></li>
                                <li><a href="#">KELUAR</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="content">
                    <div class="block header">
                        <div class="sub-block col left small">
                            <h3 class="htext light title un">Statistik Gangguan</h3>
                            <h1 class="htext title">Nonatero</h1>
                            <h3 class="htext light title un">Telkom Makassar</h3>
                        </div>
                        <div class="sub-block right medium">
                            <a href="statistik/" class="btn medium">
                                <div>
                                    <h3 class="btn main">Statistik</h3>
                                    <h3 class="btn sub">Lengkap</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="block content">
                        <div class="ct-chart ct-major-eleventh"></div>
                        <script>
                            var data = {
                            labels: ['02 Nov','03 Nov','04 Nov','05 Nov','06 Nov'], series: [[124,329,402,123,200]]};
var option = { 
    plugins: [ Chartist.plugins.tooltip() ],
    lineSmooth: false,
    fullWidth: true,
    chartPadding: {
    top: 30,
    right: 25,
    bottom: 5,
    left: 10
  },
};
new Chartist.Line('.ct-chart', data, option);
</script>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>
