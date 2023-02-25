<?php
include 'desktop.css';
include 'chasse.php';

function readCSV($filename) {
  if(!file_exists($filename))
    return;

  $myCSV = fopen($filename, 'r');
  while(!feof($myCSV) ) {
    $lines[] = fgetcsv($myCSV, 100, ',');
  }
  fclose($myCSV);

  return $lines;
}

$participants = readCSV('tmp/participants.csv');

?>
<html>
<body>
<div class="center">
<h1><a target="_blank" href="https://fr.wikipedia.org/wiki/Radiogoniom%C3%A9trie_sportive">Radiogoniom&eacute;trie sportive</a></h1>
<h1>Chasse &agrave; l'&eacute;metteur <?php echo strftime("%e %B %Y", chasse_debut);?></h1>
<div class="container"><ul>
<?php
if(!empty($participants))
  foreach($participants as $p)
    if($p)
      echo '<li>' . implode(',', $p) . '</li>';
?>
</ul>
</div></div>
</body>
</html>
