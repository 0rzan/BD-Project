<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Projekt z Baz Danych</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">Projekt z Baz Danych</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="info_zawodnik_get.php">View player data</a></li>
                    <li><a href="info_turniej_get.php">View tournament data</a></li>
                    <li class="active"><a href="symulacja_get.php">Predict match result</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a>Jakub Dziura & Michał Orżanowski</a></li>
                </ul>
            </div>
        </nav>

        <?php include '../../sql_credentials/credentials.php';

        if ($_GET["imie1a"] == $_GET["imie1b"] ||
            $_GET["imie1a"] == $_GET["imie2a"] ||
            $_GET["imie1a"] == $_GET["imie2b"] ||
            $_GET["imie1b"] == $_GET["imie2a"] ||
            $_GET["imie1b"] == $_GET["imie2b"] ||
            $_GET["imie2a"] == $_GET["imie2b"])
        {
            echo '
                <div class="container container-content">
                    <div class="alert alert-danger" role="alert">
                        ERROR: Given one player in multiple places
                    </div>
                </div>
            ';

            return; 
        }

        $stmt_player_data_1a = oci_parse($conn,
        "SELECT * FROM jd439956.player WHERE NAME = '".$_GET["imie1a"]."'");
        $stmt_player_data_1b = oci_parse($conn,
        "SELECT * FROM jd439956.player WHERE NAME = '".$_GET["imie1b"]."'");
        $stmt_player_data_2a = oci_parse($conn,
        "SELECT * FROM jd439956.player WHERE NAME = '".$_GET["imie2a"]."'");
        $stmt_player_data_2b = oci_parse($conn,
        "SELECT * FROM jd439956.player WHERE NAME = '".$_GET["imie2b"]."'");

        oci_execute($stmt_player_data_1a, OCI_NO_AUTO_COMMIT);
        oci_execute($stmt_player_data_1b, OCI_NO_AUTO_COMMIT);
        oci_execute($stmt_player_data_2a, OCI_NO_AUTO_COMMIT);
        oci_execute($stmt_player_data_2b, OCI_NO_AUTO_COMMIT);

        $row_player_data_1a = oci_fetch_array($stmt_player_data_1a, OCI_BOTH);
        $row_player_data_1b = oci_fetch_array($stmt_player_data_1b, OCI_BOTH);
        $row_player_data_2a = oci_fetch_array($stmt_player_data_2a, OCI_BOTH);
        $row_player_data_2b = oci_fetch_array($stmt_player_data_2b, OCI_BOTH);

        if (!$row_player_data_1a || !$row_player_data_1b || !$row_player_data_2a || !$row_player_data_2b) {
            echo '
                <div class="container container-content">
                    <div class="alert alert-danger" role="alert">
                        ERROR: Incorrect player name!
                    </div>
                </div>
            ';

            return;
        }

        include 'data_load/symulacja.php';

        $tot_matches = $A1B1 + $A1B2 + $A2B1 + $A2B2 + $B1A1 + $B1A2 + $B2A1 + $B2A2;

        $w_bezposrednie = 1.0;
        $w_kills = 1;
        $w_winrate = 20;
        $scale = 0.05;

        $a_points = 0.0;
        $b_points = 0.0;

        if ($tot_matches != 0.0) {
            $a_points = $w_bezposrednie * floatval($A1B1 + $A1B2 + $A2B1 + $A2B2) / floatval($tot_matches);
            $b_points = $w_bezposrednie * floatval($B1A1 + $B1A2 + $B2A1 + $B2A2) / floatval($tot_matches);
        }

        $a_points += $w_kills * floatval($tot_kills_1a + $tot_kills_2a);
        $b_points += $w_kills * floatval($tot_kills_1b + $tot_kills_2b);

        $a_points += $w_winrate * floatval(($wins_1a / $tot_games_1a) + $wins_2a / $tot_games_2a);
        $b_points += $w_winrate * floatval(($wins_1b / $tot_games_1b) + $wins_2b / $tot_games_2b);

        // $a_points *= $scale;
        // $b_points *= $scale;

        $delta = $scale * ($a_points - $b_points);

        $prob = round(floatval(100.0 / floatval(1.0 + exp(-$delta))), 1);

        ?>

        <div class="container container-content">
            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-5">
                    <center>
                    <b><font size="5">Team A:</font><br><br>
                    <?php echo $_GET["imie1a"]; ?><br>
                    <?php echo $_GET["imie2a"]; ?><br><br></b>
                    </center>
                </div>
                <div class="col-sm-2">
                    <center>
                    <br>
                    <font size="5"><b>VS</b></font><br>
                    <br>
                    </center>
                </div>
                <div class="col-sm-5">
                    <center>
                    <b><font size="5">Team B:</font><br><br>
                    <?php echo $_GET["imie1b"]; ?><br>
                    <?php echo $_GET["imie2b"]; ?><br><br></b>
                    </center>
                </div>
            </div>

            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-12">
                    <center>
                    <br><font size="5"><b>Player individual statistics</b></font><br><br>
                    </center>
                </div>
            </div> 

            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-6">
                <center>
                    <br><b><?php echo $_GET["imie1a"]; ?>:</b></font><br>
                    Winrate: <?php echo round($wins_1a * 100.0 / $tot_games_1a, 1); ?>% in <?php echo $tot_games_1a; ?> games<br>
                    Average points from attack: <?php echo round($tot_kills_1a, 1); ?><br><br>
                    <b><?php echo $_GET["imie2a"]; ?></b>:</font><br>
                    Winrate: <?php echo round($wins_2a * 100.0 / $tot_games_2a, 1); ?>% in <?php echo $tot_games_2a; ?> games<br>
                    Average points from attack: <?php echo round($tot_kills_2a, 1); ?><br><br>
                </center>
                </div>
                <div class="col-sm-6">
                <center>
                    <br><b><?php echo $_GET["imie1b"]; ?>:</b></font><br>
                    Winrate: <?php echo round($wins_1b * 100.0 / $tot_games_1b, 1); ?>% in <?php echo $tot_games_1b; ?> games<br>
                    Average points from attack: <?php echo round($tot_kills_1b, 1); ?><br><br>
                    <b><?php echo $_GET["imie2b"]; ?></b>:</font><br>
                    Winrate: <?php echo round($wins_2b * 100.0 / $tot_games_2b, 1); ?>% in <?php echo $tot_games_2b; ?> games<br>
                    Average points from attack: <?php echo round($tot_kills_2b, 1); ?><br><br>
                </center>
                </div>
            </div>

            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-12">
                    <center>
                    <br><font size="5"><b>
                    Prediction: <br>
                    <?php 

                    if ($prob > 50.0) {
                        echo "Team A </b>wins with <b>".$prob."%</b> probability";
                    }
                    else {
                        $prob = round(100.0 - $prob, 1);
                        echo "Team B </b>wins with <b>".$prob."%</b> probability";
                    }

                    ?>

                    </b></font><br><br>
                    </center>
                </div>
            </div>

            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-12">
                    <br>
                    <b>Note:</b> Prediction is heuristically calculated based on players individual winrate and average scored points.
                    Team score is calculated considering past matches between players in different teams.<br><br>
                    Team A calculated score: <b><?php echo round($a_points, 1); ?></b><br>
                    Team B calculated score: <b><?php echo round($b_points, 1); ?></b>
                    <br><br>
                </div>
            </div>

        </div>
        
    </body>
</html>