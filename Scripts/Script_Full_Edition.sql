drop table if exists sch_kennis.auteur cascade;
create table sch_kennis.auteur (
auteur_id serial primary key not null,
voornaam varchar not null,
tussenvoegsel varchar,
achternaam varchar not null,
e-mail varchar not null,
wachtwoord varchar not null
);

drop table if exists sch_kennis.niveau cascade;
create table sch_kennis.niveau(
niveau_id serial primary key not null,
beschrijving varchar not null
);

insert into sch_kennis.niveau (niveau_id, beschrijving)
values (1, 'beginner'),
	   (2, 'gevorderde'),
	   (3, 'expert')
;

drop table if exists sch_kennis.rol cascade;
create table sch_kennis.rol (
rol_id serial primary key not null,
beschrijving varchar not null
);

insert into sch_kennis.rol (rol_id, beschrijving)
values	(1, 'FE'),
		(2, 'BE'),
		(3, 'AI'),
		(4, 'PO'),
		(5, 'CSC')
;

drop table if exists sch_kennis.onderwerp cascade;
create table sch_kennis.onderwerp (
onderwerp_id serial primary key not null,
beschrijving varchar not null
)

insert into sch_kennis.onderwerp (onderwerp_id, beschrijving)
values	(1, 'Gebruikersinteractie Analyseren'),
		(2, 'Gebruikersinteractie Adviseren'),
		(3, 'Gebruikersinteractie Ontwerpen'),
		(4, 'Gebruikersinteractie Realiseren'),
		(5, 'Gebruikersinteractie Manage & control'),
		(6, 'Organisatieprocessen Analyseren'),
		(7, 'Organisatieprocessen Adviseren'),
		(8, 'Organisatieprocessen Ontwerpen'),
		(9, 'Organisatieprocessen Realiseren'),
		(10, 'Organisatieprocessen Manage & control'),
		(11, 'Infrastructuur Analyseren'),
		(12, 'Infrastructuur Adviseren'),
		(13, 'Infrastructuur Ontwerpen'),
		(14, 'Infrastructuur Realiseren'),
		(15, 'Infrastructuur Manage & control'),
		(16, 'Software Analyseren'),
		(17, 'Software Adviseren'),
		(18, 'Software Ontwerpen'),
		(19, 'Software Realiseren'),
		(20, 'Software Manage & control'),
		(21, 'Hardware interfacing Analyseren'),
		(22, 'Hardware interfacing Adviseren'),
		(23, 'Hardware interfacing Ontwerpen'),
		(24, 'Hardware interfacing Realiseren'),
		(25, 'Hardware interfacing Manage & control')
;
		
drop table if exists sch_kennis.kenniskaart2 cascade;
create table sch_kennis.kenniskaart (
kenniskaart_id serial primary key not null,
titel varchar not null,
datum date not null,
wat varchar not null,
auteur int not null references sch_kennis.auteur(auteur_id),
hoe varchar not null,
waarom varchar not null,
niveau int not null references sch_kennis.niveau(niveau_id),
rol int not null references sch_kennis.rol(rol_id),
onderwerp int not null references sch_kennis.onderwerp(onderwerp_id),
bronnen varchar not null
);