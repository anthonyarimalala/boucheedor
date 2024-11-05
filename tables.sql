CREATE TABLE categories(
   id SERIAL PRIMARY KEY,
   categorie VARCHAR(30) NOT NULL,
   type_categorie VARCHAR(30) NOT NULL, -- ingredients, produits, non_consommables
   description TEXT,
   is_default INTEGER,
   created_at TIMESTAMP,
   updated_at TIMESTAMP
);
CREATE TABLE sous_categories(
    id_categorie INTEGER REFERENCES categories(id),
    id_sous_categorie INTEGER REFERENCES categories(id),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
CREATE TABLE unites(
   unite VARCHAR(20) PRIMARY KEY,
   signification VARCHAR(20) NOT NULL,
   created_at TIMESTAMP,
   updated_at TIMESTAMP
);
CREATE TABLE emplacements(
     id SERIAL PRIMARY KEY,
     emplacement VARCHAR(100), -- misy neutre anze zavatra vao amboarina
     ordre INTEGER,
     created_at TIMESTAMP,
     updated_at TIMESTAMP
);
CREATE TABLE l_emplacement_type_categories(
    id_emplacement INTEGER REFERENCES emplacements(id),
    type_categorie VARCHAR(30)
);

CREATE TABLE produits(
  code VARCHAR(20) PRIMARY KEY ,
  nom VARCHAR(255),
  description TEXT,
  id_categorie INTEGER REFERENCES categories(id),
  unite VARCHAR(20) REFERENCES unites(unite),
  seuil_reapprovisionnement DECIMAL(10, 2),
  transformation_locale INTEGER, -- (0 pour non, 1 pour oui)
  est_stockable INTEGER, -- (0 pour non, 1 pour oui), les plats préparés instantanéments sont non-stockable
  duree_limite INTEGER, -- nombre de date maximal pour stocker le produit
  type_sortie VARCHAR(4), -- fifo lifo
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
CREATE TABLE l_produit_ingredients(
  code_produit VARCHAR(20) REFERENCES produits(code),
  ingredient_code_produit VARCHAR(20) REFERENCES produits(code),
  quantite DECIMAL(10, 2),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
CREATE TABLE raison_mouvements(
  id INTEGER PRIMARY KEY ,
  type_raison VARCHAR(6),
  raison VARCHAR(255)
);
CREATE TABLE mouvements(
  id SERIAL PRIMARY KEY,
  code_produit VARCHAR(20) REFERENCES produits(code),
  id_emplacement INTEGER REFERENCES emplacements(id),
  entree DECIMAL(10, 2),
  sortie DECIMAL(10, 2),
  reference_sortie INTEGER,
  prix_unitaire DECIMAL(10, 2),
  date_mouvement TIMESTAMP,
  id_raison INTEGER REFERENCES raison_mouvements(id),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
CREATE TABLE notifications(
                              id SERIAL PRIMARY KEY,
                              code_produit VARCHAR(20),
                              produit VARCHAR,
                              titre VARCHAR(255),
                              description TEXT,
                              lien VARCHAR(255),
                              date_notification TIMESTAMP,
                              couleur VARCHAR,
                              montrer INTEGER,
                              created_at TIMESTAMP,
                              updated_at TIMESTAMP
);

CREATE SEQUENCE code_produit_seq;
CREATE SEQUENCE code_ingredient_seq;
CREATE SEQUENCE code_non_consommable_seq;


