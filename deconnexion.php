<?php session_start();
$_SESSION=array();?>

<html>


    <head>
        <title>Deconnexion</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
      <p> Deconnexion . . . </p>
       (redirection vers la page d'acceuil dans 3 secondes)
      <script type="text/javascript">
        (function(){
          setTimeout(function(){
          window.location="http://localhost:8887/rechercheProduitsGenerique.php?/";
         },3000); /* 1000 = 1 second*/
        })();
      </script>
    </body>
