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

