<?php

include '../../sql_credentials/credentials.php';
                            
$stmt = oci_parse($conn, "SELECT DISTINCT TOURNAMENT FROM jd439956.tournament");
oci_execute($stmt, OCI_NO_AUTO_COMMIT);

while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
    echo "<option>".$row[0]."</option>";
}

?>