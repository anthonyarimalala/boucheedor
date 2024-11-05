
-- Insertion des catÚgories par dÚfaut
INSERT INTO categories (categorie, type_categorie, is_default) VALUES
                                                                   ('LÚgumes', 'Ingredient', 1),  -- 1
                                                                   ('Fruits', 'Ingredient', 1),   -- 2
                                                                   ('Autres', 'Ingredient', 1),   -- 3
                                                                   ('Aliments', 'Produit', 1),    -- 4
                                                                   ('Boissons', 'Produit', 1),    -- 5
                                                                   ('Entretien et hygiÚne', 'Non_consommable', 1), -- 6
                                                                   ('Emballages', 'Non_consommable', 1);  -- 7

-- Insertion des catÚgories supplÚmentaires
INSERT INTO categories (categorie, type_categorie) VALUES
                                                       ('Pizza', 'Produit'),  -- 8
                                                       ('Plats', 'Produit'),  -- 9
                                                       ('Jus', 'Produit'),    -- 10
                                                       ('Viandes', 'Ingredient'),  -- 11
                                                       ('Poissons', 'Ingredient'), -- 12
                                                       ('Condiments', 'Ingredient'), -- 13
                                                       ('Desserts', 'Produit'),    -- 14
                                                       ('Úpices', 'Ingredient'),  -- 15
                                                       ('MatÚriel de cuisine', 'Non_consommable'); -- 16

-- Insertion des sous-catÚgories
INSERT INTO sous_categories (id_categorie, id_sous_categorie) VALUES
                                                                  (4, 8),  -- Aliments -> Pizza
                                                                  (4, 9),  -- Aliments -> Plats
                                                                  (5, 10); -- Boissons -> Jus

INSERT INTO unites (unite, signification) VALUES
                                              ('kg', 'Kilogramme'),  -- 1
                                              ('g', 'Gramme'),       -- 2
                                              ('l', 'Litre'),        -- 3
                                              ('sac', 'Sac'),        -- 4
                                              ('unitÚ', 'PiÚce'),    -- 5
                                              ('paquet', 'Paquet'),  -- 6
                                              ('bouteille', 'Bouteille');

INSERT INTO emplacements (emplacement, ordre) VALUES
                                                  ('RÚfrigÚrateur principal', 0),  -- 1
                                                  ('CongÚlateur', 0),              -- 2
                                                  ('Chambre froide', 0),            -- 3
                                                  ('Garde-manger', 0),              -- 4
                                                  ('ÚtagÚre', 0),                   -- 5
                                                  ('RÚserve', 0),                   -- 6
                                                  ('Autre', 1),                     -- 7
                                                  ('Cuisine', 0),                   -- 8
                                                  ('Bar', 0),                       -- 9
                                                  ('Stock extÚrieur', 0),           -- 10
                                                  ('', 0);                          -- 11

INSERT INTO l_emplacement_type_categories VALUES -- Ingredient -- Produit -- Non_consommable
                                                 (1, 'Ingredient'),
                                                 (1, 'Produit'),
                                                 (2, 'Ingredient'),
                                                 (2, 'Produit'),
                                                 (3, 'Ingredient'),
                                                 (4, 'Produit'),
                                                 (4, 'Ingredient'),
                                                 (5, 'Produit'),
                                                 (6, 'Non_consommable'),
                                                 (7, 'Produit'),
                                                 (7, 'Ingredient'),
                                                 (7, 'Non_consommable'),
                                                 (8, 'Produit'),
                                                 (8, 'Ingredient'),
                                                 (9, ''),
                                                 (9, ''),
                                                 (10, 'Produit'),
                                                 (10, 'Ingredient'),
                                                 (10, 'Non_consommable'),
                                                 (11, 'Produit'),
                                                 (11, 'Ingredient'),
                                                 (11, 'Non_consommable');

