DROP VIEW v_emplacements;
DROP VIEW v_mouvements;
DROP VIEW v_stocks;
DROP VIEW v_produits;
DROP VIEW v_mouvement_inventaire_details;
DROP VIEW v_mouvement_inventaire_diagramme_produit_ingredients;
DROP VIEW v_mouvement_inventaire_detail_diagrammes;

DROP TABLE notifications;
DROP TABLE mouvements;
DROP TABLE raison_mouvements;
DROP TABLE l_produit_ingredients;
DROP TABLE produits;
DROP TABLE l_emplacement_type_categories;
DROP TABLE emplacements;
DROP TABLE unites;
DROP TABLE sous_categories;
DROP TABLE categories;

DROP SEQUENCE code_produit_seq;
DROP SEQUENCE code_ingredient_seq;
DROP SEQUENCE code_non_consommable_seq;


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


CREATE VIEW v_produits AS
SELECT
    p.code ,
    p.nom ,
    p.description ,
    p.id_categorie ,
    c.categorie ,
    c.type_categorie ,
    p.unite ,
    p.seuil_reapprovisionnement ,
    p.transformation_locale , -- (0 pour non, 1 pour oui)
    p.est_stockable , -- (0 pour non, 1 pour oui), les plats préparés instantanéments sont non-stockable
    p.duree_limite , -- nombre de date maximal pour stocker le produit
    p.type_sortie , -- fifo lifo
    p.created_at
FROM produits p
         JOIN categories c ON p.id_categorie = c.id ;

-- Controller/Mouvement/SortieController
-- -- createPageSortieIngredient
-- Cette vue ne prend en charge que les produits en stock en ce moment
CREATE OR REPLACE VIEW v_stocks AS
SELECT
    m.code_produit,
    v_p.nom,
    AVG(m.prix_unitaire) as prix_unitaire,
    v_p.id_categorie,
    v_p.categorie,
    v_p.type_categorie,
    v_p.type_sortie,
    m.id_emplacement,
    e.emplacement,
    SUM(m.entree) - SUM(COALESCE(m.sortie, 0)) AS reste,
    v_p.unite,
    (SUM(m.entree) - SUM(COALESCE(m.sortie, 0))) * SUM(m.prix_unitaire)  AS prix_total
FROM mouvements m
         JOIN v_produits v_p ON m.code_produit = v_p.code
         JOIN emplacements e ON m.id_emplacement = e.id
GROUP BY m.code_produit, v_p.nom, v_p.id_categorie, v_p.categorie, v_p.type_categorie, v_p.type_sortie, m.id_emplacement, e.emplacement, v_p.unite;

-- Cette vue mets n'a pas de ligne de sortie mais tout de suite le reste en stock du produit
-- Controllers/Inventaire/InventaireController
CREATE OR REPLACE VIEW v_mouvements AS
SELECT
    m.id,
    m.code_produit,
    p.nom,
    m.id_emplacement,
    e.emplacement,
    m.entree,
    m.entree - COALESCE((SELECT SUM(COALESCE(m_r.sortie,0)) FROM mouvements m_r WHERE m_r.reference_sortie = m.id),0) AS reste_en_stock,
    ((m.entree - COALESCE((SELECT SUM(COALESCE(m_r.sortie,0)) FROM mouvements m_r WHERE m_r.reference_sortie = m.id),0))/m.entree)*100 AS pourcentage,
    m.reference_sortie,
    m.prix_unitaire,
    m.prix_unitaire * (m.entree - COALESCE((SELECT SUM(COALESCE(m_r.sortie,0)) FROM mouvements m_r WHERE m_r.reference_sortie = m.id),0)) AS prix_total,
    m.date_mouvement,
    m.id_raison,
    p.unite,
    p.duree_limite,
    p.seuil_reapprovisionnement,
    c.categorie,
    c.type_categorie
FROM mouvements m
         JOIN produits p ON m.code_produit = p.code
         JOIN categories c ON p.id_categorie = c.id
         JOIN emplacements e ON m.id_emplacement = e.id
WHERE m.entree IS NOT null;

CREATE VIEW v_emplacements AS
SELECT
    e.*,
    let.type_categorie
FROM emplacements e
         JOIN l_emplacement_type_categories let ON e.id = let.id_emplacement;



-- Pour montrer quelques détails au dessous de la diagramme
CREATE VIEW v_mouvement_inventaire_details AS
SELECT
    m.code_produit,
    p.nom,
    m.entree,
    m.sortie,
    p.unite,
    (SELECT SUM(COALESCE(entree, 0) - COALESCE(sortie, 0)) FROM mouvements mr WHERE mr.code_produit=m.code_produit AND mr.date_mouvement <= m.date_mouvement) AS stock,
    m.date_mouvement
FROM mouvements m
         JOIN produits p ON m.code_produit = p.code;

