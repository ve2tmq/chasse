<html>
<body>
<?php
include "chasse.php";
include 'desktop.css';
?>

<?php
function ecrire_resultat($resultat) {
    $f = fopen("tmp/resultats.csv", "a");
    while (!flock($f, LOCK_EX))
	sleep(1);
    fwrite($f, $resultat);
    fflush($f);
    fclose($f);
}

    $cookie_options = array (
      'expires' => chasse_fin,
      'secure' => false,
      'samesite' => 'Strict'
    );

if(isset($_GET['tx'])) {
  $tx = $_GET['tx'];
  if(isset(chasse[$tx]) && time() >= chasse_debut && time() <= chasse_fin) {
    $tx_id = chasse[$tx]['id'];
    if(!isset($_COOKIE[$tx_id])) {
      if(isset($_COOKIE['chasse'])) {
        $gps = getGPS();
        if (isset(chasse[$tx])) {
            $tx_gps = explode(',', chasse[$tx]['gps']);
            $d = distance($gps[0], $gps[1], $tx_gps[0], $tx_gps[1]) * 1000;
            if($d <= 25) {
                $current_time = date("Y-m-d H:i:s");
                ecrire_resultat($_COOKIE['chasse'] . ',' . $tx_id . ',' . $current_time . ',' . $gps[0] . ',' . $gps[1] . "\n");
                setcookie($tx_id, $current_time, $cookie_options);
                echo '<div class="center"><h2>'.$tx_id.' Trouve! '.$d.'</h2></div>';
            } else {
              echo '<div class="center"><h2>Trop loin du transmetteur!</h2></div>';
            }
        }
      } else echo '<div class="center"><h2>Transmetteur '.$tx_id.' trouv&eacute;, mais le navigateur utilis&eacute; n\'a pas le cookie de la chasse. L\'inscription devait se faire au point de d&eacute;part ('.chasse_depart[0].','.chasse_depart[1].') avant '. date("H:i", chasse_debut) .'</h2></div>';
    } else echo '<div class="center"><h2>Resultat d&eacute;j&agrave; valid&eacute;.</h2></div>';
  } else echo '<div class="center"><h2>Le transmetteur ne peut &ecirc;tre trouv&eacute; qu\'entre '. date("H:i", chasse_debut) .' et '. date("H:i", chasse_fin) .'.</h2></div>';
}
?>
</body>
</html>
