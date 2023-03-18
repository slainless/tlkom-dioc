<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/regional7/koneksi_db.php");
include_once 'opcurl_setting.php';

// ======================================================================
// general declaration
// ======================================================================

$cookie = "cookies.txt";
$saved_file_name = "update.csv"; // file name to store the fetched data

// ======================================================================
// login declaration
// ======================================================================

$nona_user = NONA_USER;
$nona_pass = NONA_PASS;

// unimportant decl
$redirect = "http://nonatero.telkom.co.id/ggn_open_gab_new21.php";
$login = "Login%20%BB";

// post data
$nona_login_post = "entered_user=$nona_user&entered_password=$nona_pass&redirect_to=$redirect&login=$login";

// ======================================================================
// fetch data declaration
// ======================================================================

//unimportant
$vfile = "Detil_ALL_GGN_Berlangsung_ALL_SEGMEN_TOTAL";
$vhead = "Detil ALL - GGN Berlangsung - ALL SEGMEN - TOTAL"; 
$tombolx = "25";
$tomboly = "15";

// ======================================================================
// mysql operation declaration
// ======================================================================

$nona_fetch_table = "nonatero";
$nona_history_table = "history";
$infile_location = "../../htdocs/regional7/dashboard/update.csv";

$vsql="SELECT ROW_NUMBER() OVER (ORDER BY TROUBLE_OPENTIME ASC) NO,
witel, KANDATEL_NEW3 kandatel, cmdf, rk,cprod,nd_telp,nd_int,paket_int,paket_iptv,GAUL_B0,GAUL_B1,GAUL_B2,GAUL30,GAUL30_BACK,LAPUL,trouble_no, trouble_opentime, headline, keluhan_desc, status, jam, hari,emosi_plg,decode(cprod,'1','TELEPON','11','INTERNET','8','IPTV') as PRODUK_GGN,TIPE_TIKET,SMS_OPEN,SMS_BACKEND,SMS_RESOLVED,EMAIL_OPEN,EMAIL_BACKEND,EMAIL_RESOLVED,TROUBLE_CLOSED_GROUP,
LOKER_DISPATCH,JML_LAPUL,CHANNEL
		 from (
select WITEL_NEW3 as WITEL,KANDATEL_NEW3,A.CMDF,A.RK,
 CASE WHEN cprod='1' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.TROUBLE_NUMBER
  WHEN cprod='1' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.ND_REFERENCE 
  WHEN cprod='11' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.ND_REFERENCE 
  WHEN cprod='11' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.TROUBLE_NUMBER
  WHEN cprod='8' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.ND_REFERENCE 
  WHEN cprod='8' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.TROUBLE_NUMBER
  ELSE A.TROUBLE_NUMBER END
   AS ND_TELP,
	CASE WHEN cprod='1' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.ND_REFERENCE
  WHEN cprod='1' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.TROUBLE_NUMBER 
  WHEN cprod='11' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.TROUBLE_NUMBER 
  WHEN cprod='11' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.ND_REFERENCE
  WHEN cprod='8' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.TROUBLE_NUMBER 
  WHEN cprod='8' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.ND_REFERENCE
  ELSE A.TROUBLE_NUMBER END
   AS ND_INT,CASE WHEN A.LART IS NULL THEN A.PAKET_SPEEDY ELSE A.LART END AS PAKET_INT,
   A.PAKET_IPTV,A.CPROD,
   A.TROUBLE_NO,TO_CHAR(A.TROUBLE_OPENTIME,'DD-MM-YYYY HH24:MI:SS') as TROUBLE_OPENTIME, A.TROUBLE_HEADLINE AS HEADLINE, A.KELUHAN_DESC,
        CASE 
        WHEN A.TROUBLE_STATUS_ID='1' THEN 'OPEN'
        WHEN A.TROUBLE_STATUS_ID='2' THEN 'PROSES'
        WHEN A.TROUBLE_STATUS_ID='4' THEN 'CUSTOMER_PENDING'
        WHEN A.TROUBLE_STATUS_ID='6' THEN 'TELKOM_PENDING'
        END AS STATUS,ROUND((CURRENT_DATE-A.TROUBLE_OPENTIME)*24) AS JAM ,TO_CHAR((CURRENT_DATE-A.TROUBLE_OPENTIME), '990D00')
        AS HARI,PIC AS LOKER_GROUP,NM_PIC AS NAMA,NMITRA AS NAMA_PT, CDMA_PIC,GSM_PIC,0 AS GAUL30,nvl(NUM_LAPUL,0) AS LAPUL,
		gaul_n as GAUL_B0,gaul_n_1 as GAUL_B1,gaul_n_2 as GAUL_B2,GAUL30_BACK,
		DECODE(MAX_VOKAL_ID,'1','Ramah','2','Nada tegas dan masih bisa diajak dialog','3','Marah besar','4','Mengancam memasukkan ke koran','-') as EMOSI_PLG,JENIS_GGN as TIPE_TIKET,'' as SMS_OPEN,'' as SMS_BACKEND,'' as SMS_RESOLVED,'' as EMAIL_OPEN,'' as EMAIL_BACKEND,'' as EMAIL_RESOLVED,CASE     
            WHEN substr(A.SEGMEN_PLG_REV,1,1)='S' AND UNIT in ('DCS','DTF') THEN 72
            WHEN substr(A.SEGMEN_PLG_REV,1,1) in ('T','G') AND UNIT in ('DCS','DTF') THEN 48
            WHEN substr(A.SEGMEN_PLG_REV,1,1)='P' AND UNIT in ('DCS','DTF') THEN 24
			WHEN UNIT='DBS' THEN 12
            WHEN UNIT in ('CIS','DES','DGS') THEN 6
        END AS SLG,'' as TROUBLE_CLOSED_GROUP_ID,'' as TROUBLE_CLOSED_GROUP,'' as TROUBLE_STATUS_DATE,'' as loker_dispatch,
		nvl(num_lapul,0) as jml_lapul,decode(upper(channel),'PHONE IN','147','WEB IN','MY TELKOM','WALK IN','PLASA','SOCIAL MEDIA','MEDIA SOSIAL','OTHERS') as channel
        FROM FACT_FAULT_OPEN_NT1 A
        WHERE a.DATE_CLOSE IS NULL
AND (a.WITEL_ID_NEW3 BETWEEN '01' AND '61')
and cprod in ('1','11','8')
and is_gamas='0'
AND unit in ('DCS','DTF','CIS','DES','DGS','DBS')  and REGIONAL_ID_NEW2='07' and WITEL_ID_NEW3='52'    AND UNIT is not null   
    
union all
select WITEL_NEW3 as WITEL,KANDATEL_NEW3,A.CMDF,A.RK,
 CASE WHEN cprod='1' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.TROUBLE_NUMBER
  WHEN cprod='1' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.ND_REFERENCE 
  WHEN cprod='11' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.ND_REFERENCE 
  WHEN cprod='11' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.TROUBLE_NUMBER
  WHEN cprod='8' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.ND_REFERENCE 
  WHEN cprod='8' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.TROUBLE_NUMBER
  ELSE A.TROUBLE_NUMBER END
   AS ND_TELP,
	CASE WHEN cprod='1' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.ND_REFERENCE
  WHEN cprod='1' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.TROUBLE_NUMBER 
  WHEN cprod='11' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.TROUBLE_NUMBER 
  WHEN cprod='11' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.ND_REFERENCE
  WHEN cprod='8' and substr(A.TROUBLE_NUMBER,1,1)='1' THEN A.TROUBLE_NUMBER 
  WHEN cprod='8' and substr(A.TROUBLE_NUMBER,1,1)='0' THEN A.ND_REFERENCE
  ELSE A.TROUBLE_NUMBER END
   AS ND_INT,CASE WHEN A.LART IS NULL THEN A.PAKET_SPEEDY ELSE A.LART END AS PAKET_INT,
   A.PAKET_IPTV,A.CPROD,
   A.TROUBLE_NO,TO_CHAR(A.TROUBLE_OPENTIME,'DD-MM-YYYY HH24:MI:SS') as TROUBLE_OPENTIME, A.TROUBLE_HEADLINE AS HEADLINE, A.KELUHAN_DESC,
        A.TROUBLE_STATUS_ID AS STATUS,
		ROUND((CURRENT_DATE-A.TROUBLE_OPENTIME)*24) AS JAM ,TO_CHAR((CURRENT_DATE-A.TROUBLE_OPENTIME), '990D00')
        AS HARI,PIC AS LOKER_GROUP,NM_PIC AS NAMA,NMITRA AS NAMA_PT, CDMA_PIC,GSM_PIC,0 AS GAUL30,NVL(NUM_LAPUL,0) AS LAPUL,
		gaul_n as GAUL_B0,gaul_n_1 as GAUL_B1,gaul_n_2 as GAUL_B2,GAUL30_BACK,
		NVL(MAX_VOKAL_ID,'-') as EMOSI_PLG,JENIS_GGN as TIPE_TIKET,to_char(SMS_OPEN,'DD-MM-YYYY HH24:MI:SS') as SMS_OPEN,
to_char(SMS_BACKEND,'DD-MM-YYYY HH24:MI:SS') as sms_backend,
to_char(sms_resolved,'DD-MM-YYYY HH24:MI:SS') as sms_resolved,
to_char(email_open,'DD-MM-YYYY HH24:MI:SS') as email_open,
to_char(email_backend,'DD-MM-YYYY HH24:MI:SS') as email_backend,
to_char(email_resolved,'DD-MM-YYYY HH24:MI:SS') as EMAIL_RESOLVED,
CASE     
            WHEN substr(A.SEGMEN_PLG_REV,1,1)='S' AND UNIT in ('DCS','DTF') THEN 72
            WHEN substr(A.SEGMEN_PLG_REV,1,1) in ('T','G') AND UNIT in ('DCS','DTF') THEN 48
            WHEN substr(A.SEGMEN_PLG_REV,1,1)='P' AND UNIT in ('DCS','DTF') THEN 24
			WHEN UNIT='DBS' THEN 12
            WHEN UNIT in ('CIS','DES','DGS') THEN 6
        END AS SLG,TROUBLE_CLOSED_GROUP_ID,substr(TROUBLE_CLOSED_GROUP,8,100) as trouble_closed_group,to_char(TROUBLE_STATUS_DATE,'DD-MM-YYYY HH24:MI:SS') as TROUBLE_STATUS_DATE,loker_dispatch_group
		as loker_dispatch,nvl(num_lapul,0) as jml_lapul,decode(channel,'1','MEDIA SOSIAL','2','147','3','MY TELKOM','4','PLASA','5','E-MAIL','6','MY INDIHOME','8','PROACTIVE WIFI','9','PROACTIVE IBOOSTER','10','C4 DES','11','TAM DBS','12','OCC DWS','14','MSOC DSS','15','PROACTIVE SMART SOLVER','16','MY SOLUTION CUSTOMER','17','AM TOOLS','18','IDEAS','19','MEDIA SOSIAL','OTHERS') as channel
        FROM FACT_FAULT_OPEN_CX_NT1 A
        WHERE a.trouble_status_id in ('QUEUED','BACKEND','NEW')
and cprod in ('1','11','8')  and is_gamas='0' 
and (WITEL_ID_NEW3 between '01' and '61')
AND unit in ('DCS','DTF','CIS','DES','DGS','DBS')  and REGIONAL_ID_NEW2='07' and WITEL_ID_NEW3='52'    AND UNIT is not null       
        ) data
		 where 1=1"; 

