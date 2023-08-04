<?php

$stmt_lost = oci_parse($conn,
    "SELECT WC,
    COUNT(WC)                                     AS GAMES,
    TRUNC(AVG(WA), 2)                             AS ATTACKS,
    TRUNC(AVG(WK), 2)                             AS KILLS,
    TRUNC(AVG(WE), 2)                             AS ERRORS,
    TRUNC((SUM(WK) - SUM(WE)) / SUM(WA) * 100, 2) AS POINTS,
    TRUNC(AVG(WACE), 2)                           AS ACES,
    TRUNC(AVG(WB), 2)                             AS BLOCKS,
    TRUNC(AVG(WD), 2)                             AS DIGS
    FROM (SELECT L_PLAYER2        AS WC,
        L_P2_TOT_ATTACKS AS WA,
        L_P2_TOT_KILLS   AS WK,
        L_P2_TOT_ERRORS  AS WE,
        L_P2_TOT_ACES    AS WACE,
        L_P2_TOT_BLOCKS  AS WB,
        L_P2_TOT_DIGS    AS WD
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
    WHERE L_PLAYER1 = '".$p_name."')
    GROUP BY WC");

oci_execute($stmt_lost, OCI_NO_AUTO_COMMIT);
$los_stats = oci_fetch_array($stmt_lost, OCI_BOTH);

$los_games = intval($los_stats['GAMES']);
$los_attacks = floatval($los_stats['ATTACKS']);
$los_kills = floatval($los_stats['KILLS']);
$los_errors = floatval($los_stats['ERRORS']);
$los_points = floatval($los_stats['POINTS']);
$los_aces = floatval($los_stats['ACES']);
$los_blocks = floatval($los_stats['BLOCKS']);
$los_digs = floatval($los_stats['DIGS']);

?>