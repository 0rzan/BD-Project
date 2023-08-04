<?php

$A1vsB1 = oci_parse($conn,
      "SELECT COUNT(*) AS G
       FROM MATCH M
               JOIN TOURNAMENT T
                    ON M.TOURNAMENT = T.TOURNAMENT_ID AND (M.W_PLAYER1 = '".$imie1a."' OR M.W_PLAYER2 = '".$imie1a."') AND
                       (M.L_PLAYER1 = '".$imie1b."' OR M.L_PLAYER2 = '".$imie1b."')"
);
oci_execute($A1vsB1, OCI_NO_AUTO_COMMIT);
$winsA1B1 = oci_fetch_array($A1vsB1, OCI_BOTH);
$A1B1 = floatval($winsA1B1['G']);
$B1vsA1 = oci_parse($conn,
      "SELECT COUNT(*) AS G
       FROM MATCH M
               JOIN TOURNAMENT T
                    ON M.TOURNAMENT = T.TOURNAMENT_ID AND (M.W_PLAYER1 = '".$imie1b."' OR M.W_PLAYER2 = '".$imie1b."') AND
                       (M.L_PLAYER1 = '".$imie1a."' OR M.L_PLAYER2 = '".$imie1a."')"
);
oci_execute($B1vsA1, OCI_NO_AUTO_COMMIT);
$winsB1A1 = oci_fetch_array($B1vsA1, OCI_BOTH);
$B1A1 = floatval($winsA1B1['G']);
$A1vsB2 = oci_parse($conn,
      "SELECT COUNT(*) AS G
       FROM MATCH M
               JOIN TOURNAMENT T
                    ON M.TOURNAMENT = T.TOURNAMENT_ID AND (M.W_PLAYER1 = '".$imie1a."' OR M.W_PLAYER2 = '".$imie1a."') AND
                       (M.L_PLAYER1 = '".$imie2b."' OR M.L_PLAYER2 = '".$imie2b."')"
);
oci_execute($A1vsB2, OCI_NO_AUTO_COMMIT);
$winsA1B2 = oci_fetch_array($A1vsB2, OCI_BOTH);
$A1B2 = floatval($winsA1B1['G']);
$B2vsA1 = oci_parse($conn,
      "SELECT COUNT(*) AS G
       FROM MATCH M
               JOIN TOURNAMENT T
                    ON M.TOURNAMENT = T.TOURNAMENT_ID AND (M.W_PLAYER1 = '".$imie2b."' OR M.W_PLAYER2 = '".$imie2b."') AND
                       (M.L_PLAYER1 = '".$imie1a."' OR M.L_PLAYER2 = '".$imie1a."')"
);
oci_execute($B2vsA1, OCI_NO_AUTO_COMMIT);
$winsB2A1 = oci_fetch_array($B2vsA1, OCI_BOTH);
$B2A1 = floatval($winsA1B1['G']);
$A2vsB1 = oci_parse($conn,
      "SELECT COUNT(*) AS G
       FROM MATCH M
               JOIN TOURNAMENT T
                    ON M.TOURNAMENT = T.TOURNAMENT_ID AND (M.W_PLAYER1 = '".$imie2a."' OR M.W_PLAYER2 = '".$imie2a."') AND
                       (M.L_PLAYER1 = '".$imie1b."' OR M.L_PLAYER2 = '".$imie1b."')"
);
oci_execute($A2vsB1, OCI_NO_AUTO_COMMIT);
$winsA2B1 = oci_fetch_array($A2vsB1, OCI_BOTH);
$A2B1 = floatval($winsA1B1['G']);
$B1vsA2 = oci_parse($conn,
      "SELECT COUNT(*) AS G
       FROM MATCH M
               JOIN TOURNAMENT T
                    ON M.TOURNAMENT = T.TOURNAMENT_ID AND (M.W_PLAYER1 = '".$imie1b."' OR M.W_PLAYER2 = '".$imie1b."') AND
                       (M.L_PLAYER1 = '".$imie2a."' OR M.L_PLAYER2 = '".$imie2a."')"
);
oci_execute($B1vsA2, OCI_NO_AUTO_COMMIT);
$winsB1A2 = oci_fetch_array($B1vsA2, OCI_BOTH);
$B1A2 = floatval($winsA1B1['G']);
$A2vsB2 = oci_parse($conn,
      "SELECT COUNT(*) AS G
       FROM MATCH M
               JOIN TOURNAMENT T
                    ON M.TOURNAMENT = T.TOURNAMENT_ID AND (M.W_PLAYER1 = '".$imie2a."' OR M.W_PLAYER2 = '".$imie2a."') AND
                       (M.L_PLAYER1 = '".$imie2b."' OR M.L_PLAYER2 = '".$imie2b."')"
);
oci_execute($A2vsB2, OCI_NO_AUTO_COMMIT);
$winsA2B2 = oci_fetch_array($A2vsB2, OCI_BOTH);
$A2B2 = floatval($winsA1B1['G']);
$B2vsA2 = oci_parse($conn,
      "SELECT COUNT(*) AS G
       FROM MATCH M
               JOIN TOURNAMENT T
                    ON M.TOURNAMENT = T.TOURNAMENT_ID AND (M.W_PLAYER1 = '".$imie2b."' OR M.W_PLAYER2 = '".$imie2b."') AND
                       (M.L_PLAYER1 = '".$imie2a."' OR M.L_PLAYER2 = '".$imie2a."')"
);
oci_execute($B2vsA2, OCI_NO_AUTO_COMMIT);
$winsB2A2 = oci_fetch_array($B2vsA2, OCI_BOTH);
$B2A2 = floatval($winsA1B1['G']);

