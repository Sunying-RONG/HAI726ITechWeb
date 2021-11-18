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

    <select name="marque" id="select">
      <?php
        $sql2="SELECT distinct marque FROM produits;";
        $res=$dbh->query($sql2);
        foreach($res as $enr) {
          echo "<option value=".$enr['marque'].">".$enr['marque']."</option>";
        }
      ?>
    </select>
    
  </body>
</html>
<!-- echo "<li>".$enr['nom']." (".$enr['catégorie'].") : ".$enr['prix']."</li>"; -->