$nona_fetch_post = "vsql=$vsql&vfile=$vfile&vhead=$vhead&tombol.x=$tombolx&tombol.y=$tomboly";

$nona_login = curl_init(); 
curl_setopt ($nona_login, CURLOPT_URL, NONA_LOGIN_URL); 
curl_setopt ($nona_login, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt ($nona_login, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt ($nona_login, CURLOPT_TIMEOUT, 60); 
curl_setopt ($nona_login, CURLOPT_FOLLOWLOCATION, 0); 
curl_setopt ($nona_login, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($nona_login, CURLOPT_COOKIEJAR, $cookie);
curl_setopt ($nona_login, CURLOPT_COOKIEFILE, $cookie); 
curl_setopt ($nona_login, CURLOPT_REFERER, NONA_LOGIN_URL); 

curl_setopt ($nona_login, CURLOPT_POSTFIELDS, $nona_login_post); 
curl_setopt ($nona_login, CURLOPT_POST, 1); 
$nona_login_result = curl_exec ($nona_login);

curl_close($nona_login);

$nona_fetch = curl_init(); 
curl_setopt ($nona_fetch, CURLOPT_URL, NONA_FETCH_URL); 
curl_setopt ($nona_fetch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt ($nona_fetch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
curl_setopt ($nona_fetch, CURLOPT_TIMEOUT, 60); 
curl_setopt ($nona_fetch, CURLOPT_FOLLOWLOCATION, 0); 
curl_setopt ($nona_fetch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($nona_fetch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt ($nona_fetch, CURLOPT_COOKIEFILE, $cookie); 
curl_setopt ($nona_fetch, CURLOPT_REFERER, NONA_FETCH_URL); 

curl_setopt ($nona_fetch, CURLOPT_POSTFIELDS, $nona_fetch_post); 
curl_setopt ($nona_fetch, CURLOPT_POST, 1); 
$nona_fetch_result = curl_exec ($nona_fetch); 

file_put_contents($saved_file_name, $nona_fetch_result, LOCK_EX);

$replace_history_query = "REPLACE INTO " . $nona_history_table . " SELECT * FROM " . $nona_fetch_table . "";
mysqli_query($mysqli_history_nona,$replace_history_query);

$truncate_query = "TRUNCATE TABLE " . $nona_fetch_table . "";
mysqli_query($mysqli_history_nona,$truncate_query);

$load_query = "
LOAD DATA INFILE '" . $infile_location . "'
INTO TABLE " . $nona_fetch_table . "
 FIELDS TERMINATED BY ';' 
 OPTIONALLY ENCLOSED BY '\"'
 LINES TERMINATED BY '\n'
 IGNORE 2 LINES";
mysqli_query($mysqli_history_nona,$load_query);


echo "$infile_location<br>";
echo "$nona_fetch_table<br>";
echo "$nona_history_table<br>";
echo "$replace_history_query<br>";
echo "$load_query<br>";
echo "$truncate_query<br>";

mysqli_close($mysqli);
mysqli_close($mysqli_history_rock);
mysqli_close($mysqli_history_nona);
curl_close($nona_fetch);
?>