use ppe;

set default_storage_engine = innodb;

drop table if exists evenement;

create table evenement
(
    id          int          auto_increment primary key,
    titre       varchar(100) not null,
    description text         not null,
    dateDebut   datetime     not null,
    dateFin     datetime     null,
    lieu        varchar(200) null,
    type        enum('organise', 'participe') not null default 'organise' comment 'organise: événement organisé par le club, participe: événement auquel le club participe',
    visible     boolean      not null default true,
    dateCreation timestamp   not null default current_timestamp,
    dateModification timestamp not null default current_timestamp on update current_timestamp
);

-- Index pour optimiser les requêtes par date
create index idx_evenement_date on evenement(dateDebut);
create index idx_evenement_visible on evenement(visible);