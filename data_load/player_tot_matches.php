<?php

$stmt_tot = oci_parse($conn, 
            "SELECT WC,
            COUNT(WC)                                     AS GAMES,
            TRUNC(AVG(WA), 2)                             AS ATTACKS,
            TRUNC(AVG(WK), 2)                             AS KILLS,
            TRUNC(AVG(WE), 2)                             AS ERRORS,
            TRUNC((SUM(WK) - SUM(WE)) / SUM(WA) * 100, 2) AS POINTS,
            TRUNC(AVG(WACE), 2)                           AS ACES,
            TRUNC(AVG(WB), 2)                             AS BLOCKS,
            TRUNC(AVG(WD), 2)                             AS DIGS
        FROM ((SELECT W_PLAYER2        AS WC,
                    W_P2_TOT_ATTACKS AS WA,
                    W_P2_TOT_KILLS   AS WK,
                    W_P2_TOT_ERRORS  AS WE,
                    W_P2_TOT_ACES    AS WACE,
                    W_P2_TOT_BLOCKS  AS WB,
                    W_P2_TOT_DIGS    AS WD
            FROM match
            WHERE W_PLAYER2 = '".$p_name."'
            UNION ALL
            SELECT W_PLAYER1,
                    W_P1_TOT_ATTACKS,
                    W_P1_TOT_KILLS,
                    W_P1_TOT_ERRORS,
                    W_P1_TOT_ACES,
                    W_P1_TOT_BLOCKS,
                    W_P1_TOT_DIGS
            FROM match
            WHERE W_PLAYER1 = '".$p_name."')
            UNION ALL
            (SELECT L_PLAYER2,
                    L_P2_TOT_ATTACKS,
                    L_P2_TOT_KILLS,
                    L_P2_TOT_ERRORS,
                    L_P2_TOT_ACES,
                    L_P2_TOT_BLOCKS,
                    L_P2_TOT_DIGS
            FROM match
            WHERE L_PLAYER2 = '".$p_name."'
            UNION ALL
            SELECT L_PLAYER1,
                    L_P1_TOT_ATTACKS,
                    L_P1_TOT_KILLS,
                    L_P1_TOT_ERRORS,
                    L_P1_TOT_ACES,
                    L_P1_TOT_BLOCKS,
                    L_P1_TOT_DIGS
            FROM match
            WHERE L_PLAYER1 = '".$p_name."'))
        GROUP BY WC");

oci_execute($stmt_tot, OCI_NO_AUTO_COMMIT);
$all_stats = oci_fetch_array($stmt_tot, OCI_BOTH);

$tot_games = intval($all_stats['GAMES']);
$tot_attacks = floatval($all_stats['ATTACKS']);
$tot_kills = floatval($all_stats['KILLS']);
$tot_errors = floatval($all_stats['ERRORS']);
$tot_points = floatval($all_stats['POINTS']);
$tot_aces = floatval($all_stats['ACES']);
$tot_blocks = floatval($all_stats['BLOCKS']);
$tot_digs = floatval($all_stats['DIGS']);        

?>