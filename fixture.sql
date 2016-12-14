/*
Création de base de donnée
createdb BlasBontouxEntrepots
*/

drop view if exists vueentrepot;
drop view if exists vuesalle;
drop view if exists vuepalette;
drop table if exists Lot;
drop table if exists Palette;
drop table if exists Salle;
drop table if exists Produit;

create table Salle
        (numero varchar PRIMARY KEY,
        capacite numeric(10,0) NOT NULL,
        temperature numeric(10,0) NOT NULL);

create table Palette
        (codepa varchar PRIMARY KEY,
        lieu varchar REFERENCES Salle);

create table Produit
        (codepr varchar PRIMARY KEY,
        libelle varchar NOT NULL,
        temperaturemin numeric(10,0) NOT NULL,
        temperaturemax numeric(10,0) NOT NULL);

create table Lot
        (support varchar REFERENCES Palette,
        produit varchar REFERENCES Produit,
        quantite varchar NOT NULL,
        PRIMARY KEY(support, produit));

/* Lignes de la table correctes */

insert into Salle VALUES ('1', 1,20);
insert into Salle VALUES ('2', 5,10);
insert into Salle VALUES ('3', 15,22);
insert into Salle VALUES ('4', 3,150);


insert into Palette VALUES ('P1', NULL);
insert into Palette VALUES ('P2', '3');
insert into Palette VALUES ('P3', '3');
insert into Palette VALUES ('P4', '1');

insert into Produit VALUES ('pr1','Algue',5,15);
insert into Produit VALUES ('pr2','Chocolat',5,25);
insert into Produit VALUES ('pr3','Pomme',-1,1);
insert into Produit VALUES ('pr4','Kangourou',0,20);

insert into Lot VALUES ('P2','pr2','121');
insert into Lot VALUES ('P2','pr4','15');
insert into Lot VALUES ('P1','pr3','1');
insert into Lot VALUES ('P3','pr4','10');
insert into Lot VALUES ('P4','pr2','157348');

/* Service 1 :
 * On liste simplement les salles
 * de tout l'entrepot et on donne leur
 * champs numero, temperature et capacité
 */
CREATE VIEW VueEntrepot AS SELECT
numero, temperature, capacite FROM Salle
ORDER BY temperature ASC, capacite DESC;

/* Service 2
 * On liste tous les lots, en donnant leur quantité et les
 * informations sur le produit associé (temperaturemin, temperaturemax,
 * codepr, libelle (ce n'était pas demandé mais c'est plus ludique)).
 * On renvoie aussi pour chaque lot le code de la palette associée (codepa),
 * champ selon lequel la requête est triée afin de pouvoir regrouper par palette
 * sur l'application (on aurait pu utiliser GROUP BY, mais on voulait les trier
 * aussi par esthétisme du coup GROUP BY n'est pas nécessaire). On retourne le
 * lieu pour pouvoir filtrer lors de l'affichage d'une page. Enfin, on crée
 * un booléan horsborne qui permet d'indiquer que la température de la salle
 * n'est pas dans l'intervalle de conservation d'un certain produit.
 */
CREATE VIEW VueSalle
AS SELECT codepa, codepr, libelle, temperaturemin, temperaturemax, quantite, lieu,
CAST(CASE WHEN (temperaturemin >= temperature OR temperaturemax <= temperature) THEN TRUE ELSE FALSE END AS BOOLEAN) horsborne
FROM Palette, Produit, Lot, Salle
WHERE codepa = support AND produit = codepr AND numero = lieu
ORDER BY codepa ASC;

/* Service 3
 * On crée la liste des combinaisons Salle / Palette
 * (dont on retourne le code pour pouvoir filtrer)
 * où la palette n'est pas associée à une salle
 * et la salle n'est pas pleine.
 */
CREATE VIEW Deplacements AS
SELECT 

/*Lignes de la table incorrectes

insert into Palette VALUES ('P2','3');//Une meme salle ne stocke qu'une seule fois une meme palette.
insert into Palette VALUES ('P2','2');//Une palette n'est stockee que dans une seule salle.
insert into Palette VALUES ('P1, P2','2'); //Un lien stocke ne concerne q'une seule palette.
insert into Palette VALUES ('P4','2,3'); //Un lien stocke ne concerne qu'une seulesalle.
insert into Palette VALUES ('P5','1'); //On ne gere pas les palettes vides. //Une salle ne peut pas depasser sa capacite.
insert into Lot VALUES ('P2','pr2','3'); //Un lien lot ne concerne qu'une seule palette et un seul produit.
insert into Lot VALUES ('P4','pr1,pr2','56'); //On ne gere pas de sous ensembles de produits sur une palette.

*/
