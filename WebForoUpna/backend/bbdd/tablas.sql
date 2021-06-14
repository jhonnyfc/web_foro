CREATE TABLE usuario(
    username varchar(20) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    email varchar(30) NOT NULL,
    foto_url varchar(255) DEFAULT 'http://localhost:8080/res/default_sq.webp',
    PRIMARY KEY (username)
);

CREATE TABLE foro(
    id int(11) NOT NULL AUTO_INCREMENT,
    titulo varchar(30) NOT NULL UNIQUE,
    foto_url varchar(255) DEFAULT 'http://localhost:8080/res/default.webp',
    username varchar(20) NOT NULL,
    descripcion varchar(1200) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (username) REFERENCES usuario (username)
);

CREATE TABLE comment(
    id int(11) NOT NULL AUTO_INCREMENT UNIQUE,
    comentario varchar(1200) NOT NULL,
    id_foro int(11) NOT NULL,
    username varchar(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_foro) REFERENCES foro(id),
    FOREIGN KEY(username) REFERENCES usuario(username)
);