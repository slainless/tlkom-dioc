<?php
  global $rock_fq;
  
  $rock_fq = "SELECT * from nonatero_view WHERE CLOSE=0 and TYPE_CUST not in ('CORPORATE', 'BUSINESS')  and regional='07'  and witel='MAKASAR'  ORDER BY JAM DESC";
  