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
                    <a class="navbar-brand" href="index.php">Projekt z Baz Danych</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="info_zawodnik_get.php">View player data</a></li>
                    <li class="active"><a href="info_turniej_get.php">View tournament data</a></li>
                    <li><a href="symulacja_get.php">Predict match result</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a>Jakub Dziura & Michał Orżanowski</a></li>
                </ul>
            </div>
        </nav>

        <?php include '../../sql_credentials/credentials.php';   

        $gender = 'M';
        if ($_GET["kategoria"] == 'Women tournament') {
            $gender = 'W';
        }

        $stmt_check_correct = oci_parse($conn,
        "SELECT COUNT(*) FROM jd439956.tournament WHERE TOURNAMENT = '".$_GET["miejsce"]."' AND YEAR = ".$_GET["rok"]." AND GENDER = '".$gender."'");
        oci_execute($stmt_check_correct, OCI_NO_AUTO_COMMIT);

        $row_check_correct = oci_fetch_array($stmt_check_correct, OCI_BOTH);

        if (!$row_check_correct || $row_check_correct[0] == 0) {
            echo '
                <div class="container container-content">
                    <div class="alert alert-danger" role="alert">
                        BŁĄD: Nie ma takiego turnieju!
                    </div>
                </div>
            ';

            return;
        }

        ?>

        <?php include 'data_load/tournament_info.php'; ?>

        <div class="container container-content">
            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-6">
                    Tournament: <br>
                    <font size="5"><b><?php echo $t_name." (".$t_year.")"; ?></b></font>
                </div>
                <div class="col-sm-6">
                    Category: <b><?php 
                        if ($gender == 'M')
                            echo "Men";
                        else 
                            echo "Women"; 
                    ?> </b><br>
                    Country: <b><?php echo $t_country; ?> </b><br>
                    Circuit: <b><?php echo $t_fed; ?> </b><br><br>                
                </div>
            </div>

            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-12">
                <center>
                    <br><font size="5">Winner:<br>
                    <b><?php echo "Jakub Dziura"; ?></b> & <b><?php echo "Michał Orżanowski"; ?></b></font>
                </center>
                <br>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                <center>
                    <br><font size="5">Best players:</font><br><br>
                </center>
                </div>
            </div>

            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-12">
                    <center>
                    <font size="4">
                    Most points scored: <b><?php echo $mvptotpoints; echo " (".$mvptotpoints_count.")"; ?></b><br>
                    Most effective player: <b><?php echo $mvppoints; echo " (".$mvppoints_count."%)"; ?></b><br>
                    Most aces: <b><?php echo $mvpace; echo " (".$mvpace_count.")";?></b><br>
                    </font>
                    </center>
                    <br>
                </div>    
            </div>

        </div>
    </body>
</html>