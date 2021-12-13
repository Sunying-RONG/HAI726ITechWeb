
<?php session_start();?>
<!-- mettre des commentaire : ctrl shift / -->


<html>


      <head>
            <title>Inscription</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="style.css">
      </head>

      <body>
         <header>
            <img class="fit-picture" src="/image/title_placeholder.svg">
         </header>
            </br>



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

                   //echo "<ul> LISTE COMPTE:";
                  //foreach ($result as $enr) {
                  //echo "<li> "
                   //    .$enr['email']."</li>";
                  // }

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
                <center>
                <br>
                <fieldset>
                <h2> Inscription </h2>
               
                  <p>Email: <br>
                     <input type="email" name="email" placeholder="" required/><br>
                  </p>
                  <p>Mot de passe:<br>
                     <input type="password" name="pass" placeholder="" required /><br>
                  </p>
                  <p>Nom:<br>
                     <input type="text" name="nom" placeholder="" required /><br> 
                  </p>
                  <p>Prenom:<br>
                     <input type="text" name="surnom" placeholder="" required /><br>
                  </p> 
                  <p>ville:<br>
                     <input type="text" name="ville" placeholder="" required /><br>
                  </p>
                  <p>addresse:<br>
                     <input type="text" name="addresse" placeholder="" required /><br>
                  </p>
                  <p>Telephone:<br>
                     <input type="text" name="tel" placeholder="" required /><br>
                  </p>
                  <p>
                     <input type="submit" value="validez"/>
                  </p>
                </fieldset>
                </center>
            </form>

            
         <div class="container">
         <div class="left">
            <p> Vous avez déjà un compte ? </p>
            <button type="" name="se_connecter"><a href="connexion.php">Se connecter</a></button>
         </div>
         <div class="right">
    
                <p></p>
                <form action="http://localhost:8888/rechercheProduitsGenerique.php">
                  <button type="submit"> Retour </button>
                </form>
         </div>
         </div>
         
      </body>


</html>