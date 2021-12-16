<?php session_start();
?> 
<!-- crée session ou réutilisation si existe -->
<html>


  <head>
    <title>Liste des produits par catégorie et marque</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
  </head>


  <body>
    <header>
         <div class="fit-picture"><img src="/image/web_logo.png" height="200px"/></div>
    </header>
    <?php
      // $WHERE = "";
      // $INFOS = "";
      // foreach ($_GET as $nom => $valeur) {
      //   if ($valeur != "") {
      //     if ($WHERE == "") $WHERE .= "WHERE ";
      //     else              $WHERE .= " AND ";
      //     $WHERE .= "$nom='$valeur'";
      //     $INFOS .= "$nom='$valeur' ";
      //   }
      // }
      // echo "<h3> Liste des produits : $INFOS </h3>";    
      
      // echo $sql; /* Pour le déboguage */
      
      $dsn = 'mysql:host=mysql.etu.umontpellier.fr;dbname=e20210011437;charset=UTF8';
      $username = 'e20210011437';
      $password = 'sunying';
      $dbh = new PDO($dsn, $username, $password) or die("Pb de connexion !");

      $sqlTous = "SELECT * FROM produits;"; 
      $sth = $dbh->prepare($sqlTous);
      $sth->execute();
      $resultTous = $sth->fetchAll();

      $sqlCategorie="SELECT distinct catégorie FROM produits;";
      $resCategorie=$dbh->query($sqlCategorie);
      $tousCategorie=array();
      foreach($resCategorie as $enr) {
        // echo $enr['catégorie'];
        array_push($tousCategorie, $enr['catégorie']);
        // echo "<option value=".$enr['catégorie'].">".$enr['catégorie']."</option>";
      }
      // print_r($tousCategorie);

      // echo "<ul>";
      // foreach ($result as $enr) {
      //   echo "<li>".$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</li>";
      //   if (!$_SESSION['selection'][$enr['numProduit']]) {
      //     $_SESSION['selection'][$enr['numProduit']] = 0;
      //   }
      // }
      // echo "</ul>";
      $sqlMarque="SELECT distinct marque FROM produits;";
      $resMarque=$dbh->query($sqlMarque);
      $tousMarque=array();
      foreach($resMarque as $enr) {
        // echo $enr['marque'];
        array_push($tousMarque, $enr['marque']);
      }

      $sqlNom="SELECT distinct nom FROM produits;";
      $resNom=$dbh->query($sqlNom);
      $tousNom=array();
      foreach($resNom as $enr) {
        // echo $enr['nom'];
        array_push($tousNom, $enr['nom']);
      }
    ?>
    
    <script>
      let categorieChoisi;
      let marqueChoisi;
      let nomChoisi;
      
      function OnSelectionChange() {
        categorieChoisi = document.getElementById('categorie').value;
        console.log(categorieChoisi);
        marqueChoisi = document.getElementById('marque').value;
        console.log(marqueChoisi);
        nomChoisi = document.getElementById('nom').value;
        console.log(nomChoisi);

        const xhr = new XMLHttpRequest(),
          method = "GET",
          url = "http://localhost:8887/dynamique.php";
        let url2 = url+"?c="+categorieChoisi+"&m="+marqueChoisi+"&n="+nomChoisi;
        console.log(url2);
        xhr.open(method, url2, true);
        xhr.onreadystatechange = function () {
          // In local files, status is 0 upon success in Mozilla Firefox
          if(xhr.readyState === XMLHttpRequest.DONE) {
            var status = xhr.status;
            if (status === 0 || (status >= 200 && status < 400)) {
              let categorieUpdate;
              let marqueUpdate;
              let nomUpdate;
              // The request has been completed successfully
              console.log("-----");
              console.log("responseText : ",xhr.responseText);
              var data = JSON.parse(xhr.responseText);
              // var data = xhr.responseText;
              console.log(data);
              categorieUpdate=data[0];
              marqueUpdate=data[1];
              nomUpdate=data[2];
              console.log(categorieUpdate); //categorie
              console.log(marqueUpdate); //marque
              console.log(nomUpdate); //nom
              console.log("###");

              // rebuild categorie select options
              categorieOptions = [];
              categorieOptions.push(
                {
                  text: 'tous',
                  value: ''
                }
              );
              for (let i=0; i<categorieUpdate.length; i++) {
                categorieOptions.push(
                  {
                    text: categorieUpdate[i],
                    value: categorieUpdate[i]
                  }
                );
              }
              console.log("!!",categorieOptions);
              while (categorieList.length) {
                categorieList.remove(0);
              }
              
              categorieOptions.forEach(option => {
                if (option.value == categorieChoisi) {
                  categorieList.add(
                    new Option(option.text, option.value, false, true)
                  )
                } else {
                  categorieList.add(
                    new Option(option.text, option.value)
                  )
                }
              });

              // rebuild marque select options
              marqueOptions = [];
              marqueOptions.push(
                {
                  text: 'tous',
                  value: ''
                }
              );
              for (let i=0; i<marqueUpdate.length; i++) {
                marqueOptions.push(
                  {
                    text: marqueUpdate[i],
                    value: marqueUpdate[i]
                  }
                );
              }
              console.log("!!",marqueOptions);
              while (marqueList.length) {
                marqueList.remove(0);
              }
              
              marqueOptions.forEach(option => {
                if (option.value == marqueChoisi) {
                  marqueList.add(
                    new Option(option.text, option.value, false, true)
                  )
                } else {
                  marqueList.add(
                    new Option(option.text, option.value)
                  )
                }
              });
              // document.getElementById('marque').options

              // rebuild nom select options
              nomOptions = [];
              nomOptions.push(
                {
                  text: 'tous',
                  value: ''
                }
              );
              for (let i=0; i<nomUpdate.length; i++) {
                nomOptions.push(
                  {
                    text: nomUpdate[i],
                    value: nomUpdate[i]
                  }
                );
              }
              console.log("!!",nomOptions);
              // categorieList = document.getElementById('categorie').options;
              while (nomList.length) {
                nomList.remove(0);
              }
              nomOptions.forEach(option => {
                if (option.value == nomChoisi) {
                  nomList.add(
                    new Option(option.text, option.value, false, true)
                  )
                } else {
                  nomList.add(
                    new Option(option.text, option.value)
                  )
                }
              });

            } else {
              console.log("error");
              // Oh no! There has been an error with the request!
            }
          }
        };
        xhr.send();
      }
      
      var tousCategorie = new Array();
      <?php foreach ($tousCategorie as $key => $value) { ?>
          tousCategorie.push('<?php echo $value?>');
      <?php }?>
      // for (let i=0; i < tousCategorie.length; i++) {
      //   console.log("tousCategorie", tousCategorie[i]);
      // }
      var categorieOptions = new Array();
      categorieOptions.push(
        {
          text: 'tous',
          value: ''
        }
      );
      for (let i=0; i < tousCategorie.length; i++) {
        categorieOptions.push(
          {
            text: tousCategorie[i],
            value: tousCategorie[i]
          }
        );
      }

      var tousMarque = new Array();
      <?php foreach ($tousMarque as $key => $value) { ?>
        tousMarque.push('<?php echo $value?>');
      <?php }?>
      // for (let i=0; i < tousMarque.length; i++) {
      //   console.log("tousMarque", tousMarque[i]);
      // }
      var marqueOptions = new Array();
      marqueOptions.push(
        {
          text: 'tous',
          value: ''
        }
      );
      for (let i=0; i < tousMarque.length; i++) {
        marqueOptions.push(
          {
            text: tousMarque[i],
            value: tousMarque[i]
          }
        );
      } 

      var tousNom = new Array();
      <?php foreach ($tousNom as $key => $value) { ?>
        tousNom.push('<?php echo $value?>');
      <?php }?>
      // for (let i=0; i < tousNom.length; i++) {
      //   console.log("tousNom", tousNom[i]);
      // }
      var nomOptions = new Array();
      nomOptions.push(
        {
          text: 'tous',
          value: ''
        }
      );
      for (let i=0; i < tousNom.length; i++) {
        nomOptions.push(
          {
            text: tousNom[i],
            value: tousNom[i]
          }
        );
      }

      function Reset() {
        console.log('reset!');
        document.getElementById('categorie').options[0].selected = true;
        document.getElementById('marque').options[0].selected = true;
        document.getElementById('nom').options[0].selected = true;
        OnSelectionChange();
      }

    </script>
    <div class=menu>
      <br>
      <img src="/image/menu.png" height=35px/>
      <br><br>
    <!--    CADRE CONNEXION      -->
    <?php 
        if(isset($_SESSION['email'])){
          echo "Bonjour, <br>";
          print_r($_SESSION['email']);
          echo "<br><br>";
          echo'<a href="http://localhost:8887/deconnexion.php"><button type="button">Déconnexion</button></a>';
          echo"<br><br>";
          echo'<a href="http://localhost:8887/commandes.php"><button type="button">Historique</button></a>';
          echo"<br><br>";
        }
        else {  
          echo 
          '<form action="http://localhost:8887/creationCompte.php"><button type="submit"> S\'inscrire </button></form>';
          echo
          '<form action="http://localhost:8887/connexion.php"><button type="submit"> Se Connecter </button></form>';       
        }
      ?>
    <button type="" name="voir_panier"><a href="panier.php">Voir panier</a></button>
    </div>

    <fieldset>
      <img src="/image/recherche.png" height=35px/>
    <form action="rechercheProduitsGenerique.php" method="get">
      <p>Catégorie</p>
      <select name="catégorie" id="categorie" onchange="OnSelectionChange()">
      </select>
      <script>
        let categorieList = document.getElementById('categorie').options;
        categorieOptions.forEach(option =>
          categorieList.add(
            new Option(option.text, option.value)
          )
        );
        
      </script>
      <br>
      <p>Marque</p>
      <select name="marque" id="marque" onchange="OnSelectionChange()">
      </select>
      <script>
        let marqueList = document.getElementById('marque').options;
          marqueOptions.forEach(option =>
          marqueList.add(
            new Option(option.text, option.value)
          )
        );
      </script>
      <br>
      <p>Nom</p>
      <select name="nom" id="nom" onchange="OnSelectionChange()">
      </select>
      <script>
        let nomList = document.getElementById('nom').options;
          nomOptions.forEach(option =>
          nomList.add(
            new Option(option.text, option.value)
          )
        );
      </script>
      <br><br>
      <button type="" name="" onClick="Reset()">Réinitialiser les critères</button>
      <br>
      <p>Prix max</p>
      <input type="number" name="prix_max" min="1">
      <br><br>
      <div>
        <button type="submit" name="rechercher">Rechercher</button>
      </div>
    </form>
    <script>
        
        // document.getElementById("categorie").onchange = changeCategorie;
        // function changeCategorie(){
        //    php echo global $categorieChoisi;= this.value;
        //    console.log("##categorieChoisi",this.value);
        // }
        // document.getElementById("marque").onchange = changeMarque;
        // function changeMarque(){
        //    $_SESSION["marqueChoisi"]= this.value;
        //    console.log("marque",this.value);
        // }
        // document.getElementById("nom").onchange = changeNom;
        // function changeNom(){
        //    $_SESSION["nomChoisi"]= this.value;
        //    console.log("nom",this.value);
        // }
    </script>
    </fieldset>
    <fieldset>
      <img src="/image/resultats.png" height=35px/>
    <?php
      if (isset($_GET['rechercher'])) {
        $WHERE = "";
        // echo "<h3> Liste des produits : </h3>"; 
        // print_r($_GET);
        foreach ($_GET as $nom => $valeur) {
          // echo $nom;
          // echo ": ";
          // echo "$valeur";
          // echo "<br>";
          if ($valeur != "" && $nom != "rechercher") {
            if ($WHERE == "") {
              $WHERE .= "WHERE ";
            } else {
              $WHERE .= " AND ";
            }
            if ($nom == "prix_max") {
              $WHERE .= "prix<=$valeur";
            } else {
              $WHERE .= "$nom='$valeur'";
            }
          }
        }
        $sql="SELECT * FROM produits $WHERE;";
        // echo $sql;
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();

        // echo "<ul>";
        // foreach ($result as $enr) {
        //   echo "<li>".$enr['numProduit'].$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</li>";
        // }
        // echo "</ul>";
        echo '<form action="rechercheProduitsGenerique.php" method="get">';
          echo '<p>Veuillez entrer les Quantités ci-dessous<p>';
          # Valider was clicked
          foreach ($result as $enr) {
            // echo $enr['numProduit'];
            echo '<div>';
              echo '<input type="number" name="'.$enr['numProduit'].'" min="0" value="'.$_SESSION['selection'][$enr['numProduit']].'">';
              echo "<p>".$enr['numProduit'].$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros </p>";
              // echo '<input type="checkbox" id="'.$enr['numProduit'].'" value="'.$enr['numProduit'].'">';
              // echo '<label for="'.$enr['numProduit'].'">'.$enr['numProduit'].$enr['nom']." (".$enr['catégorie'].") de marque ".$enr['marque']." : ".$enr['prix']." euros</label>";
            echo '</div>';
          }
          // print_r($_GET);
          echo '<br>';
          echo '<div>';
            echo '<button type="submit" name="valider">Valider</button>';
          echo '</div>';
        echo '</form>';
      }
    ?>

    <?php
      if (isset($_GET['valider'])) {
        foreach ($_GET as $selectId => $valeur) {
          // echo $selectId.' => '.$valeur."  ";
          $_SESSION['selection'][$selectId] = $valeur;
        }
        // foreach ($_SESSION['selection'] as $selectId => $valeur) {
        //   echo $selectId.' => '.$valeur."  ";
        // }
        header('location:http://localhost:8887/panier.php');
      }
    ?>
    </fieldset>
    <!-- <script type="text/javascript" src="scriptRecherche.js"></script> -->
  </body>
</html>