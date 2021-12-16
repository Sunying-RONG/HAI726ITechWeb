
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
         <div class="fit-picture"><img src="/image/web_logo.png" height="200px"/></div>
      </header>
      
      <div class="menu2">
            <p> Vous avez déjà un compte ? </p>
            <button type="" name="se_connecter"><a href="connexion.php">Se connecter</a></button>
            <br><br>
            <button type=""><a href="rechercheProduitsGenerique.php">Retour à l'acceuil</a></button>
      </div>

      <main>
         <?php
            //On lance la BDD
            $sql = "SELECT * FROM clients";                                                
            $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
            $username = 'e20210011437';
            $password = 'sunying';
            $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");
            
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll();

            //echo "<ul> LISTE COMPTE:";
            //foreach ($result as $enr) {
            //echo "<li> "
            //    .$enr['email']."</li>";
            // }

            // echo "</ul>";
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
                <br>
                <fieldset>
                  <img src="/image/inscription.png" height=35px/>
                  <br>
                  <p class="critere">Email:</p>
                  <input class="input_prix" type="email" name="email" placeholder="" required/><br>
                  
                  <p class="critere">Mot de passe:</p>
                  <input class="input_prix" type="password" name="pass" placeholder="" required /><br>
                  
                  <p class="critere">Nom:</p>
                  <input class="input_prix" type="text" name="nom" placeholder="" required /><br> 
                  
                  <p class="critere">Prenom:</p> 
                  <input class="input_prix" type="text" name="surnom" placeholder="" required /><br>
                  
                  <p class="critere">ville:</p>
                  <input class="input_prix" type="text" name="ville" placeholder="" required /><br>
                  
                  <p class="critere">addresse:</p>
                  <input class="input_prix" type="text" name="addresse" placeholder="" required /><br>
                  
                  <p class="critere">Telephone:</p>
                  <input class="input_prix" type="text" name="tel" placeholder="" required /><br>

                  <button type="submit" name="">validez</button>
                </fieldset>
         </form>

            
         
      </main>
   </body>


</html>