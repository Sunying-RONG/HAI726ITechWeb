<html>
  <head>
    <title> Liste des produits par catégorie et marque </title>
      <meta charset="UTF-8" />
  </head>
  <body>
    
    <?php
      $WHERE = "";
      $INFOS = "";
      foreach ($_GET as $nom => $valeur) {
       if ($valeur != "") {
        if ($WHERE == "") $WHERE .= "WHERE ";
        else              $WHERE .= " AND ";
        $WHERE .= "$nom='$valeur'";
        $INFOS .= "$nom='$valeur' ";
     }
      }
      echo "<h3> Liste des produits : $INFOS </h3>";    
      $sql = "SELECT * FROM produits $WHERE;";      
      echo $sql; /* Pour le déboguage */
      
      $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
      $username = 'e20210011437';
      $password = 'sunying';
      $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");

      $sth = $dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll();

      print_r($result);

      echo "<ul>";
      foreach ($result as $enr) {
         echo "<li>".$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</li>";
      }
      echo "</ul>";
    ?>
    <form action="panier.php" method="post">
      <select name="categorie" id="">
        <?php
          $sql="SELECT distinct catégorie FROM produits;";
          $res=$dbh->query($sql);
          foreach($res as $enr) {
            echo "<option value=".$enr['catégorie'].">".$enr['catégorie']."</option>";
          }
        ?>
      </select>
      <select name="marque" id="">
        <?php
          $sql="SELECT distinct marque FROM produits;";
          $res=$dbh->query($sql);
          foreach($res as $enr) {
            echo "<option value=".$enr['marque'].">".$enr['marque']."</option>";
          }
        ?>
      </select>
      <select name="nom" id="">
        <?php
          $sql="SELECT distinct nom FROM produits;";
          $res=$dbh->query($sql);
          foreach($res as $enr) {
            echo "<option value=".$enr['nom'].">".$enr['nom']."</option>";
          }
        ?>
      </select>
      <select name="prix" id="">
        <?php
          $sql="SELECT distinct prix FROM produits;";
          $res=$dbh->query($sql);
          foreach($res as $enr) {
            echo "<option value=".$enr['prix'].">".$enr['prix']."</option>";
          }
        ?>
      </select>
      <input type="number" name="nombre" min="0">
      <input type="submit" name="submit_button" value="Ajouter dans panier">
    </form>
   

    <a href="CreationCompte.php">Vous inscrire</a>

    
  </body>
</html>
<!-- echo "<li>".$enr['nom']." (".$enr['catégorie'].") : ".$enr['prix']."</li>"; -->

