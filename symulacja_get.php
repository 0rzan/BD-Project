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

        <div class="container container-content">
            <div class="row">
                <div class="col-sm-6"><h2>Team A</h2></div>
                <div class="col-sm-6"><h2>Team B</h2></div>
            </div>
            <form action="symulacja.php" method="get">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="imie1a">Player 1 name:</label>
                            <input type="text" class="form-control" name="imie1a" id="imie1a" list="imie1a_sql">
                            <datalist id="imie1a_sql">
                            <?php include 'data_load/player_options.php' ?>
                            </datalist>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="imie1b">Player 1 name:</label>
                            <input type="text" class="form-control" name="imie1b" id="imie1b" list="imie1b_sql">
                            <datalist id="imie1b_sql">
                            <?php include 'data_load/player_options.php' ?>
                            </datalist>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="imie2a">Player 2 name:</label>
                            <input type="text" class="form-control" name="imie2a" id="imie2a" list="imie2a_sql">
                            <datalist id="imie2a_sql">
                            <?php include 'data_load/player_options.php' ?>
                            </datalist>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="imie2b">Player 2 name:</label>
                            <input type="text" class="form-control" name="imie2b" id="imie2b" list="imie2b_sql">
                            <datalist id="imie2b_sql">
                            <?php include 'data_load/player_options.php' ?>
                            </datalist>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>

  </body>
</html>