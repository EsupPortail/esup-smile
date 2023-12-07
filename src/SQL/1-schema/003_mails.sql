create table unicaen_mail_mail
(
    id                     serial
        constraint umail_pkey
            primary key,
    date_envoi             timestamp    not null,
    status_envoi           varchar(256) not null,
    destinataires          text         not null,
    destinataires_initials text,
    sujet                  text,
    corps                  text,
    mots_clefs             text,
    log                    text
);

alter table unicaen_mail_mail
    owner to admin;

create unique index ummail_id_uindex
    on unicaen_mail_mail (id);

