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
    <header>
      <div class="fit-picture"><img src="/image/web_logo.png" height="200px"/></div>
    </header>
    
    <main>

<!--LANCEMENT BDD-->
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

<!--CADRE CONNEXION ET MENU-->
      <div class="menu">
      <br>
      <img src="/image/menu.png" height=35px/>
      <br><br><br>
      <?php 
        if(isset($_SESSION['email'])){
          echo "Bonjour, <br>";
          print_r($_SESSION['email']);
          echo "<br><br>";
          echo'<a href="http://localhost:8888/deconnexion.php"><button type="button">Déconnexion</button></a>';
          echo"<br><br>";
          echo'<a href="http://localhost:8888/commandes.php"><button type="button">Historique</button></a>';
          echo"<br><br>";
        }
        else {  
          echo 
          '<form action="http://localhost:8888/creationCompte.php"><button type="submit"> S\'inscrire </button></form>';
          echo
          '<form action="http://localhost:8888/connexion.php"><button type="submit"> Se Connecter </button></form>';       
        }
      ?>
     <button type="" name="voir_panier"><a href="panier.php">Voir panier</a></button>
     <form action="rechercheProduitsGenerique.php" method="get">
     </div>
    
<!--    RECHERCHE PAR CRITERE      -->
      <fieldset>
        <img src="/image/recherche.png" height=35px/>
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
                } else {
                  $WHERE .= "$nom='$valeur'";
                }
              }
            }
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
      </fieldset>
    

<!--         RESULTAT RECHERCHE          -->
      <br>
      <fieldset>
        <img src="/image/resultats.png" height=35px/>
        <br><br>
        <form id="resultRecherche" action="rechercheProduitsGenerique.php" method="get">
         
          <?php
            # Valider was clicked
            foreach ($result as $enr) {
              // echo $enr['numProduit'];
            
              echo '<div class=justfier><input size="4" type="number" name="'.$enr['numProduit'].'" min="0" value="'.$_SESSION['selection'][$enr['numProduit']].'">';
              echo " ".$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros </div><br><br>";
              // echo '<input type="checkbox" id="'.$enr['numProduit'].'" value="'.$enr['numProduit'].'">';
              // echo '<label for="'.$enr['numProduit'].'">'.$enr['numProduit'].$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</label>";
              
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
      </fieldset>
    </main>
  </body>
</html>
<!-- Pour forcer l'appel d'un script php. header('location:http://...'); -->


