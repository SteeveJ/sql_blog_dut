drop table if exists sujet;
drop table if exists tag;

create table tag(
    id serial primary key,
    name varchar(50)
);

create table sujet(
    id serial primary key,
    name varchar(60),
    hide boolean DEFAULT false,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp,
    id_tag integer references tag null
);