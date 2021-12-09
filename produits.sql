CREATE TABLE IF NOT EXISTS produits (
  numProduit int NOT NULL PRIMARY KEY,
  catégorie enum('téléphone', 'tablette', 'écouteurs'),
  nom varchar(50) NOT NULL DEFAULT '',
  marque varchar(50) NOT NULL DEFAULT '',
  prix float
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO produits (numProduit, catégorie, nom, marque, prix) VALUES
(1, 'téléphone', 'Galaxy A20', 'Samsung', 155),
(2, 'téléphone', 'Galaxy S10E', 'Samsung', 499.99),
(3, 'téléphone', 'iPhone X', 'Apple', 729),
(4, 'tablette', 'Oxygen', 'Archos', 169),
(5, 'tablette', 'iPad Air 2', 'Apple', 199),
(6, 'écouteurs', 'airPods 2', 'Apple', 179);

CREATE TABLE IF NOT EXISTS  clients (
 email varchar(30) NOT NULL PRIMARY KEY,
 motdepasse varchar(15) NOT NULL,
 nom varchar(15),
 prenom varchar(15),
 ville varchar(15),
 adresse varchar(20),
 telephone int(10));

INSERT INTO clients (email, motdepasse, nom, prenom, ville, adresse, telephone) VALUES
('test', 'passe', 'lola', 'musslin', 'nice', 'ch.desoliviers', 0600000000);

CREATE TABLE IF NOT EXISTS commandes (
 idCommande int(5) NOT NULL PRIMARY KEY,
 calendrier date,
 email varchar(30), FOREIGN KEY (email) REFERENCES clients(email) ON DELETE CASCADE);

INSERT INTO commandes (idCommande, calendrier, email) VALUES
(1, 20200101, 'test');

CREATE TABLE IF NOT EXISTS lignescommandes (
  idlignecommandes int(5) NOT NULL,
  idCommande int(5), FOREIGN KEY(idCommande) REFERENCES commandes(idCommande) ON DELETE CASCADE,
  idProduit INT, FOREIGN KEY(idProduit) REFERENCES produits(numProduit) ON DELETE CASCADE,
  quantité int(3), 
  montant float(5.2),
  constraint lcPK (idlignecommandes, idCommande)
  );


  INSERT INTO lignescommandes (idlignecommandes, idCommande, idProduit, quantité, montant) VALUES
   (1,1,2,2,999.98);

  
