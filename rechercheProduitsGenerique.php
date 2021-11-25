
<html>
  <head>
    <title> Liste des produits par catégorie et marque </title>
      <meta charset="UTF-8" />
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
      echo $sql; /* Pour le déboguage */
      
      $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
      $username = 'e20210011437';
      $password = 'sunying';
      $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");

      $sth = $dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll();

      // print_r($result);

      echo "<ul>";
      foreach ($result as $enr) {
        echo "<li>".$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</li>";
      }
      echo "</ul>";
    ?>
   
    <form action="rechercheProduitsGenerique.php" method="get">
      <p>Catégorie</p>
      <select name="catégorie" id="">
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
        <?php
          $sql="SELECT distinct nom FROM produits;";
          $res=$dbh->query($sql);
          foreach($res as $enr) {
            echo "<option value=".$enr['nom'].">".$enr['nom']."</option>";
          }
        ?>
      </select>
      <br>
      <p>Prix max</p>
      <input type="number" name="prix_max" min="1">
      <br><br>
      <input type="submit" name="submit_button" value="Ajouter article dans panier">
    </form>

    <?php
      $WHERE = "";
      echo "<h3> Liste des produits : </h3>"; 
      foreach ($_GET as $nom => $valeur) {
        echo $nom;
        echo ": ";
        echo $valeur;
        echo "<br>";
        if ($valeur != "" && $nom != "submit_button") {
          if ($WHERE == "") $WHERE .= "WHERE ";
          else              $WHERE .= " AND ";
          $WHERE .= "$nom='$valeur'";
        }
      }
     
      $sql="SELECT * FROM produits $WHERE;";
      echo $sql;
      $sth = $dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll();

      echo "<ul>";
      foreach ($result as $enr) {
        echo "<li>".$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</li>";
      }
      echo "</ul>";
    ?>
      <!-- <p>Nombre</p>
      <input type="number" name="nombre" min="0">
      <br>
    
      <br><br>
      <button>Aller au panier</button> -->

  </body>
</html>
<!-- Pour forcer l'appel d'un script php. header('location:http://...'); -->
