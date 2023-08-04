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

        <div class="container container-content">
            <form action="info_zawodnik.php" method="get">
                <div class="form-group">
                    <label for="imie">Player name:</label>
                    <input type="text" class="form-control" name="imie" id="imie" list="imie_sql">
                    <datalist id="imie_sql">
                        <?php include 'data_load/player_options.php'; ?>
                    </datalist>
                </div>
                
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
  </body>
</html>