// =======================
$stmt_tot = oci_parse($conn, 
        "SELECT WC,
        COUNT(WC)                                     AS GAMES,
        TRUNC(AVG(WK), 2)                             AS KILLS
        FROM ((SELECT W_PLAYER2        AS WC,
                W_P2_TOT_KILLS   AS WK
        FROM match
        WHERE W_PLAYER2 = '".$_GET["imie1a"]."'
        UNION ALL
        SELECT W_PLAYER1,
                W_P1_TOT_KILLS
        FROM match
        WHERE W_PLAYER1 = '".$_GET["imie1a"]."')
        UNION ALL
        (SELECT L_PLAYER2,
                L_P2_TOT_KILLS
        FROM match
        WHERE L_PLAYER2 = '".$_GET["imie1a"]."'
        UNION ALL
        SELECT L_PLAYER1,
                L_P1_TOT_KILLS
        FROM match
        WHERE L_PLAYER1 = '".$_GET["imie1a"]."'))
        GROUP BY WC");

oci_execute($stmt_tot, OCI_NO_AUTO_COMMIT);
$all_stats = oci_fetch_array($stmt_tot, OCI_BOTH);

$tot_games_1a = floatval($all_stats['GAMES']);
$tot_kills_1a = floatval($all_stats['KILLS']);

$stmt_tot = oci_parse($conn, 
            "SELECT WC,
            COUNT(WC)                                     AS GAMES,
            TRUNC(AVG(WK), 2)                             AS KILLS
        FROM ((SELECT W_PLAYER2        AS WC,
                    W_P2_TOT_KILLS   AS WK
            FROM match
            WHERE W_PLAYER2 = '".$_GET["imie1b"]."'
            UNION ALL
            SELECT W_PLAYER1,
                    W_P1_TOT_KILLS
            FROM match
            WHERE W_PLAYER1 = '".$_GET["imie1b"]."')
            UNION ALL
            (SELECT L_PLAYER2,
                    L_P2_TOT_KILLS
            FROM match
            WHERE L_PLAYER2 = '".$_GET["imie1b"]."'
            UNION ALL
            SELECT L_PLAYER1,
                    L_P1_TOT_KILLS
            FROM match
            WHERE L_PLAYER1 = '".$_GET["imie1b"]."'))
        GROUP BY WC");

oci_execute($stmt_tot, OCI_NO_AUTO_COMMIT);
$all_stats = oci_fetch_array($stmt_tot, OCI_BOTH);

$tot_games_1b = floatval($all_stats['GAMES']);
$tot_kills_1b = floatval($all_stats['KILLS']);

$stmt_tot = oci_parse($conn, 
            "SELECT WC,
            COUNT(WC)                                     AS GAMES,
            TRUNC(AVG(WK), 2)                             AS KILLS
        FROM ((SELECT W_PLAYER2        AS WC,
                    W_P2_TOT_KILLS   AS WK
            FROM match
            WHERE W_PLAYER2 = '".$_GET["imie2a"]."'
            UNION ALL
            SELECT W_PLAYER1,
                    W_P1_TOT_KILLS
            FROM match
            WHERE W_PLAYER1 = '".$_GET["imie2a"]."')
            UNION ALL
            (SELECT L_PLAYER2,
                    L_P2_TOT_KILLS
            FROM match
            WHERE L_PLAYER2 = '".$_GET["imie2a"]."'
            UNION ALL
            SELECT L_PLAYER1,
                    L_P1_TOT_KILLS
            FROM match
            WHERE L_PLAYER1 = '".$_GET["imie2a"]."'))
        GROUP BY WC");

oci_execute($stmt_tot, OCI_NO_AUTO_COMMIT);
$all_stats = oci_fetch_array($stmt_tot, OCI_BOTH);

$tot_games_2a = floatval($all_stats['GAMES']);
$tot_kills_2a = floatval($all_stats['KILLS']);

$stmt_tot = oci_parse($conn, 
            "SELECT WC,
            COUNT(WC)                                     AS GAMES,
            TRUNC(AVG(WK), 2)                             AS KILLS
        FROM ((SELECT W_PLAYER2        AS WC,
                    W_P2_TOT_KILLS   AS WK
            FROM match
            WHERE W_PLAYER2 = '".$_GET["imie2b"]."'
            UNION ALL
            SELECT W_PLAYER1,
                    W_P1_TOT_KILLS
            FROM match
            WHERE W_PLAYER1 = '".$_GET["imie2b"]."')
            UNION ALL
            (SELECT L_PLAYER2,
                    L_P2_TOT_KILLS
            FROM match
            WHERE L_PLAYER2 = '".$_GET["imie2b"]."'
            UNION ALL
            SELECT L_PLAYER1,
                    L_P1_TOT_KILLS
            FROM match
            WHERE L_PLAYER1 = '".$_GET["imie2b"]."'))
        GROUP BY WC");

oci_execute($stmt_tot, OCI_NO_AUTO_COMMIT);
$all_stats = oci_fetch_array($stmt_tot, OCI_BOTH);

$tot_games_2b = floatval($all_stats['GAMES']);
$tot_kills_2b = floatval($all_stats['KILLS']);

$stmt_win = oci_parse($conn, "SELECT COUNT(*) AS WINS FROM match WHERE W_PLAYER1 = '".$_GET["imie1a"]."' OR W_PLAYER2 = '".$_GET["imie1a"]."' ");
oci_execute($stmt_win, OCI_NO_AUTO_COMMIT);
$win_stats = oci_fetch_array($stmt_win, OCI_BOTH);
$wins_1a = floatval($win_stats['WINS']);

$stmt_win = oci_parse($conn, "SELECT COUNT(*) AS WINS FROM match WHERE W_PLAYER1 = '".$_GET["imie1b"]."' OR W_PLAYER2 = '".$_GET["imie1b"]."' ");
oci_execute($stmt_win, OCI_NO_AUTO_COMMIT);
$win_stats = oci_fetch_array($stmt_win, OCI_BOTH);
$wins_1b = floatval($win_stats['WINS']);

$stmt_win = oci_parse($conn, "SELECT COUNT(*) AS WINS FROM match WHERE W_PLAYER1 = '".$_GET["imie2a"]."' OR W_PLAYER2 = '".$_GET["imie2a"]."' ");
oci_execute($stmt_win, OCI_NO_AUTO_COMMIT);
$win_stats = oci_fetch_array($stmt_win, OCI_BOTH);
$wins_2a = floatval($win_stats['WINS']);

$stmt_win = oci_parse($conn, "SELECT COUNT(*) AS WINS FROM match WHERE W_PLAYER1 = '".$_GET["imie2b"]."' OR W_PLAYER2 = '".$_GET["imie2b"]."' ");
oci_execute($stmt_win, OCI_NO_AUTO_COMMIT);
$win_stats = oci_fetch_array($stmt_win, OCI_BOTH);
$wins_2b = floatval($win_stats['WINS']);

?>