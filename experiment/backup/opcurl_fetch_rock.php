<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/regional7/koneksi_db.php");
include_once 'opcurl_setting.php';

// ======================================================================
// general declaration
// ======================================================================

$cookie = "cookies.txt";
$saved_file_name = "update_rock.csv"; // file name to store the fetched data

// ======================================================================
// login declaration
// ======================================================================

$rock_user = ROCK_USER;
$rock_pass = ROCK_PASS;

// post data
$rock_login_post = "usr=$rock_user&pwd=$rock_pass&b_submit=";

// ======================================================================
// fetch data declaration
// ======================================================================

//unimportant
$nama_file="report_nonatero_";
$tombolx="141";
$tomboly="19";

// ======================================================================
// mysql operation declaration
// ======================================================================

$rock_fetch_table = "rock";
$rock_history_table = "history";
$infile_location = "../../htdocs/database/dashboard/update_rock.csv";

$sql="SELECT * from nonatero_view WHERE CLOSE=0 and TYPE_CUST not in ('CORPORATE', 'BUSINESS')  and regional='07'  and witel='MAKASAR'  ORDER BY JAM DESC";

$rock_fetch_post = "sql=$sql&nama_file=$nama_file&tombol.x=$tombolx&tombol.y=$tomboly";

$rock_login = curl_init(); 
curl_setopt ($rock_login, CURLOPT_URL, ROCK_LOGIN_URL); 
curl_setopt ($rock_login, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt ($rock_login, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt ($rock_login, CURLOPT_TIMEOUT, 60); 
curl_setopt ($rock_login, CURLOPT_FOLLOWLOCATION, 0); 
curl_setopt ($rock_login, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($rock_login, CURLOPT_COOKIEJAR, $cookie);
curl_setopt ($rock_login, CURLOPT_COOKIEFILE, $cookie); 
curl_setopt ($rock_login, CURLOPT_REFERER, ROCK_LOGIN_URL); 

curl_setopt ($rock_login, CURLOPT_POSTFIELDS, $rock_login_post); 
curl_setopt ($rock_login, CURLOPT_POST, 1); 
$rock_login_result = curl_exec ($rock_login);

curl_close($rock_login);
sleep(2);

$rock_fetch = curl_init(); 
curl_setopt ($rock_fetch, CURLOPT_URL, ROCK_FETCH_URL); 
curl_setopt ($rock_fetch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt ($rock_fetch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt ($rock_fetch, CURLOPT_TIMEOUT, 60); 
curl_setopt ($rock_fetch, CURLOPT_FOLLOWLOCATION, 0); 
curl_setopt ($rock_fetch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($rock_fetch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt ($rock_fetch, CURLOPT_COOKIEFILE, $cookie); 
curl_setopt ($rock_fetch, CURLOPT_REFERER, ROCK_FETCH_URL); 

curl_setopt ($rock_fetch, CURLOPT_POSTFIELDS, $rock_fetch_post); 
curl_setopt ($rock_fetch, CURLOPT_POST, 1); 
$rock_fetch_result = curl_exec ($rock_fetch); 

file_put_contents($saved_file_name, $rock_fetch_result, LOCK_EX);

$replace_history_query = "REPLACE INTO " . $rock_history_table . " SELECT * FROM " . $rock_fetch_table . "";
mysqli_query($mysqli_history_rock,$replace_history_query);

sleep(5);

$truncate_query = "TRUNCATE TABLE " . $rock_fetch_table . "";
mysqli_query($mysqli_history_rock,$truncate_query);

sleep(2);

$load_query = "
LOAD DATA INFILE '" . $infile_location . "'
INTO TABLE " . $rock_fetch_table . "
 FIELDS TERMINATED BY '	' 
 OPTIONALLY ENCLOSED BY '\"'
 LINES TERMINATED BY '\n'
 IGNORE 2 LINES";
mysqli_query($mysqli_history_rock,$load_query);


echo "$infile_location\n";
echo "$rock_fetch_table\n";
echo "$rock_history_table\n";
echo "$load_query\n";
echo "$truncate_query\n";

mysqli_close($mysqli_ggn);
mysqli_close($mysqli_history_rock);
mysqli_close($mysqli_history_nona);
curl_close($rock_fetch);
?>