
<script>
function getLocation() {
  if(navigator.geolocation) {
    navigator.geolocation.watchPosition(showPosition);
  }
}

function showPosition(position) {
  document.cookie = "gps=" + position.coords.latitude + "," + position.coords.longitude + "; SameSite=strict";
}

getLocation();
</script> 

<?php
date_default_timezone_set('America/Toronto');
setlocale(LC_TIME, "fr_CA.UTF-8");
define("chasse", parse_ini_file("../../chasse.cfg", true));
define("chasse_debut", strtotime(chasse['chasse']['debut']));
define("chasse_fin", strtotime(chasse['chasse']['fin']));
define("chasse_depart", explode(',', chasse['chasse']['depart']));
define("nb_tx", count(chasse)-1);

function getGPS() {
    sleep(5); //demande 5 secondes pour obtenir la bonne position GPS.
    return explode(',', $_COOKIE['gps']);
}

/*---------------------------------------------------------------*/
/*
    Titre : Calcul la distance entre 2 points en km

    URL   : https://phpsources.net/code_s.php?id=1091
    Auteur           : sheppy1
    Website auteur   : https://lejournalabrasif.fr/qwanturank-concours-seo-qwant/
    Date édition     : 05 Aout 2019
    Date mise a jour : 16 Avril 2022
    Rapport de la maj:
    - fonctionnement du code vérifié
*/
/*---------------------------------------------------------------*/

function distance($lat1, $lng1, $lat2, $lng2) {
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;

    $r = 6372.797; // rayon moyen de la Terre en km
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;

    return $km;
}
?>
