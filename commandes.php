<?php session_start();?>
<!-- mettre des commentaire : ctrl shift / -->


<html>
      <head>
            <title>Commandes</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="style.css">
      </head>

      <body>
            <header>
                  <div class="fit-picture"><img src="/image/web_logo.png" height="200px"/></div>
            </header>
            <div class="menu2">
                  <br><br>
                  <button type=""><a href="rechercheProduitsGenerique.php">Retour à l'acceuil</a></button>
            </div>
            </br>
            <fieldset>
                  <img src="/image/commandes.png" height=35px/></br></br>
                  <?php
                        $sql = "SELECT * FROM commandes, lignescommandes";       
                        $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
                        $username = 'e20210011437';
                        $password = 'sunying';
                        $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");
                        // ^ lancer la BDD

                        $sth = $dbh->prepare($sql);
                        $sth->execute();
                        $result = $sth->fetchAll();
                  ?>
                  <?php 
                        if(isset($_SESSION['email'])){
                             echo "Commandes de ";
                             print_r($_SESSION['email']);
                             echo "<br><br>";
                             $com = "SELECT * FROM commandes WHERE email='".$_SESSION['email']."';" ; 
                             $sth = $dbh->prepare($com);
                             $sth->execute();
                             $result = $sth->fetchAll();

                            echo "<ul> LISTE COMMANDES:<br>";
                              foreach ($result as $enr) {
                                echo "<br><li>
                                Commande numéro ".$enr['idCommande'].", passée le".$enr['calendrier']."</li>";
                                $ligne = "SELECT * FROM lignescommandes WHERE idCommande='".$enr['idCommande']."';";
                                $listh = $dbh->prepare($ligne);
                                $listh->execute();
                                $liresult = $listh->fetchAll();
                                foreach ($liresult as $lienr) {
                                    echo "<li> Produit Numéro "
                                    .$lienr['idProduit']. ", d'un montant de ".$lienr['montant']."€, en ".$lienr['quantité']." exemplaires</li>";
                                }}
                            echo "</ul>";
                            
                        }
       
                 ?>
            </fieldset>
            

      </body>




</html>