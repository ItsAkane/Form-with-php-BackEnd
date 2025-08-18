use banco

create table mensagem(
	id int auto_increment primary key,
	name char(50) not null,
    email char(50) not null,
    telefone int,
    assunt char(50),
    message char(100) not null
);
