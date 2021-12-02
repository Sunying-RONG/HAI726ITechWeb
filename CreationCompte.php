
<?php session_start();?>
<!-- mettre des commentaire : ctrl shift / -->


<html>


      <head>
            <title>Inscription</title>
      </head>

      <body>
            Inscription à l'espace membre : </br></br>


            <?php
            $sql = "SELECT * FROM clients";      
                  
                  
                  $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
                  $username = 'e20210011437';
                  $password = 'sunying';
                  $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");
                  // ^ lancer la BDD

                  $sth = $dbh->prepare($sql);
                  $sth->execute();
                  $result = $sth->fetchAll();

                   echo "<ul> LISTE COMPTE:";
                  foreach ($result as $enr) {
                  echo "<li> "
                       .$enr['email']."</li>";
                  
                  }
                  echo "</ul>";
                  // ^ vérification en affichant liste des comptes
            ?>
            <?php
            if (isset($_GET['email']) && !empty($_GET['email']) && $_GET['pass'] != "" ) { 
                  // isset verifie qu'il y a bien un champ email pour ne pas appeller cette fonction si on arrive sur cette page pour la premiere fois
                  // isempty verifie que le champ est bien rempli
                  $add = "INSERT INTO clients VALUES ('".$_GET['email']."', '".$_GET['pass']."', '".$_GET['nom']."', '".$_GET['surnom']."', '".$_GET['ville']."', '"
                  .$_GET['addresse']."', '".$_GET['tel']."');";
                  // echo $add;
                  // ^ test notre requete sql
                  $dbh->query($add);
                  // ajout du client dans la BDD
            }
            ?>

            <form method="get">
                  Email:
                  <input type="text" name="email" placeholder="" required/></br>
                  Mot de passe:
                  <input type="password" name="pass" placeholder="" required /></br>
                  Nom:
                  <input type="text" name="nom" placeholder="" required /></br> 
                  Prenom:
                  <input type="text" name="surnom" placeholder="" required /></br> 
                  ville:
                  <input type="text" name="ville" placeholder="" required /></br>
                  addresse:
                  <input type="text" name="addresse" placeholder="" required /></br>
                  Telephone:
                  <input type="text" name="tel" placeholder="" required /></br>

                  <input type="submit" value="validez"/>
            </form>
      </body>


</html>