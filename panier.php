<?php session_start();
    // foreach ($_SESSION['selection'] as $selectId => $valeur) {
    //     echo $selectId.' => '.$valeur."  ";
    // }
    $email = $_SESSION['email'];
?>
<html>
    <head>
        <title>Panier</title>
        <meta charset="UTF-8" />
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
        <Fieldset>
            <img src="/image/panier.png" height=35px/>
            <br><br>
            <?php
                $sql = "SELECT * FROM produits;";
                
                $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
                $username = 'e20210011437';
                $password = 'sunying';
                $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");

                $sth = $dbh->prepare($sql);
                $sth->execute();
                $result = $sth->fetchAll();
                echo "<div>Utilisateur : ".$email."</div>";
            ?>
            
            <form action="panier.php" method="get">
                <?php
                    if (isset($_GET['commander'])) {
                        foreach ($_GET as $selectId => $valeur) {
                            // echo $selectId.' => '.$valeur."  ";
                            $_SESSION['selection'][$selectId] = $valeur;
                        }
                    }
                    foreach ($result as $enr) {
                        if ($_SESSION['selection'][$enr['numProduit']] > 0) {
                            echo '<div>';
                                echo '<input type="number" name="'.$enr['numProduit'].'" min="0" value="'.$_SESSION['selection'][$enr['numProduit']].'">';
                                echo "<p>".$enr['numProduit'].$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros </p>";
                            echo '</div>';
                        }
                    }
                ?>
                <br>
                <div>
                    <button type="submit" name="commander">Commander</button>
                </div>
            </form>
            <?php
                if (isset($_GET['commander'])) {
                    foreach ($_GET as $selectId => $valeur) {
                        // echo $selectId.' => '.$valeur."  ";
                        $_SESSION['selection'][$selectId] = $valeur;
                    }
                    // foreach ($_SESSION['selection'] as $selectId => $valeur) {
                    //     echo $selectId.' => '.$valeur."  ";
                    // }
                    $nbCommandeSql = "SELECT COUNT(*) as nb FROM commandes;";
                    $sth4 = $dbh->prepare($nbCommandeSql);
                    $sth4->execute();
                    $nbCommande = $sth4->fetchAll();
                    // print_r($nbCommande);
                    // echo "<br>";
                    // echo $nbCommande[0]['nb'];
                    $idCommande = $nbCommande[0]['nb'] + 1;
                    // echo "<br>";
                    // echo $idCommande;
                    // echo "<br>";
                    $_SESSION['idCommande'] = $idCommande;

                    $today = date("Ymd");
                    $_SESSION['calendrier'] = $today;
                    
                    if ($email) {
                        // créer une nouvelle commande
                        $newCommande = "INSERT INTO commandes VALUES (".$idCommande.",".$today.",'".$email."');";
                        // echo $newCommande;
                        $dbh->query($newCommande);
                        // créer les nouvelle lignes de commande
                        $idLC = 0;
                        foreach ($result as $enr) {
                            if ($_SESSION['selection'][$enr['numProduit']] > 0) {
                                $idLC = $idLC+1;
                                $quantite = $_SESSION['selection'][$enr['numProduit']];
                                $montant = $quantite * $enr['prix'];
                                $newLigneCommande = "INSERT INTO lignescommandes VALUES (".$idLC.",".$idCommande.",".$enr['numProduit'].",".$quantite.",".$montant.");";
                                $dbh->query($newLigneCommande);
                            }
                        }
                        // afficher les détails de commande et ligne de commande
                        echo "Commander avec succès !";
                        echo "<br>";
                        echo "Voici les détails de votre commande : ";
                        echo "<br>";
                        echo "Utilisateur : ".$email;
                        echo "<br>";
                        echo "Date de commande : ".$today;
                        echo "<br>";
                        echo "Référence de commande : ".$idCommande;
                        echo "<br>";
                        $ligneCommandeSql = "SELECT * FROM lignescommandes WHERE idCommande = ".$idCommande.";";
                        $sth2 = $dbh->prepare($ligneCommandeSql);
                        $sth2->execute();
                        $ligneCommande = $sth2->fetchAll();
                        $montantTotal = 0;
                        foreach ($ligneCommande as $lc) {
                            $produitSql = "SELECT * FROM produits WHERE numProduit = ".$lc['idProduit'].";";
                            // echo $produitSql;
                            $sth3 = $dbh->prepare($produitSql);
                            $sth3->execute();
                            $produit = $sth3->fetchAll();
                            echo "Nom produit : ".$produit[0]['nom'].", Quantité : ".$lc['quantité'].", Montant : ".$lc['montant'].".";
                            echo "<br>";
                            $montantTotal += $lc['montant'];
                        }
                        echo "Montant Total : ".$montantTotal;
                        unset($_SESSION['idCommande']);
                        unset($_SESSION['calendrier']);
                        foreach ($result as $enr) {
                            $_SESSION['selection'][$enr['numProduit']] = 0;
                        }
                    } else {
                        header('location:http://localhost:8888/connexion.php');
                    }
                }
            ?>
        </fieldset>

    </body>
</html>