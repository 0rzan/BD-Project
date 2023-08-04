<?php

$stmt_win = oci_parse($conn,  
            "SELECT WC,
            COUNT(WC)                                     AS GAMES,
            TRUNC(AVG(WA), 2)                             AS ATTACKS,
            TRUNC(AVG(WK), 2)                             AS KILLS,
            TRUNC(AVG(WE), 2)                             AS ERRORS,
            TRUNC((SUM(WK) - SUM(WE)) / SUM(WA) * 100, 2) AS POINTS,
            TRUNC(AVG(WACE), 2)                           AS ACES,
            TRUNC(AVG(WB), 2)                             AS BLOCKS,
            TRUNC(AVG(WD), 2)                             AS DIGS
     FROM (SELECT W_PLAYER2        AS WC,
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
     GROUP BY WC");


oci_execute($stmt_win, OCI_NO_AUTO_COMMIT);
$win_stats = oci_fetch_array($stmt_win, OCI_BOTH);
     
$win_games = intval($win_stats['GAMES']);
$win_attacks = floatval($win_stats['ATTACKS']);
$win_kills = floatval($win_stats['KILLS']);
$win_errors = floatval($win_stats['ERRORS']);
$win_points = floatval($win_stats['POINTS']);
$win_aces = floatval($win_stats['ACES']);
$win_blocks = floatval($win_stats['BLOCKS']);
$win_digs = floatval($win_stats['DIGS']);    

?>