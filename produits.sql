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
