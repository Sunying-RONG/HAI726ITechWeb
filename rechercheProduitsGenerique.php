<?php session_start();?> 
<!-- crée session ou réutilisation si existe -->
<html>
  <head>
    <title>Liste des produits par catégorie et marque</title>

    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="scriptRecherche.js"></script>

  </head>

  <body>
    <?php
      // $WHERE = "";
      // $INFOS = "";
      // foreach ($_GET as $nom => $valeur) {
      //   if ($valeur != "") {
      //     if ($WHERE == "") $WHERE .= "WHERE ";
      //     else              $WHERE .= " AND ";
      //     $WHERE .= "$nom='$valeur'";
      //     $INFOS .= "$nom='$valeur' ";
      //   }
      // }
      // echo "<h3> Liste des produits : $INFOS </h3>";    
      $sql = "SELECT * FROM produits;"; 
      // echo $sql; /* Pour le déboguage */
      
      $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
      $username = 'e20210011437';
      $password = 'sunying';
      $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");

      $sth = $dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll();

      // echo "<ul>";
      // foreach ($result as $enr) {
      //   echo "<li>".$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</li>";
      //   if (!$_SESSION['selection'][$enr['numProduit']]) {
      //     $_SESSION['selection'][$enr['numProduit']] = 0;
      //   }
      // }
      // echo "</ul>";
    ?>
    <!--    CADRE CONNEXION      -->
    <?php 
        if(isset($_SESSION['email'])){
          echo "Bonjour, ";
          print_r($_SESSION['email']);
          echo'<a href="http://localhost:8888/deconnexion.php"><button type="button">Déconnexion</button></a>';
        
        // ajouter ici bouton pour voir commande
        }
        else {  
        echo 
        '<form action="http://localhost:8888/creationCompte.php">
                    <button type="submit"> S\'inscrire </button></form>';

        echo
        '<form action="http://localhost:8888/connexion.php">
                    <button type="submit"> Se Connecter </button></form>';       
      }
    ?>

    <button type="" name="voir_panier"><a href="panier.php">Voir panier</a></button>
    <form action="rechercheProduitsGenerique.php" method="get">
      <p>Catégorie</p>
      <select name="catégorie" id="">
        <option value=''>Tous</option>
        <?php
          $sql="SELECT distinct catégorie FROM produits;";
          $res=$dbh->query($sql);
          foreach($res as $enr) {
            echo "<option value=".$enr['catégorie'].">".$enr['catégorie']."</option>";
          }
        ?>
      </select>
      <br>
      <p>Marque</p>
      <select name="marque" id="">
        <option value=''>Tous</option>
        <?php
          $sql="SELECT distinct marque FROM produits;";
          $res=$dbh->query($sql);
          foreach($res as $enr) {
            echo "<option value=".$enr['marque'].">".$enr['marque']."</option>";
          }
        ?>
      </select>
      <br>
      <p>Nom</p>
      <select name="nom" id="">
        <option value=''>Tous</option>
        <?php
          $sql="SELECT distinct nom FROM produits;";
          $res=$dbh->query($sql);
          foreach($res as $enr) {
            echo "<option value='".$enr['nom']."'>".$enr['nom']."</option>";
          }
        ?>
      </select>
      <br>
      <p>Prix max</p>
      <input type="number" name="prix_max" min="1">
      <br><br>
      <div>
        <button type="submit" name="rechercher" onclick="recherche()">Rechercher</button>
      </div>
    </form>
    
    <?php
      if (isset($_GET['rechercher'])) {
        $WHERE = "";
        // echo "<h3> Liste des produits : </h3>"; 
        // print_r($_GET);
        foreach ($_GET as $nom => $valeur) {
          // echo $nom;
          // echo ": ";
          // echo "$valeur";
          // echo "<br>";
          if ($valeur != "" && $nom != "rechercher") {
            if ($WHERE == "") {
              $WHERE .= "WHERE ";
            } else {
              $WHERE .= " AND ";
            }
            if ($nom == "prix_max") {
              $WHERE .= "prix<=$valeur";
            } else {style="display:none"
        $sql="SELECT * FROM produits $WHERE;";
        // echo $sql;
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();

        // echo "<ul>";
        // foreach ($result as $enr) {
        //   echo "<li>".$enr['numProduit'].$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</li>";
        // }
        // echo "</ul>";
      }
    ?>

    <form id="resultRecherche" action="rechercheProduitsGenerique.php" method="get">
      <p>Résultat de recherche :</p>
      <?php
        # Valider was clicked
        foreach ($result as $enr) {
          // echo $enr['numProduit'];
          echo '<div>';
            echo '<input type="number" name="'.$enr['numProduit'].'" min="0" value="'.$_SESSION['selection'][$enr['numProduit']].'">';
            echo "<p>".$enr['numProduit'].$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros </p>";
            // echo '<input type="checkbox" id="'.$enr['numProduit'].'" value="'.$enr['numProduit'].'">';
            // echo '<label for="'.$enr['numProduit'].'">'.$enr['numProduit'].$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</label>";
          echo '</div>';
        }
        // print_r($_GET);
      ?>
      <br>
      <div>
        <button type="submit" name="valider">Valider</button>
      </div>
    </form>

    <?php
      if (isset($_GET['valider'])) {
        foreach ($_GET as $selectId => $valeur) {
          // echo $selectId.' => '.$valeur."  ";
          $_SESSION['selection'][$selectId] = $valeur;
        }
        // foreach ($_SESSION['selection'] as $selectId => $valeur) {
        //   echo $selectId.' => '.$valeur."  ";
        // }
        header('location:http://localhost:8888/panier.php');
      }
    ?>

    
  </body>
</html>
<!-- Pour forcer l'appel d'un script php. header('location:http://...'); -->


