# HAI726ITechWeb
Universite de Montpellier

X2go Linux, Mysql database of university 

1. Dans le terminal :  
    mysql -h mysql.etu.umontpellier.fr -u e20210011437 -p
2. Entrer password  
    sunying   
`>show databases;`  
`>use e20210011437` // use database  
`>show tables;`

tables :  
clients  
produits  
commandes --> clients  
lignescommandes --> commandes, produits  
`>describe tableName;` // show structure de table  

produits.sql  
`CREATE TABLE IF NOT EXISTS produits`  
`>source produits.sql;` import script, mise a jour, create table
`>select * from produits` afficher les tuples, les donees

database centrale, php peut etre local  
pdo  

Lancer php server dans le dossier where se trouve le code de php. 
php -S localhost:8887  

selection de produits --> produits  
connexion et creation de compte --> clients  
creation de commandes --> commandes(etat 0 1) et lignescommandes  

%like  

categorie  
marque  
nom de produits  
prix max  
mots clefs  
synchro  
js  

localhost:8887/rechercheProduitsGenerique.php

if a server already execute
`>ps -edf`
`>ps -edf | grep php`
`>kill -9 60078`

https://phpmyadmin.etu.umontpellier.fr/index.php?server=2  
e20210011437  
sunying  
mysql...

formulaire HTML, php dans action de form (modifier du script rechercheProduits.php)  
    marque (listes deroulantes)  
    categorie (liste deroulantes)  
    prix max (zone de saisi)  
.HTML  
.php valeur de database dynamique   

 auto-increment

système
 bash 

 javascript

Comment mémoriser des informations sur la navigation sans être obligé de les sauver en BD ? 
- (plus utilisé) cookies : côté client
- session : côté serveur, géré par le serveur HTTP
``
<?php session_start();?>
``
Au début de tous les scriipts php qui vont utilisé la session (càd avant <html>)

- mise à disposition du tableau superglobal
$_session['mail] = ...; 
$mail = $_session['mail']; 
$_GET 
$_POST
