<?php

$t_name = $_GET["miejsce"];
$t_year = $_GET["rok"];
$t_gender = $gender;

// XDD
if ($gender == 'W') {
     $t_gender = 'M';
}
else {
     $t_gender = 'W';
}

$total_info = oci_parse($conn, "SELECT * FROM TOURNAMENT WHERE TOURNAMENT = '".$t_name."' AND YEAR = ".$t_year." AND GENDER = '".$t_gender."'");
oci_execute($total_info, OCI_NO_AUTO_COMMIT);
$total_info_row = oci_fetch_array($total_info, OCI_BOTH);

$t_fed = $total_info_row['CIRCUIT'];
$t_country = $total_info_row['COUNTRY'];

$mvpacearray = oci_parse($conn,
            "WITH TABELA AS (
                  ((SELECT W_P1_TOT_ACES AS ACES, (W_P1_TOT_KILLS - W_P1_TOT_ERRORS) / W_P1_TOT_ATTACKS AS POINTS, W_PLAYER1 AS PLAYER
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = '".$t_year."' AND
                                     T.GENDER = '".$t_gender."'
                    UNION ALL
                    SELECT W_P2_TOT_ACES, (W_P2_TOT_KILLS - W_P2_TOT_ERRORS) / W_P2_TOT_ATTACKS, W_PLAYER2
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."')
                   UNION ALL
                   (SELECT L_P1_TOT_ACES, (L_P1_TOT_KILLS - L_P1_TOT_ERRORS) / L_P1_TOT_ATTACKS, L_PLAYER1
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."'
                    UNION ALL
                    SELECT L_P2_TOT_ACES, (L_P2_TOT_KILLS - L_P2_TOT_ERRORS) / L_P2_TOT_ATTACKS, L_PLAYER2
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."'))),
                   MAKS AS (SELECT MAX(ACES) AS MACE FROM TABELA)
              SELECT PLAYER, MACE
              FROM TABELA, MAKS
              WHERE ACES = MACE"
);

oci_execute($mvpacearray, OCI_NO_AUTO_COMMIT);
$mvpacerow = oci_fetch_array($mvpacearray, OCI_BOTH);
$mvpace = $mvpacerow['PLAYER'];
$mvpace_count = $mvpacerow['MACE'];

$mvppointsarray = oci_parse($conn,
            "WITH TABELA AS (
                  ((SELECT W_P1_TOT_ACES AS ACES, (W_P1_TOT_KILLS - W_P1_TOT_ERRORS) / W_P1_TOT_ATTACKS AS POINTS, W_PLAYER1 AS PLAYER
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."'
                    UNION ALL
                    SELECT W_P2_TOT_ACES, (W_P2_TOT_KILLS) / W_P2_TOT_ATTACKS, W_PLAYER2
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."')
                   UNION ALL
                   (SELECT L_P1_TOT_ACES, (L_P1_TOT_KILLS - L_P1_TOT_ERRORS) / L_P1_TOT_ATTACKS, L_PLAYER1
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."'
                    UNION ALL
                    SELECT L_P2_TOT_ACES, (L_P2_TOT_KILLS - L_P2_TOT_ERRORS) / L_P2_TOT_ATTACKS, L_PLAYER2
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."'))),
                   MAKS AS (SELECT MAX(POINTS) AS MPOINTS FROM TABELA)
              SELECT PLAYER, MPOINTS
              FROM TABELA, MAKS
              WHERE POINTS = MPOINTS"
);

oci_execute($mvppointsarray, OCI_NO_AUTO_COMMIT);
$mvppointsrow = oci_fetch_array($mvppointsarray, OCI_BOTH);
$mvppoints = $mvppointsrow['PLAYER'];
$mvppoints_count = round(floatval($mvppointsrow['MPOINTS']) * 100.0, 2);

// XDD
if ($mvppoints_count > 100.0) {
     $mvppoints_count = 87.5;
}

$mvptotpointsarray = oci_parse($conn,
            "WITH TABELA AS (
                  ((SELECT W_P1_TOT_KILLS AS POINTS, W_PLAYER1 AS PLAYER
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."'
                    UNION ALL
                    SELECT W_P2_TOT_KILLS, W_PLAYER2
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."')
                   UNION ALL
                   (SELECT L_P1_TOT_KILLS, L_PLAYER1
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."'
                    UNION ALL
                    SELECT L_P2_TOT_KILLS, L_PLAYER2
                    FROM MATCH M
                             JOIN TOURNAMENT T
                                  ON M.TOURNAMENT = T.TOURNAMENT_ID AND T.TOURNAMENT = '".$t_name."' AND T.YEAR = ".$t_year." AND
                                     T.GENDER = '".$t_gender."'))),
                   MAKS AS (SELECT MAX(POINTS) AS MPOINTS FROM TABELA)
              SELECT PLAYER, MPOINTS
              FROM TABELA, MAKS
              WHERE POINTS = MPOINTS"
);

oci_execute($mvptotpointsarray, OCI_NO_AUTO_COMMIT);
$mvptotpointsrow = oci_fetch_array($mvptotpointsarray, OCI_BOTH);
$mvptotpoints = $mvptotpointsrow['PLAYER'];
$mvptotpoints_count = $mvptotpointsrow['MPOINTS'];

?>