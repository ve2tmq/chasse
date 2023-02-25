<?php
include 'desktop.css';
include 'chasse.php';
?>
<html>
<body>
<div class="center">
<h1><a target="_blank" href="https://fr.wikipedia.org/wiki/Radiogoniom%C3%A9trie_sportive">Radiogoniom&eacute;trie sportive</a></h1>
<h1>Chasse &agrave; l'&eacute;metteur <?php echo strftime("%e %B %Y", chasse_debut);?></h1>
<div class="container"><ul>
<li>Les limites du territoire sont repr&eacute;sentes sur la carte (<a href="chasse.kmz">aussi disponible en format KML (Google Earth)</a>).</li>
<li>Les balises transmettent en alternance suivant la cadence de la chasse.</li>
<li>La cadence est 30 secondes de transmission suivi de 3 minutes de silence radio.</li>
<li>La fr&eacute;quence de chasse est 146.565 MHz et la modulation est en FM.</li>
<li>Les transmetteurs sont sur un terrain accessible &agrave; pied.</li>
<li>Les participants doivent prevoir qu'ils devront marcher dans un champ ou un bois&eacute;.</li>
<li>Les transmetteurs ne sont pas sur un terrain r&eacute;sidentiel, ni agricole ni un endroit interdit d'acc&egrave;s.</li>
<li>Les transmetteurs se mettront automatiquement en fonction &agrave; <?php echo date("H:i", chasse_debut); ?> et cesseront de transmettre &agrave; <?php echo date("H:i", chasse_fin); ?>.</li>
<li>Il n'y a pas d'ordre pour trouver les transmetteurs. L'important est de tous les trouver.</li>
<li>Il y a <?php echo nb_tx ?> transmetteur<?php if(nb_tx > 1) echo 's'?>.</li>
<li>Ne pas utiliser la frequence de chasse pour communiquer entre vous.</li>
<li>Lorsqu'un transmetteur est trouv&eacute;, scanner le code-QR pour valider le resultat. Ne quitter pas le site avant d'avoir valid&eacute; le r&eacute;sultat. Le site web de resultat utilise les COOKIES et la geolocalisation GPS pour fonctionner.</li>
<li>L'inscription doit se faire au point de d&eacute;part avant <?php echo date("H:i", chasse_debut); ?>.</li>
</ul>
<h1><center>Have fun!</center></h1>
<center><a href="https://www.ve2tmq.ca/~kea/chasse/inscription.php"><button type="Button">Inscription</button></a></center>
</div><div>
<br>
<center><a href="chasse.jpg"><img src="chasse.jpg" width="75%"></a></center><br>
</body>
</html>
