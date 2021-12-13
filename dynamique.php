<?php
    // echo "dynamique";
    $c=$_REQUEST["c"];
    $m=$_REQUEST["m"];
    $n=$_REQUEST["n"];
    // echo $c;
    // echo $m;
    // echo $n;

    $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
    $username = 'e20210011437';
    $password = 'sunying';
    $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");

    // categorie
    $sqlCategorie="SELECT distinct catégorie FROM produits";
    $sqlcw="";
    if ($m) {
        $sqlcw .= " WHERE marque='".$m."'";
    }
    if ($n) {
        if ($sqlcw == "") {
            $sqlcw .= " WHERE nom='".$n."'";
        } else {
            $sqlcw .= " AND nom='".$n."'";
        }
    }
    $sqlcw .= ";";
    $sqlCategorie .= $sqlcw;
    // echo $sqlCategorie;
    $resCategoriePossible=$dbh->query($sqlCategorie);
    $categoriePossible=array();
    foreach($resCategoriePossible as $enr) {
    // echo $enr['catégorie'];
        array_push($categoriePossible, $enr['catégorie']);
    // echo "<option value=".$enr['catégorie'].">".$enr['catégorie']."</option>";
    }

    // marque
    $sqlMarque="SELECT distinct marque FROM produits";
    $sqlmw="";
    if ($c) {
        $sqlmw .= " WHERE catégorie='".$c."'";
    }
    if ($n) {
        if ($sqlmw == "") {
            $sqlmw .= " WHERE nom='".$n."'";
        } else {
            $sqlmw .= " AND nom='".$n."'";
        }
    }
    $sqlmw .= ";";
    $sqlMarque .= $sqlmw;
    // echo $sqlMarque;
    $resMarquePossible=$dbh->query($sqlMarque);
    $marquePossible=array();
    foreach($resMarquePossible as $enr) {
        array_push($marquePossible, $enr['marque']);
    }

    // nom
    $sqlNom="SELECT distinct nom FROM produits";
    $sqlnw="";
    if ($c) {
        $sqlnw .= " WHERE catégorie='".$c."'";
    }
    if ($m) {
        if ($sqlnw == "") {
            $sqlnw .= " WHERE marque='".$m."'";
        } else {
            $sqlnw .= " AND marque='".$m."'";
        }
    }
    $sqlnw .= ";";
    $sqlNom .= $sqlnw;
    // echo $sqlNom;
    $resNomPossible=$dbh->query($sqlNom);
    $nomPossible=array();
    foreach($resNomPossible as $enr) {
        array_push($nomPossible, $enr['nom']);
    }

    echo json_encode(array($categoriePossible, $marquePossible, $nomPossible), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



?>