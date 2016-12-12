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

CREATE VIEW VueEntrepot AS SELECT
numero, temperature, capacite FROM Salle
ORDER BY temperature, capacite DESC;

CREATE VIEW VueSalle AS SELECT
codepa, lieu FROM Palette;

CREATE VIEW VuePalette
AS SELECT codepa, codepr, libelle, temperaturemin, temperaturemax, quantite
FROM Palette, Produit, Lot
WHERE codepa = support AND produit = codepr;

/*Lignes de la table incorrectes

insert into Palette VALUES ('P2','3');//Une meme salle ne stocke qu'une seule fois une meme palette.
insert into Palette VALUES ('P2','2');//Une palette n'est stockee que dans une seule salle.
insert into Palette VALUES ('P1, P2','2'); //Un lien stocke ne concerne q'une seule palette.
insert into Palette VALUES ('P4','2,3'); //Un lien stocke ne concerne qu'une seulesalle.
insert into Palette VALUES ('P5','1'); //On ne gere pas les palettes vides. //Une salle ne peut pas depasser sa capacite.
insert into Lot VALUES ('P2','pr2','3'); //Un lien lot ne concerne qu'une seule palette et un seul produit.
insert into Lot VALUES ('P4','pr1,pr2','56'); //On ne gere pas de sous ensembles de produits sur une palette.

*/
