drop table if exists sch_map.kenniskaart cascade;
create table if not exists sch_map.kenniskaart (
kenniskaart_id serial primary key not null,
onderwerp varchar not null,
rol varchar not null,
competentie varchar not null,
wat varchar not null,
why varchar not null,
how varchar null,
plaatje varchar not null,
bronnen varchar not null,
niveau varchar not null,
studieduur varchar not null,
rating varchar null
);

insert into sch_map.kenniskaart (onderwerp, rol, competentie, wat, why, how, plaatje, bronnen, niveau, studieduur, rating)
	values ('Design thinking', 'FE, PO', 'Gebruikersinteractie Adviseren', 'wat1', 'why1', 'how1', 'plaatje1', 'bronnen1', 'beginner', '30 minuten', '3')
	;
	

drop table if exists sch_map.test cascade;
create table if not exists sch_map.test (
test_id serial primary key not null,
plaatje varchar not null
);

