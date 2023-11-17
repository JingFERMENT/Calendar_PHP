<?php
$weekdaysNames = ['L', 'M', 'M', 'J', 'V', 'S', 'D'];
$monthNames = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

// definir la fin de l'année
$startYear = 2010;
$endYear = date('Y', strtotime(' + 8 years'));

//déclaration des variables (année, mois, jour actuel)
$currentDay = date('d');
$currentMonth = date('m');
$currentYear = date('Y');


// récupération des données en GET 
if (!empty($_GET['month'])) {
    $month = $_GET['month'];
} else {
    $month = date('m');
}

if (!empty($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = date('Y');
}

// déclaraiton des variables (année + mois précédent)
$chosenPreviousMonth = new DateTime("$year-$month");
$chosenPreviousMonth->sub(new DateInterval('P1M'));
$lastMonth = $chosenPreviousMonth->format('m');
$lastYear = $chosenPreviousMonth->format('Y');

// déclaraiton des variables (année + mois prochain)
$chosenNextMonth = new DateTime("$year-$month");
$chosenNextMonth->add(new DateInterval('P1M'));
$nextMonth = $chosenNextMonth->format('m');
$nextYear = $chosenNextMonth->format('Y');

//convertir en français le mois
$chosenMonth = new DateTime("$year-$month");
$formatter = new IntlDateFormatter('fr_FR');
$formatter->setPattern('MMMM');
$frenchDate =  $formatter->format($chosenMonth);

// trouver le jour de la semaine pour le 1er du mois
$firstDayOftheMonth = date('N', strtotime("$year-$month-01"));

//calculer le nombre de jours dans un mois
$numOfDaysInAMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier mensuel</title>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="./public/assets/framework/bootstrap.min.css" />
    <!-- mon fichier css : toujours plus bas -->
    <link rel="stylesheet" href="./public/assets/css/style.css">

</head>

<body>
    <header class="container mt-3">
        <h1 class="text-center text-white">Calendrier mensuel</h1>
    </header>

    <main>
        <!-- formulaire  -->
        <form class="container my-3" method="GET">
            <div class="row d-flex justify-content-center">
                <div class="col-6 col-lg-3">
                    <!-- choisir les années  -->
                    <label for="year">Année</label>
                    <select class="form-select mb-2" name="year" id="month">
                        <?php
                        for ($yearName = $startYear; $yearName < $endYear; $yearName++) {
                            $aChosenYear = ($year && $year == $yearName) ? 'selected' : '';
                            echo "<option value=\"$yearName\"$aChosenYear>$yearName</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-6 col-lg-3">
                    <!-- choisir les mois  -->
                    <label for="month">Mois</label>
                    <select class="form-select mb-2" name="month" id="month">
                        <?php
                        foreach ($monthNames as $key => $monthName) {
                            $correctIndex = $key + 1;
                            $aChosenMonth = ($month && $month == $correctIndex) ? 'selected' : '';
                            echo "<option value=\"$correctIndex\" $aChosenMonth>$monthName</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- bouton valider -->
                <div class="my-2 m-auto text-center">
                    <button class="btn btn-secondary">Valider</button>
                </div>
            </div>
        </form>


        <section class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6 m-auto">
                    <!-- affichage des mois / année -->
                    <div class="month p-3 d-flex justify-content-between align-items-center">
                        <a href="http://calendar.localhost/?month=<?= $lastMonth ?>&year=<?= $lastYear ?>" class="previous-btn text-white">&#10094</a>
                        <div class="display-date text-white text-center"><?= $frenchDate . ' ' . $year ?></div>
                        <a href="http://calendar.localhost/?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="next-btn text-white">&#10095</a>
                    </div>
                    <!-- affichage de la semaine -->
                    <ul class="weekdays">
                        <?php
                        foreach ($weekdaysNames as $weekdayName) {
                            echo "<li>$weekdayName</li>";
                        }
                        ?>
                    </ul>

                    <!-- affichage des jours -->
                    <ul class="days">
                        <?php
                        for ($emptyDay = 1; $emptyDay < $firstDayOftheMonth; $emptyDay++) {
                            echo "<li></li>";
                        }
                        ?>
                        <?php
                        for ($day = 1; $day <= $numOfDaysInAMonth; $day++) {
                            if (($day == $currentDay) && ($year == $currentYear) && ($month == $currentMonth)) {
                                echo "<li id=\"active\">$day</li>";
                            } else {
                                echo "<li>$day</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>

</html>