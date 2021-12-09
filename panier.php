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
                <button type="submit" name="commander">
                <!-- <a href="panier.php">Valider</a> -->
                    <a>Commander</a>
                </button>
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
            }
        ?>
    </body>
</html>