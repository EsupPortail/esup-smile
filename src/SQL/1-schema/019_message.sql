create table message
(
    id                    serial      not null primary key,
    content               text not null,
    created_at            date   not null,
    inscription_id        int         not null, -- id of the inscription
    sender_id             int         not null, -- id of the sender (utilisateur)
    receiver_id           int         not null, -- id of the receiver (utilisateur)
    constraint message_inscription_id_fk
        foreign key (inscription_id) references inscription (id)
);

create unique index message_id_uindex
    on message (id);
