<html>
  <head>
    <title> Liste des produits </title>
      <meta charset="UTF-8" />
  </head>
  <body>
    <h3> Liste des produits </h3>
    <?php
      $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
      $username = 'e20210011437';
      $password = 'sunying';
      $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");

      $sql = "SELECT * FROM produits;";      
      $sth = $dbh->prepare($sql);
      $sth->execute(); /* Les données que le SGBD nous renvoie sont stockées en mémoire */
      $result = $sth->fetchAll(); /* Toutes ces données sont recopiées dans le tableau result */

      echo "<ul>";
      foreach ($result as $enr) { /* Chaque élément de result est le tableau des attributs */
         echo "<li>".$enr['nom']." (".$enr['catégorie'].") : ".$enr['prix']."</li>";
      }
       echo "</ul>";
    ?>
  </body>
</html>

