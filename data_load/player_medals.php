<?php

$stmt_first = oci_parse($conn, 
      "SELECT COUNT(*) AS GOLD
      FROM match
       WHERE (W_PLAYER1 = '".$p_name."' OR W_PLAYER2 = '".$p_name."')
         AND (BRACKET = 'Gold Medal' OR BRACKET = 'Finals')"
);
oci_execute($stmt_first, OCI_NO_AUTO_COMMIT);
$gold = oci_fetch_array($stmt_first, OCI_BOTH);
$num_golds = $gold['GOLD'];

$stmt_second = oci_parse($conn, 
      "SELECT COUNT(*) AS SILVER
      FROM match
       WHERE (L_PLAYER1 = '".$p_name."' OR L_PLAYER2 = '".$p_name."')
         AND (BRACKET = 'Gold Medal' OR BRACKET = 'Finals')"
);
oci_execute($stmt_second, OCI_NO_AUTO_COMMIT);
$silver = oci_fetch_array($stmt_second, OCI_BOTH);
$num_silvers = $silver['SILVER'];

$stmt_third = oci_parse($conn, 
      "SELECT COUNT(*) AS BRONZE
      FROM match
       WHERE (W_PLAYER1 = '".$p_name."' OR W_PLAYER2 = '".$p_name."')
         AND BRACKET = 'Bronze Medal'"
);
oci_execute($stmt_third, OCI_NO_AUTO_COMMIT);
$bronze = oci_fetch_array($stmt_third, OCI_BOTH);
$num_bronzes = $bronze['BRONZE'];

?>