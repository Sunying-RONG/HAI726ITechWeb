<?php session_start();
    // $items = unserialize($_session['selection']);
    foreach ($_SESSION['selection'] as $selectId => $valeur) {
        echo $selectId.' => '.$valeur."  ";
    }
?>
<html>
    <head>
        <title>Panier</title>
        <meta charset="UTF-8" />
    </head>
    <body>
        <?php
            $sql = "SELECT * FROM produits;";
            
            $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
            $username = 'e20210011437';
            $password = 'sunying';
            $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");

            $sth = $dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll();
        ?>
        <form action="panier.php" method="get">
            <?php
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
                foreach ($_SESSION['selection'] as $selectId => $valeur) {
                    echo $selectId.' => '.$valeur."  ";
                }
                // commandes (idCommande, calendrier, email)
                $nbCommandeSql = "SELECT COUNT(*) FROM commandes;";
                $nbCommandeSql = $dbh->prepare($sql);
                $nbCommandeSql->execute();
                $nbCommande = $nbCommandeSql->fetchAll();
                $idCommande = $nbCommande+1;
                echo $idCommande;
                $_SESSION['idCommande'] = $idCommande;

                $today = date("Ymd");
                echo $today;
                $_SESSION['calendrier'] = $today;
               
                $email = $_SESSION['email'];
                if ($email) {
                    // créer une nouvelle commande
                    $newCommande = "INSERT INTO commandes VALUES (".$idCommande.",".$today.",".$email.");";
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
                    echo "Voici les détails de votre commande : ";
                    echo "Utilisateur : ".$email;
                    echo "Date de commande : ".$today;
                    echo "Référence de commande : ".$idCommande;
                    $ligneCommandeSql = "SELECT * FROM lignescommandes WHERE idCommande = ".$idCommande.";";
                    $sth2 = $dbh->prepare($ligneCommandeSql);
                    $sth2->execute();
                    $ligneCommande = $sth2->fetchAll();
                    $montantTotal = 0;
                    foreach ($ligneCommande as $lc) {
                        $nomProduitSql = "SELECT nom FROM produits WHERE numProduit = ".$lc['idProduit'].";";
                        $sth3 = $dbh->prepare($nomProduitSql);
                        $sth3->execute();
                        $nomProduit = $sth3->fetchAll();
                        echo "Nom produit : ".$nomProduit.", Quantité : ".$lc['quantité'].", Montant : ".$lc['montant'].".";
                        $montantTotal += $lc['montant'];
                    }
                    echo "Montant Total : ".$montantTotal;
                    unset($_SESSION['idCommande']);
                    unset($_SESSION['calendrier']);
                } else {
                    header('location:http://localhost:8887/connexion.php');
                }
            }
        ?>
        <button type=""><a href="rechercheProduitsGenerique.php">Retour à l'acceuil</a></button>
    </body>
</html>