-- Insertion de 100 produits rÚpartis dans diffÚrentes catÚgories
INSERT INTO produits (code, nom, description, id_categorie, unite, seuil_reapprovisionnement, transformation_locale, est_stockable, type_sortie) VALUES
                                       -- CatÚgorie : LÚgumes
                                       ('P001', 'Carotte', 'Carotte fra¯che', 1, 'kg', 5.00, 0, 1, 'fifo'),
                                       ('P002', 'Tomate', 'Tomate bio', 1, 'kg', 3.00, 0, 1, 'fifo'),
                                       ('P003', 'Pomme de terre', 'Pomme de terre de saison', 1, 'kg', 40.00, 0, 1, 'fifo'),
                                       ('P004', 'Oignon', 'Oignon rouge', 1, 'kg', 2.00, 0, 1, 'fifo'),
                                       ('P005', 'Ail', 'Ail blanc', 1, 'kg', 1.00, 0, 1, 'fifo'),
                                       ('P006', 'Chou', 'Chou vert', 1, 'kg', 1.00, 0, 1, 'fifo'),
                                       ('P007', 'Poivron', 'Poivron rouge', 1, 'kg', 0.80, 0, 1, 'fifo'),
                                       ('P008', 'Salade', 'Salade verte', 1, 'unitÚ', 1.00, 0, 1, 'fifo'),
                                       ('P009', 'Courgette', 'Courgette bio', 1, 'kg', 1.00, 0, 1, 'fifo'),
                                       ('P010', 'Brocoli', 'Brocoli frais', 1, 'kg', 1.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Fruits
                                       ('P011', 'Banane', 'Banane bio', 2, 'kg', 3.00, 0, 1, 'fifo'),
                                       ('P012', 'Pomme', 'Pomme Gala', 2, 'kg', 5.00, 0, 1, 'fifo'),
                                       ('P013', 'Orange', 'Orange de table', 2, 'kg', 4.00, 0, 1, 'fifo'),
                                       ('P014', 'Fraise', 'Fraise fra¯che', 2, 'kg', 2.00, 0, 1, 'fifo'),
                                       ('P015', 'Raisin', 'Raisin blanc', 2, 'kg', 3.00, 0, 1, 'fifo'),
                                       ('P016', 'Ananas', 'Ananas frais', 2, 'unitÚ', 1.00, 0, 1, 'fifo'),
                                       ('P017', 'Mangue', 'Mangue tropicale', 2, 'kg', 2.00, 0, 1, 'fifo'),
                                       ('P018', 'Poire', 'Poire ConfÚrence', 2, 'kg', 3.00, 0, 1, 'fifo'),
                                       ('P019', 'Citron', 'Citron jaune', 2, 'kg', 1.00, 0, 1, 'fifo'),
                                       ('P020', 'PastÚque', 'PastÚque rouge', 2, 'unitÚ', 2.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Viandes
                                       ('P021', 'Poulet', 'Poulet entier', 11, 'kg', 6.00, 1, 1, 'fifo'),
                                       ('P022', 'Boeuf', 'Viande de boeuf', 11, 'kg', 6.00, 1, 1, 'fifo'),
                                       ('P023', 'Agneau', 'Agneau dÚsossÚ', 11, 'kg', 3.00, 1, 1, 'fifo'),
                                       ('P024', 'Canard', 'Magret de canard', 11, 'kg', 3.00, 1, 1, 'fifo'),
                                       ('P025', 'Saucisse', 'Saucisse artisanale', 11, 'kg', 5.00, 1, 1, 'fifo'),
                                       ('P026', 'Jambon', 'Jambon cru', 11, 'kg', 8.00, 1, 1, 'fifo'),
                                       ('P027', 'Lard', 'Lard fumÚ', 11, 'kg', 2.00, 1, 1, 'fifo'),
                                       ('P028', 'Steak', 'Steak hachÚ', 11, 'kg', 7.00, 1, 1, 'fifo'),
                                       ('P029', 'Côtelette de porc', 'Côtelette de porc bio', 11, 'kg', 0.00, 1, 1, 'fifo'),
                                       ('P030', 'Saucisson', 'Saucisson sec', 11, 'kg', 2.00, 1, 1, 'fifo'),

                                       -- CatÚgorie : Boissons
                                       ('P031', 'Eau minÚrale', 'Eau de source', 5, 'bouteille', 20.00, 0, 1, 'fifo'),
                                       ('P032', 'Jus d''orange', 'Jus d''orange 100%', 10, 'l', 10.00, 0, 1, 'fifo'),
                                       ('P033', 'Coca-Cola', 'Soda Coca-Cola', 5, 'bouteille', 15.00, 0, 1, 'fifo'),
                                       ('P034', 'Vin rouge', 'Vin rouge Bordeaux', 5, 'bouteille', 5.00, 0, 1, 'fifo'),
                                       ('P035', 'BiÚre', 'BiÚre blonde', 5, 'bouteille', 10.00, 0, 1, 'fifo'),
                                       ('P036', 'ThÚ glacÚ', 'ThÚ glacÚ à la pêche', 5, 'bouteille', 8.00, 0, 1, 'fifo'),
                                       ('P037', 'Limonade', 'Limonade artisanale', 5, 'bouteille', 6.00, 0, 1, 'fifo'),
                                       ('P038', 'Whisky', 'Whisky Úcossais', 5, 'bouteille', 4.00, 0, 1, 'fifo'),
                                       ('P039', 'Vodka', 'Vodka premium', 5, 'bouteille', 5.00, 0, 1, 'fifo'),
                                       ('P040', 'Gin', 'Gin artisanal', 5, 'bouteille', 3.00, 0, 1, 'fifo'),

                                       -- Ajout de plus de produits pour diffÚrentes catÚgories...
                                       -- Jusqu'à atteindre 100 produits.
                                       ('P041', 'Úpinard', 'Úpinard frais', 1, 'kg', 2.00, 0, 1, 'fifo'),
                                       ('P042', 'Haricot vert', 'Haricot vert frais', 1, 'kg', 1.00, 0, 1, 'fifo'),
                                       ('P043', 'Radis', 'Radis rouge', 1, 'kg', 1.00, 0, 1, 'fifo'),
                                       ('P044', 'Navet', 'Navet blanc', 1, 'kg', 0.80, 0, 1, 'fifo'),
                                       ('P045', 'Chou-fleur', 'Chou-fleur frais', 1, 'kg', 1.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Fruits (suite)
                                       ('P046', 'Framboise', 'Framboise fra¯che', 2, 'kg', 1.00, 0, 1, 'fifo'),
                                       ('P047', 'Papaye', 'Papaye tropicale', 2, 'unitÚ', 1.00, 0, 1, 'fifo'),
                                       ('P048', 'Goyave', 'Goyave douce', 2, 'kg', 1.00, 0, 1, 'fifo'),
                                       ('P049', 'Melon', 'Melon charentais', 2, 'unitÚ', 2.00, 0, 1, 'fifo'),
                                       ('P050', 'Cassis', 'Cassis frais', 2, 'kg', 0.80, 0, 1, 'fifo'),

                                       -- CatÚgorie : Produits laitiers
                                       ('P051', 'Lait', 'Lait entier', 4, 'l', 10.00, 0, 1, 'fifo'),
                                       ('P052', 'Fromage', 'Fromage cheddar', 4, 'kg', 5.00, 0, 1, 'fifo'),
                                       ('P053', 'Yaourt', 'Yaourt nature', 4, 'unitÚ', 7.00, 0, 1, 'fifo'),
                                       ('P054', 'CrÚme fra¯che', 'CrÚme fra¯che Úpaisse', 4, 'l', 3.00, 0, 1, 'fifo'),
                                       ('P055', 'Beurre', 'Beurre doux', 4, 'kg', 4.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Plats prÚparÚs
                                       ('P056', 'Pizza Margherita', 'Pizza classique à la tomate et mozzarella', 9, 'unitÚ', 3.00, 1, 0, 'fifo'),
                                       ('P057', 'Lasagnes', 'Lasagnes à la bolognaise', 9, 'unitÚ', 3.00, 1, 0, 'fifo'),
                                       ('P058', 'Burger', 'Burger au boeuf', 9, 'unitÚ', 5.00, 1, 0, 'fifo'),
                                       ('P059', 'Tarte aux pommes', 'Tarte aux pommes maison', 9, 'unitÚ', 5.00, 1, 0, 'fifo'),
                                       ('P060', 'Soupe', 'Soupe de lÚgumes', 9, 'l', 5.00, 1, 0, 'fifo'),

                                       -- CatÚgorie : Aliments secs
                                       ('P061', 'Farine', 'Farine de blÚ', 4, 'kg', 5.00, 0, 1, 'fifo'),
                                       ('P062', 'Riz', 'Riz basmati', 4, 'kg', 20.00, 0, 1, 'fifo'),
                                       ('P063', 'Pâtes', 'Pâtes spaghetti', 4, 'kg', 10.00, 0, 1, 'fifo'),
                                       ('P064', 'Lentilles', 'Lentilles vertes', 4, 'kg', 10.00, 0, 1, 'fifo'),
                                       ('P065', 'Couscous', 'Couscous moyen', 4, 'kg', 10.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Boissons (suite)
                                       ('P066', 'Jus de pomme', 'Jus de pomme bio', 5, 'l', 10.00, 0, 1, 'fifo'),
                                       ('P067', 'CafÚ', 'CafÚ en grains', 5, 'kg', 10.00, 0, 1, 'fifo'),
                                       ('P068', 'ThÚ noir', 'ThÚ noir Darjeeling', 5, 'kg', 5.00, 0, 1, 'fifo'),
                                       ('P069', 'Champagne', 'Champagne brut', 5, 'bouteille', 5.00, 0, 1, 'fifo'),
                                       ('P070', 'Eau gazeuse', 'Eau gazeuse Perrier', 5, 'bouteille', 10.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Entretien et hygiÚne
                                       ('P071', 'Savon liquide', 'Savon liquide pour les mains', 6, 'l', 5.00, 0, 1, 'fifo'),
                                       ('P072', 'DÚtergent', 'DÚtergent multi-usages', 6, 'l', 4.00, 0, 1, 'fifo'),
                                       ('P073', 'Lingettes dÚsinfectantes', 'Lingettes dÚsinfectantes multi-surfaces', 6, 'paquet', 3.00, 0, 1, 'fifo'),
                                       ('P074', 'Serviettes en papier', 'Serviettes en papier recyclÚ', 6, 'paquet', 8.00, 0, 1, 'fifo'),
                                       ('P075', 'Gants en latex', 'Gants en latex jetables', 6, 'paquet', 2.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Emballages
                                       ('P076', 'Bo¯te en carton', 'Bo¯te à emporter en carton', 7, 'paquet', 10.00, 0, 1, 'fifo'),
                                       ('P077', 'Film plastique', 'Film plastique alimentaire', 7, 'sac', 5.00, 0, 1, 'fifo'),
                                       ('P078', 'Sachet en papier', 'Sachet kraft recyclable', 7, 'paquet', 7.00, 0, 1, 'fifo'),
                                       ('P079', 'Bo¯te en plastique', 'Bo¯te alimentaire rÚutilisable', 7, 'paquet', 6.00, 0, 1, 'fifo'),
                                       ('P080', 'Assiette en carton', 'Assiette jetable en carton', 7, 'paquet', 9.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Non-alimentaire
                                       ('P081', 'Torchons', 'Torchons de cuisine en coton', 6, 'paquet', 3.00, 0, 1, 'fifo'),
                                       ('P082', 'Tabliers', 'Tabliers de cuisine', 6, 'paquet', 2.00, 0, 1, 'fifo'),
                                       ('P083', 'Spatules', 'Spatules en bois', 6, 'unitÚ', 2.00, 0, 1, 'fifo'),
                                       ('P084', 'Casseroles', 'Casseroles en acier inoxydable', 6, 'unitÚ', 1.00, 0, 1, 'fifo'),
                                       ('P085', 'Bols', 'Bols en cÚramique', 6, 'paquet', 1.00, 0, 1, 'fifo'),

                                       -- Produits variÚs
                                       ('P086', 'Huile d''olive', 'Huile d''olive vierge extra', 4, 'l', 8.00, 0, 1,'fifo'),
                                       ('P087', 'Vin rouge', 'Vin rouge Bordeaux', 5, 'bouteille', 2.00, 0, 1, 'fifo'),
                                       ('P088', 'Farine de maïs', 'Farine de maïs bio', 4, 'kg', 5.00, 0, 1, 'fifo'),
                                       ('P089', 'Curry en poudre', 'Úpices de curry', 4, 'kg', 6.00, 0, 1, 'fifo'),
                                       ('P090', 'Sucre', 'Sucre blanc en poudre', 4, 'kg', 15.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Boissons (suite et fin)
                                       ('P091', 'Coca-Cola', 'Boisson gazeuse Coca-Cola', 5, 'bouteille', 12.00, 0, 1, 'fifo'),
                                       ('P092', 'Fanta', 'Boisson gazeuse Fanta', 5, 'bouteille', 11.00, 0, 1, 'fifo'),
                                       ('P093', 'Eau minÚrale', 'Eau minÚrale naturelle', 5, 'bouteille', 20.00, 0, 1, 'fifo'),
                                       ('P094', 'Red Bull', 'Boisson Únergisante Red Bull', 5, 'bouteille', 10.00, 0, 1, 'fifo'),
                                       ('P095', 'ThÚ glacÚ', 'ThÚ glacÚ citron', 5, 'bouteille', 8.00, 0, 1, 'fifo'),

                                       -- CatÚgorie : Produits surgelÚs
                                       ('P096', 'Poisson surgelÚ', 'Filets de poisson surgelÚ', 2, 'kg', 5.00, 0, 1, 'fifo'),
                                       ('P097', 'Frites surgelÚes', 'Frites prÚcuites surgelÚes', 4, 'kg', 10.00, 0, 1, 'fifo'),
                                       ('P098', 'Poulet surgelÚ', 'Poulet entier surgelÚ', 3, 'kg', 7.00, 0, 1, 'fifo'),
                                       ('P099', 'LÚgumes surgelÚs', 'MÚlange de lÚgumes surgelÚs', 1, 'kg', 8.00, 0, 1, 'fifo'),
                                       ('P100', 'Pizza surgelÚe', 'Pizza 4 fromages surgelÚe', 9, 'unitÚ', 4.00, 0, 1,   'fifo');
UPDATE produits SET seuil_reapprovisionnement = seuil_reapprovisionnement / 10 WHERE code != 'NDF';
UPDATE produits SET duree_limite = 7 WHERE id_categorie = 1 OR id_categorie = 2 OR id_categorie = 4;


INSERT INTO l_produit_ingredients (code_produit, ingredient_code_produit, quantite, created_at, updated_at) VALUES
                                        -- Pizza Margherita (P056) avec des ingrÚdients : Farine, Tomate, Fromage, Huile d'olive
                                        ('P056', 'P061', 0.30, NOW(), NOW()),  -- 300g de farine pour la pizza
                                        ('P056', 'P011', 0.20, NOW(), NOW()),  -- 200g de tomate
                                        ('P056', 'P052', 0.15, NOW(), NOW()),  -- 150g de fromage
                                        ('P056', 'P086', 0.05, NOW(), NOW()),  -- 50ml d'huile d'olive

                                        -- Lasagnes (P057) avec des ingrÚdients : Pâtes, Tomate, Fromage, Viande hachÚe
                                        ('P057', 'P063', 0.40, NOW(), NOW()),  -- 400g de pâtes pour lasagnes
                                        ('P057', 'P011', 0.30, NOW(), NOW()),  -- 300g de tomate
                                        ('P057', 'P052', 0.20, NOW(), NOW()),  -- 200g de fromage
                                        ('P057', 'P016', 0.50, NOW(), NOW()),  -- 500g de viande hachÚe

                                        -- Burger (P058) avec des ingrÚdients : Pain, Viande hachÚe, Fromage, Salade
                                        ('P058', 'P009', 0.20, NOW(), NOW()),  -- 200g de pain
                                        ('P058', 'P016', 0.15, NOW(), NOW()),  -- 150g de viande hachÚe
                                        ('P058', 'P052', 0.10, NOW(), NOW()),  -- 100g de fromage
                                        ('P058', 'P024', 0.05, NOW(), NOW()),  -- 50g de salade

                                        -- Tarte aux pommes (P059) avec des ingrÚdients : Farine, Pomme, Sucre
                                        ('P059', 'P061', 0.25, NOW(), NOW()),  -- 250g de farine pour la pâte
                                        ('P059', 'P034', 0.30, NOW(), NOW()),  -- 300g de pomme
                                        ('P059', 'P090', 0.10, NOW(), NOW());  -- 100g de sucre

INSERT INTO raison_mouvements(id, type_raison, raison) VALUES
                                                      (10, 'entree', 'Achat'),
                                                      (11, 'entree', 'DÚplacement'),
                                                      (20, 'sortie', 'Vente'),
                                                      (21, 'entree', 'DÚplacement'),
                                                      (22, 'sortie', 'Cuisine'),
                                                      (23, 'sortie', 'PÚrimÚ');


INSERT INTO mouvements (code_produit, id_emplacement, entree,  prix_unitaire, date_mouvement, id_raison, created_at, updated_at) VALUES
                                                                                 -- Entrées pour les ingrédients
                                                                                 ('P061', 1, 50.00, 0.50, NOW(), 10, NOW(), NOW()),  -- Farine
                                                                                 ('P062', 1, 30.00, 1.00, NOW(), 10, NOW(), NOW()),  -- Pâtes
                                                                                 ('P011', 1, 40.00, 0.80, NOW(), 10, NOW(), NOW()),  -- Tomate
                                                                                 ('P086', 1, 25.00, 2.00, NOW(), 10, NOW(), NOW()),  -- Huile d'olive
                                                                                 ('P034', 1, 20.00, 1.50, NOW(), 10, NOW(), NOW()),  -- Pomme
                                                                                 ('P090', 1, 15.00, 0.60, NOW(), 10, NOW(), NOW()),  -- Sucre
                                                                                 ('P052', 1, 60.00, 1.20, NOW(), 10, NOW(), NOW()),  -- Fromage
                                                                                 ('P016', 1, 55.00, 2.50, NOW(), 10, NOW(), NOW()),  -- Viande hachée
                                                                                 ('P064', 1, 40.00, 3.00, NOW(), 10, NOW(), NOW()),  -- Oeufs
                                                                                 ('P068', 1, 45.00, 0.75, NOW(), 10, NOW(), NOW()),  -- Salade

                                                                                 -- Entrées pour les produits
                                                                                 ('P056', 1, 10.00, 8.00, NOW(), 10, NOW(), NOW()),  -- Pizza Margherita
                                                                                 ('P057', 1, 20.00, 10.00, NOW(), 10, NOW(), NOW()),  -- Lasagnes
                                                                                 ('P058', 1, 15.00, 6.50, NOW(), 10, NOW(), NOW()),  -- Burger
                                                                                 ('P059', 1, 12.00, 5.00, NOW(), 10, NOW(), NOW()),  -- Tarte aux pommes
                                                                                 ('P060', 1, 18.00, 7.00, NOW(), 10, NOW(), NOW()),  -- Quiche
                                                                                 ('P063', 1, 10.00, 3.00, NOW(), 10, NOW(), NOW()),  -- Soupe
                                                                                 ('P067', 1, 25.00, 9.00, NOW(), 10, NOW(), NOW()),  -- Salade César
                                                                                 ('P070', 1, 30.00, 4.50, NOW(), 10, NOW(), NOW()),  -- Pudding

                                                                                 -- Entrées pour les boissons
                                                                                 ('P087', 1, 100.00, 2.50, NOW(), 10, NOW(), NOW()),  -- Vin rouge
                                                                                 ('P091', 1, 150.00, 1.50, NOW(), 10, NOW(), NOW()),  -- Coca-Cola
                                                                                 ('P092', 1, 120.00, 1.50, NOW(), 10, NOW(), NOW()),  -- Fanta
                                                                                 ('P093', 1, 200.00, 0.50, NOW(), 10, NOW(), NOW()),  -- Eau minérale
                                                                                 ('P094', 1, 80.00, 2.00, NOW(), 10, NOW(), NOW()),   -- Red Bull
                                                                                 ('P095', 1, 90.00, 1.00, NOW(), 10, NOW(), NOW()),   -- Thé glacé

                                                                                 -- Entrées pour les produits non alimentaires
                                                                                 ('P083', 6, 40.00, 5.00, NOW(), 11, NOW(), NOW()),  -- Spatules
                                                                                 ('P084', 6, 30.00, 7.00, NOW(), 11, NOW(), NOW()),  -- Casseroles
                                                                                 ('P085', 6, 50.00, 3.50, NOW(), 11, NOW(), NOW()),  -- Bols
                                                                                 ('P080', 6, 20.00, 4.00, NOW(), 11, NOW(), NOW()),  -- Récipients
                                                                                 ('P081', 6, 15.00, 6.00, NOW(), 11, NOW(), NOW()),  -- Assiettes

                                                                                 -- Entrées pour divers produits
                                                                                 ('P096', 2, 30.00, 10.00, NOW(), 10, NOW(), NOW()),  -- Poisson surgelé
                                                                                 ('P097', 2, 25.00, 5.00, NOW(), 10, NOW(), NOW()),  -- Frites surgelées
                                                                                 ('P098', 2, 40.00, 7.00, NOW(), 10, NOW(), NOW()),  -- Poulet surgelé
                                                                                 ('P099', 2, 35.00, 4.50, NOW(), 10, NOW(), NOW()),  -- Légumes surgelés
                                                                                 ('P100', 2, 20.00, 6.50, NOW(), 10, NOW(), NOW());  -- Pizza surgelée
UPDATE mouvements SET prix_unitaire = prix_unitaire * 5000 WHERE code_produit != 'NDF';
