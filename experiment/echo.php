    <?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";
 
    $path_type = 1;
    $path_level = 2;

    $page_title = "Point | Current";

    require_once $webf_starter;
    ?>

    <div class="form">
    	<span class="text3">HELLO3</span><br>
    	<span class="text1">HELLO1</span><br>
    	<span class="text2">HELLO2</span><br>
    	<div>
    		<div></div>
    		<div><button class="trigger">trigger</button><br></div>
    	</div>
    	<span class="text">Howdy</span><br><br>
    </div>
    <div>
    	<span class="text3">HELLO3</span><br>
    	<span class="text1">HELLO1</span><br>
    	<span class="text2">HELLO2</span><br>
    	<div>
    		<div></div>
    		<div><button class="trigger">trigger</button><br></div>
    	</div>
    	<input type="text" class="text" value="hi"></input><br><br>
    </div>
    <div>
    	<span id="result"></span>
    </div>

   <?php

   $var = "&lt;";

   if($var == "<"){
   	echo "yes";
   }
   else {
   	echo "no";
   }

   if(strpos("HEYYYAA", "HE")){
    echo "YES";
   }

   $file = "HELLO";

   header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="hello.csv"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize("ECHO"));
    echo $file;