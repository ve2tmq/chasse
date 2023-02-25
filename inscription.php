<!DOCTYPE html>
<html>
<head>
<?php include 'desktop.css'; ?>
</head>
<body>

<?php
include 'chasse.php';

function ecrire_inscription($participant) {
    $f = fopen("tmp/participants.csv", "a");
    while (!flock($f, LOCK_EX))
        sleep(1);
    fwrite($f, $participant);
    fflush($f);
    fclose($f);
}

if(!empty($_POST)) {
  
  if(isset($_COOKIE['chasse'])) {
    ?> <h2>Deja inscrit a la chasse.</h2> <?php
    print($_COOKIE['chasse']);
  } else {

    $cookie_options = array (
      'expires' => chasse_fin,
      'secure' => false,
      'samesite' => 'Strict'
    );

    $gps = getGPS();
    $d = distance($gps[0], $gps[1], chasse_depart[0], chasse_depart[1]) * 1000;
    if(time() < chasse_debut && $d <= 250) {
      $participant = implode(',', $_POST);
      ecrire_inscription($participant . "\n");
      $cookie = setcookie("chasse", $participant, $cookie_options );
      if(isset($cookie))
        echo '<div class="center"><h2>Bienvenue &agrave; la chasse &agrave; l\'&eacute;metteur!</h2></div>';
    } else echo '<div class="center"><h2>L\'inscription doit se faire au point de d&eacute;part ('.chasse_depart[0].','.chasse_depart[1].') avant '. date("H:i",chasse_debut) .'</h2></div>';
  } 
} else { ?>
<h2>Inscription</h2>
<p>Un cookie sera cr&eacute;&eacute; et valide toute la chasse durant.  Le m&ecirc;me appareil est requis pour valider les transmetteurs trouv&eacute;s.</p>
</div>

<div class="container">
  <form method="post" action="inscription.php">
  <div class="row">
    <div class="col-25">
      <label for="name">Nom complet</label>
    </div>
    <div class="col-75">
      <input type="text" id="name" name="name" placeholder="Nom Complet" required>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="team">Indicatif d'appel ou nom d'&eacute;quipe</label>
    </div>
    <div class="col-75">
      <input type="text" id="callsign" name="callsign" placeholder="VE2..." required>
    </div>
  </div>
  <br>
  <div class="row">
    <input type="submit" value="Submit">
  </div>
  </form>
</div>
<?php } ?>
</body>
</html>

