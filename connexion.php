<?php session_start();?>
<!-- mettre des commentaire : ctrl shift / -->


<html>
      <head>
            <title>Connexion</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="style.css">
      </head>

      <body>
            <header>
                  <div class="fit-picture"><img src="/image/web_logo.png" height="200px"/></div>
            </header>
            <div class=menu2>
                  <br><br>
                  <p>Vous n'avez pas de compte? Veuillez vous inscrire.</p>
                  <button type=""><a href="http://localhost:8888/creationCompte.php">S'inscrire</a></button>
                  <br><br>
                  <form action="http://localhost:8888/rechercheProduitsGenerique.php">
                  <button type="submit"> Retour à l'acceuil </button>
                  </form>
            </div>
            </br>
            <fieldset>
                  <img src="/image/connexion.png" height=35px/></br></br>
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
                        //.$enr['email']."</li>";
                        
                        //}
                        //echo "</ul>";
                        // ^ vérification en affichant liste des comptes
                  ?>
                  <?php
                        if (isset($_GET['email']) && !empty($_GET['email']) && $_GET['pass'] != "" ) { 
                              // isset verifie qu'il y a bien un champ email pour ne pas appeller cette fonction si on arrive sur cette page pour la premiere fois
                              // isempty verifie que le champ est bien rempli

                              $verif = "SELECT * FROM clients WHERE email='".$_GET['email']."' AND motdepasse='".$_GET['pass']."';" ; 
                              //echo $verif;
                              $vsth = $dbh->prepare($verif);
                              $vsth->execute();
                              $vresult = $vsth->fetchAll();
                              if (count($vresult)>0) {
                                    //print_r($vresult);
                                    echo "Bonjour, ";
                                    $_SESSION['email'] = $_GET['email'];
                              }
                        
                              print_r($_SESSION['email']);
                              // depuis commande à connexion, revenir à commande
                              if ($_SESSION['idCommande'] && $_SESSION['calendrier']) {
                                    header('location:http://localhost:8888/panier.php');
                              }
                        }
                  ?>
             
                  <form method="get">
                        Email:
                        <input type="email" name="email" placeholder="" required/></br>
                        <br>
                        Mot de passe:
                        <input type="password" name="pass" placeholder="" required /></br>
                        <br>
                        <input type="submit" value="validez"/>

            </form>
            </fieldset>
      

      </body>




</html>