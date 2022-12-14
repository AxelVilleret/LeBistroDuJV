<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

if (isset($_GET['reserv'])) {
  if (isset($_SESSION['panier1']) and $_SESSION['panier1'] != "") {
    $Connect = dbConnect();
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier1'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier1']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier1']));
    unset($_SESSION['panier1']);
    $_SESSION['reservations'] += 1;
  }
  if (isset($_SESSION['panier2']) and $_SESSION['panier2'] != "") {
    $Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier2'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier2']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier2']));
    unset($_SESSION['panier2']);
    $_SESSION['reservations'] += 1;
  }
  if (isset($_SESSION['panier3']) and $_SESSION['panier3'] != "") {
    $Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier3'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier3']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier3']));
    unset($_SESSION['panier3']);
    $_SESSION['reservations'] += 1;
  }
  unset($_SESSION['panier']);
  $_SESSION['nb_articles'] = 0;
  $_SESSION['panier'] = taille_panier($_SESSION['id']);
  init_panier($_SESSION['panier']);
  header("Location: accueil.php");
}

// pour chaque ??l??ment qui ??tait dans le panier, on cr???? une r??servation dans la table r??servations pour l'utilisateur connect??
// pour chaque jeu ainsi r??serv??, on d??cr??mente son stock dans la table jeux
// on r??initialise le panier en cons??quence comme si l'utlisateur venait de se connecter apr??s avoir d??truit les variables de session associ??es au panier
require('Autres/header.php');
?>

<body>
  <main>
    <br>
    <?php if (($_SESSION['nb_articles']) == 1) { ?>
      <font color="red">Confirmez-vous la r??servation de ce jeu ? (Cette action est irr??versible et entrainera l'ajout de ce jeu ?? vos trois r??servations mensuelles.)<br>En cliquant vous vous engagez ?? nous retourner ce jeu sous 30 jours ?? compter d'aujourd'hui !</font>
    <?php } else { ?>
      <font color="red">Confirmez-vous la r??servation de ces jeux ? (Cette action est irr??versible et entrainera l'ajout de ces jeux ?? vos trois r??servations mensuelles.)<br>En cliquant vous vous engagez ?? nous retourner ces jeux sous 30 jours ?? compter d'aujourd'hui !</font>
    <?php } ?>
    <br><br>
    <form method="GET" action="">
      <input class="submit font-effect-neon" type="submit" name="reserv" value="R??server" />
    </form>
  </main>
</body>

</html>