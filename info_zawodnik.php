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
                    <li class="active"><a href="info_zawodnik_get.php">View player data</a></li>
                    <li><a href="info_turniej_get.php">View tournament data</a></li>
                    <li><a href="symulacja_get.php">Predict match result</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a>Jakub Dziura & Michał Orżanowski</a></li>
                </ul>
            </div>
        </nav>

        <?php include '../../sql_credentials/credentials.php';

        $stmt_player_data = oci_parse($conn,
        "SELECT * FROM jd439956.player WHERE NAME = '".$_GET["imie"]."'");
        oci_execute($stmt_player_data, OCI_NO_AUTO_COMMIT);

        $row_player_data = oci_fetch_array($stmt_player_data, OCI_BOTH);

        if (!$row_player_data) {
            echo '
                <div class="container container-content">
                    <div class="alert alert-danger" role="alert">
                        BŁĄD: Nie ma takiego zawodnika!
                    </div>
                </div>
            ';

            return;
        }

        $p_name = $_GET['imie'];
        $p_brithdate = $row_player_data['BIRTHDATE'];

        $p_gender = 'Male';
        if ($row_player_data['GENDER'] == 'W')
            $p_gender = 'Female';

        $p_country = $row_player_data['COUNTRY'];
        $p_height = round(intval($row_player_data['HEIGHT']) * 2.54);

        include 'data_load/player_tot_matches.php';
        include 'data_load/player_los_matches.php';
        include 'data_load/player_win_matches.php';
        include 'data_load/player_medals.php';

        ?>

        <script>
            function change_display() {
                let val = document.getElementById('select-matches').value;

                let dtot = document.getElementById('tot');
                let dlos = document.getElementById('los');
                let dwin = document.getElementById('win');

                dtot.style.display = 'none';
                dlos.style.display = 'none';
                dwin.style.display = 'none';

                if (val == 'tot')
                    dtot.style.display = 'block';
                else if (val == 'los')
                    dlos.style.display = 'block';
                else
                    dwin.style.display = 'block';
            }
        </script>

        <div class="container container-content">
            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-6">
                    Player: <br>
                    <font size="5"><b><?php echo $p_name; ?></b></font>
                </div>
                <div class="col-sm-6">
                    Birthdate: <b><?php echo $p_brithdate; ?> </b><br>
                    Country: <b><?php echo $p_country; ?> </b><br>
                    Gender: <b><?php echo $p_gender; ?> </b><br>
                    Height: <b>
                        <?php
                            if ($p_height == 0)
                                echo "N/A";
                            else
                                echo $p_height." cm";
                        ?>
                        </b><br><br>
                </div>
            </div>
            <div class="row" style="border-bottom:solid;">
                <div class="col-sm-12">
                <center>
                    <br><font size="5">Player statistics</font><br><br>
                    Choose statistics: 
                    <select id="select-matches" onchange="change_display()">
                        <option value="tot">All matches</option>
                        <option value="los">Only lost matches</option>
                        <option value="win">Only won matches</select>
                    </select>
                </center>
                <br>
                </div>
            </div>

            <div class="row" id="tot" style="display:block;border-bottom:solid;">
                <div class="col-sm-8">
                    <br>
                    Total games: <b><?php echo $tot_games; ?></b><br>
                    Average attacks: <b><?php echo $tot_attacks; ?></b><br>
                    Average successful attacks: <b><?php echo $tot_kills; ?></b><br>
                    Average attacks errors: <b><?php echo $tot_errors; ?></b><br>
                    Average attack effectiveness: <b><?php echo $tot_points."%"; ?></b><br>
                    Average aces: <b><?php echo $tot_aces; ?></b><br>
                    Average successful blocks: <b><?php echo $tot_blocks; ?></b><br>
                    Average successful digs: <b><?php echo $tot_digs; ?></b><br><br>
                </div>
                <div class="col-sm4">
                    <br>
                    Gold medals: <b><?php echo $num_golds; ?></b><br>
                    Silver medals: <b><?php echo $num_silvers; ?></b><br>
                    Bronze medals: <b><?php echo $num_bronzes; ?></b><br><br>
                </div>
            </div>

            <div class="row" id="los" style="display:none;border-bottom:solid;">
                <div class="col-sm-8">
                    <br>
                    Lost games: <b><?php echo $los_games; ?></b><br>
                    Average attacks: <b><?php echo $los_attacks; ?></b><br>
                    Average successful attacks: <b><?php echo $los_kills; ?></b><br>
                    Average attacks errors: <b><?php echo $los_errors; ?></b><br>
                    Average attack effectiveness: <b><?php echo $los_points."%"; ?></b><br>
                    Average aces: <b><?php echo $los_aces; ?></b><br>
                    Average successful blocks: <b><?php echo $los_blocks; ?></b><br>
                    Average successful digs: <b><?php echo $los_digs; ?></b><br><br>
                </div>
                <div class="col-sm4">
                    <br>
                    Gold medals: <b><?php echo $num_golds; ?></b><br>
                    Silver medals: <b><?php echo $num_silvers; ?></b><br>
                    Bronze medals: <b><?php echo $num_bronzes; ?></b><br><br>
                </div>
            </div>

            <div class="row" id="win" style="display:none;border-bottom:solid;">
                <div class="col-sm-8">
                    <br>
                    Won games: <b><?php echo $win_games; ?></b><br>
                    Average attacks: <b><?php echo $win_attacks; ?></b><br>
                    Average successful attacks: <b><?php echo $win_kills; ?></b><br>
                    Average attacks errors: <b><?php echo $win_errors; ?></b><br>
                    Average attack effectiveness: <b><?php echo $win_points."%"; ?></b><br>
                    Average aces: <b><?php echo $win_aces; ?></b><br>
                    Average successful blocks: <b><?php echo $win_blocks; ?></b><br>
                    Average successful digs: <b><?php echo $win_digs; ?></b><br><br>
                </div>
                <div class="col-sm4">
                    <br>
                    Gold medals: <b><?php echo $num_golds; ?></b><br>
                    Silver medals: <b><?php echo $num_silvers; ?></b><br>
                    Bronze medals: <b><?php echo $num_bronzes; ?></b><br><br>
                </div>
            </div>

        </div>

    </body>
</html>