-- Pour montrer le diagramme
CREATE OR REPLACE VIEW v_mouvement_inventaire_detail_diagrammes AS
SELECT code_produit, nom, stock, unite, date FROM (SELECT
    m.code_produit,
    p.nom,
    p.unite,
    (SELECT SUM(COALESCE(entree, 0) - COALESCE(sortie, 0)) FROM mouvements mr WHERE mr.code_produit=m.code_produit AND DATE(mr.date_mouvement) <= DATE(m.date_mouvement)) AS stock,
    DATE(m.date_mouvement)
    FROM mouvements m
    JOIN produits p ON m.code_produit = p.code
    GROUP BY m.code_produit, p.nom, p.unite, m.date_mouvement, DATE(m.date_mouvement)) GROUP BY code_produit, nom, stock, unite, date;

-- Pour montrer les produits faits à partir des ingrédients à un moment donné
CREATE VIEW v_mouvement_inventaire_diagramme_produit_ingredients AS
SELECT
    m.code_produit,
    pp.nom,
    pp.unite,
    pl.ingredient_code_produit,
    pi.nom AS ingredient,
    SUM(m.entree) AS entrees,
    pi.unite AS unite_ingredient,
    DATE(m.date_mouvement)
    FROM mouvements m
    JOIN l_produit_ingredients pl ON m.code_produit = pl.code_produit
    JOIN produits pp ON m.code_produit = pp.code
    JOIN produits pi ON pl.ingredient_code_produit = pi.code
    GROUP BY DATE(m.date_mouvement), m.code_produit, pp.nom, pp.unite, pi.unite, pl.ingredient_code_produit, pi.nom;

-- Insertion des catÚgories par dÚfaut
INSERT INTO categories (categorie, type_categorie, is_default) VALUES
                                                                   ('LÚgumes', 'Ingredient', 1),
                                                                   ('Fruits', 'Ingredient', 1),
                                                                   ('Produits laitier', 'Ingredient', 1),
                                                                   ('Aliments', 'Produit', 1),
                                                                   ('Boissons', 'Produit', 1),
                                                                   ('Entretien et hygiÚne', 'Non_consommable', 1),
                                                                   ('Emballages', 'Non_consommable', 1);

INSERT INTO categories (categorie, type_categorie) VALUES
                                                                   ('Pizza', 'Produit'),  -- 8
                                                                   ('Plats', 'Produit'),  -- 9
                                                                   ('Jus', 'Produit'),    -- 10
                                                                   ('Viandes', 'Ingredient'),  -- 11
                                                                   ('Poissons', 'Ingredient'), -- 12
                                                                   ('Condiments', 'Ingredient'), -- 13
                                                                   ('Desserts', 'Produit'),    -- 14
                                                                   ('Úpices', 'Ingredient'),  -- 15
                                                                   ('MatÚriel de cuisine', 'Non_consommable'),
                                                                   ('Autre', 'Produit'),
                                                                   ('Autre', 'Ingredient'),
                                                                   ('Autre', 'Non_consommable'); -- 16
;
INSERT INTO unites (unite, signification) VALUES
                                              ('kg', 'Kilogramme'),
                                              ('g', 'Gramme'),
                                              ('l', 'Litre'),
                                              ('unitÚ', 'PiÚce'),
                                              ('paquet', 'Paquet'),
                                              ('bouteille', 'Bouteille');

INSERT INTO emplacements (emplacement, ordre) VALUES
                                                  ('RÚfrigÚrateur principal', 0),   -- 1
                                                  ('CongÚlateur', 0),               -- 2
                                                  ('Chambre froide', 0),            -- 3
                                                  ('ÚtagÚre', 0),                   -- 4
                                                  ('RÚserve', 0),                   -- 5
                                                  ('Autre', 1),                     -- 6
                                                  ('Cuisine', 0),                   -- 7
                                                  ('Stock extÚrieur', 0),           -- 8
                                                ('', 1);

INSERT INTO l_emplacement_type_categories VALUES -- Ingredient -- Produit -- Non_consommable
                                                 (1, 'Ingredient'),
                                                 (1, 'Produit'),
                                                 (2, 'Ingredient'),
                                                 (2, 'Produit'),
                                                 (3, 'Ingredient'),
                                                 (3, 'Produit'),
                                                 (4, 'Produit'),
                                                 (5, 'Non_consommable'),
                                                 (6, 'Ingredient'),
                                                 (6, 'Produit'),
                                                 (6, 'Non_consommable'),
                                                 (7, 'Ingredient'),
                                                 (8, 'Produit'),
                                                 (8, 'Ingredient'),
                                                 (8, 'Non_consommable');

INSERT INTO raison_mouvements(id, type_raison, raison) VALUES
                                                           (10, 'entree', 'Achat'),
                                                           (11, 'entree', 'DÚplacement'),
                                                           (20, 'sortie', 'Vente'),
                                                           (21, 'entree', 'DÚplacement'),
                                                           (22, 'sortie', 'Cuisine'),
                                                           (23, 'sortie', 'PÚrimÚ');

