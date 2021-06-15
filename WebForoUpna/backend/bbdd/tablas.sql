CREATE TABLE usuario(
    username varchar(20) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    email varchar(30) NOT NULL,
    foto_url varchar(255) DEFAULT 'http://localhost:8080/router.php/res/default_sq.webp',
    PRIMARY KEY (username)
);

CREATE TABLE foro(
    id_foro int(11) NOT NULL AUTO_INCREMENT,
    titulo varchar(30) NOT NULL UNIQUE,
    foto_url varchar(255) DEFAULT 'http://localhost:8080/router.php/res/default.webp',
    username varchar(20) NOT NULL,
    descripcion varchar(1200) NOT NULL,
    PRIMARY KEY (id_foro),
    FOREIGN KEY (username) REFERENCES usuario (username)
);

CREATE TABLE comment(
    idcom int(11) NOT NULL AUTO_INCREMENT UNIQUE,
    comentario varchar(1200) NOT NULL,
    id_foro int(11) NOT NULL,
    username varchar(20) NOT NULL,
    PRIMARY KEY (idcom),
    FOREIGN KEY (id_foro) REFERENCES foro(id_foro),
    FOREIGN KEY(username) REFERENCES usuario(username)
);

INSERT INTO comment(comentario, id_foro, username) VALUES ( ?, ?, ?);

SELECT f.id_foro, f.titulo, f.foto_url
FROM foro f LEFT JOIN comment c ON f.id_foro = c.id_foro
GROUP BY f.id_foro
ORDER BY count(f.id_foro) DESC LIMIT ?;

-- TODO
-- poner lo de limit para contar los datos
SELECT *
FROM comment c
ORDER BY c.idcom DESC LIMIT ?;

SELECT count(c.idcom) as num_filas
FROM comment c;


-- TODO
-- poner lo de limit para contar los datos
SELECT *
FROM foro f
WHERE f.titulo LIKE '%?%';

SELECT count(f.id_foro) as num_filas
FROM foro f
WHERE f.titulo LIKE '%?%';


if ($pagina == 1) {
    $consulta .= " LIMIT $numFilas";
} else {
    $consulta .= " LIMIT ". (($pagina - 1) *  $numFilas ) . ", " . ($numFilas);
}

-- https://github.com/jhonnyfc/Calisthenics_Web_SIW/blob/4737ce0d739a6bd7489c3b0b0998c79146875ea3/final/backoffice/back__modelo.php#L687
-- https://github.com/jhonnyfc/Calisthenics_Web_SIW/blob/4737ce0d739a6bd7489c3b0b0998c79146875ea3/final/backoffice/back__views.php#L296
-- https://github.com/jhonnyfc/Calisthenics_Web_SIW/blob/master/final/backoffice/back_temp_show_table.html