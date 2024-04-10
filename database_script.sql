drop table if exists notifications ;
drop table if exists employe_prestation ;
drop table if exists prestations ;
drop table if exists competence_employe ;
drop table if exists contrats ;
drop table if exists competences ;
drop table if exists agentsdrh;
drop table if exists employes;
drop table if exists clients;
drop table if exists admin;

create table admin (
                       id SERIAL PRIMARY KEY,
                       login varchar(20),
                       mot_de_passe varchar(100)
);

CREATE TABLE clients (
                         id SERIAL PRIMARY KEY,
                         nom_utilisateur VARCHAR(20)unique ,
                         mot_de_passe VARCHAR(100),
                         email VARCHAR(50),
                         nom varchar(30) ,
                         locale varchar(50),
                         numero_telephone int check (numero_telephone between 10000000 and 99999999)
);
CREATE TABLE employes (
                          id SERIAL PRIMARY KEY,
                          nom VARCHAR(30),
                          prenom VARCHAR(30),
                          email VARCHAR(50) UNIQUE,
                          date_inscription DATE,
                          adresse VARCHAR(50),
                          numero_telephone int,
                          constraint numero_telephone check(numero_telephone between 10000000 and 99999999)
);
CREATE TABLE agentsdrh (
                           id SERIAL PRIMARY KEY,
                           nom_utilisateur VARCHAR(20) ,
                           mot_de_passe VARCHAR(100),
                           email VARCHAR(50),
                           numero_telephone int,
                           nom varchar(30),
                           prenom varchar(30)
);
CREATE TABLE competences (
                             id SERIAL PRIMARY KEY,
                             competence VARCHAR(30),
                             niveau_competence INT,
                             prix_estime NUMERIC(10, 3),
                             CONSTRAINT nc CHECK (niveau_competence BETWEEN 1 AND 3),
                             constraint unicity unique (competence,niveau_competence)
);
-- Table contrats
CREATE TABLE contrats (
                          id SERIAL PRIMARY KEY,
                          id_client INTEGER REFERENCES clients(id) on delete cascade,
                          libelle VARCHAR(30),
                          date_soumission DATE,
                          date_reponse DATE,
                          etat_contrat VARCHAR(30),
                          prix NUMERIC(10, 3),
                          id_agent_drh INTEGER references agentsdrh(id) on delete set null
);

-- Table competence_employe
CREATE TABLE competence_employe (
                                    id_employe INTEGER REFERENCES employes(id) on delete cascade,
                                    id_competence INTEGER REFERENCES competences(id) on delete cascade,
                                    PRIMARY KEY (id_employe, id_competence)
);
-- Table prestations
CREATE TABLE prestations (
                             id SERIAL PRIMARY KEY,
                             date_debut DATE,
                             date_fin DATE,
                             duree INTEGER,
                             prix NUMERIC(10, 3),
                             id_competence INTEGER REFERENCES competences(id),
                             id_contrat INTEGER REFERENCES contrats(id) on delete cascade,
                             description varchar(30)
);
create table employe_prestation(
                                   id_employe INTEGER REFERENCES employes(id) on delete cascade,
                                   id_prestation INTEGER REFERENCES prestations(id) on delete cascade,
                                   PRIMARY KEY (id_employe, id_prestation)
);

CREATE TABLE notifications (
                               id SERIAL PRIMARY KEY,
                               id_contrat INTEGER REFERENCES contrats(id) on delete cascade,
                               message TEXT,
                               date_envoi timestamp
);