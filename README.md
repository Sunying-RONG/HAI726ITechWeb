# HAI726ITechWeb
Universite de Montpellier

LANCEMENT DU PROJET:  
En utilisant la base de données mysql de l'Université de Montpellier, pour utiliser les données, on doit lancer le projet dans ordinateur ou système de x2go de l'Université.  
Lancer php server dans le dossier où se trouve le code de php.  
php -S localhost:8888  
ouvrir un navigateur, la page d'accueil se trouve à l’url suivante:  
http://localhost:8888/rechercheProduitsGenerique.php  

Note :  
X2go Linux, Mysql database of university  
1. Dans le terminal :  
    mysql -h mysql.etu.umontpellier.fr -u e*********** -p  
2. Entrer password  
`>show databases;`  
`>use e***********` // use database   
`>show tables;`  
`>describe tableName;` // show structure de table   
`>source produits.sql;` import script, mise a jour, create table  
`>select * from produits` afficher les tuples, les donees  

if a server already execute  
`>ps -edf`  
`>ps -edf | grep php`  
`>kill -9 60078`  

Comment mémoriser des informations sur la navigation sans être obligé de les sauver en BD ?   
- (ne plus utilisé) cookies : côté client  
- session : côté serveur, géré par le serveur HTTP  
`<?php session_start();?>`  
Au début de tous les scriipts php qui vont utilisé la session (càd avant <html>)  

- mise à disposition du tableau superglobal  
$_session['mail'] = ...;  
$mail = $_session['mail'];  
$_session = array(); // vide session  
// durée de session  
$_GET   
$_POST  

dans navigateur  
session storage  
local storage  

