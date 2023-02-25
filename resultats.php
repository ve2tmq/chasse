<?php
include 'desktop.css';
include 'chasse.php';

class participant {
  public $name;
  public $callsign;
  private $result;

  function __construct($line) {
    $this->name = $line[0];
    $this->callsign = $line[1];
    $this->result = new \Ds\Vector();
  }

  function add_result($map) {
    $this->result->push($map);
  }

  function time_chasse() {
    $last_time = $this->result->last()->values()[0];
    $DT = new DateTime();
    $DT->setTimestamp(chasse_debut);
    return $DT->diff($last_time)->format("%h:%i:%s");
  }

  function nb_tx() {
    return count($this->result);
  }

  function print() {
    return $this->name . ' ' . $this->callsign . ' ' . $this->nb_tx() . '/' . nb_tx . ' ' . $this->time_chasse();
  }

}

function readCSV($filename) {
  $setP = new \Ds\Set();
  if(!file_exists($filename))
    return $setP;

  $myCSV = fopen($filename, 'r');
  while(!feof($myCSV) ) {
    $lines[] = fgetcsv($myCSV, 100, ',');
  }
  fclose($myCSV);

  $set = new \Ds\Set();
  foreach($lines as $line) {
    if(!empty($line)) {
      $p = [$line[0], $line[1]];
      $set->add($p);
    }
  }

  foreach($set as $s) {
    $p = new participant($s);
    foreach($lines as $l) {
      if(!empty($l)) {
	if($l[0] == $s[0] && $l[1] == $s[1]) {
	  $date = new DateTime($l[3], new DateTimeZone('America/Toronto'));
	  $map = new \Ds\Map([$l[2] => $date]);
	  $p->add_result($map);
	}
      }
    }
    $setP->add($p);
  }

  return $setP;
}

$setP = readCSV('tmp/resultats.csv');
$setP->sort(function($self, $other) {
    if($self->nb_tx() > $other->nb_tx())
      return 1;
    elseif($self->nb_tx() < $other->nb_tx())
      return -1;
    elseif($self->time_chasse() < $other->time_chasse())
      return 1;
    elseif($self->time_chasse() > $other->time_chasse())
      return -1;
    else
      return 0;
  });
$setP->reverse();

?>
<html>
<body>
<div class="center">
<h1><a target="_blank" href="https://fr.wikipedia.org/wiki/Radiogoniom%C3%A9trie_sportive">Radiogoniom&eacute;trie sportive</a></h1>
<h1>Chasse &agrave; l'&eacute;metteur <?php echo strftime("%e %B %Y", chasse_debut);?></h1>
<div class="container"><ul>
<?php
foreach($setP as $p)
  echo '<li>' . $p->print() . '</li>';
?>
</ul>
</div></div>
</body>
</html>
