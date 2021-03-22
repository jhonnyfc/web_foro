CREATE TABLE usuario(
    unickname       VARCHAR(20) NOT NULL,
    upuntuacion     VARCHAR(20),
    upass           VARCHAR(255) NOT NULL,
CONSTRAINT pk_user PRIMARY KEY (unickname));

CREATE TABLE lastIp(
    l_oid           INTEGER AUTO_INCREMENT,
    l_ipNumber      VARCHAR(30) NOT NULL,
    l_horaUlti      TIMESTAMP DEFAULT NOW(),
CONSTRAINT pk_lasip PRIMARY KEY (l_oid));

CREATE TABLE mensaje(
    m_oid           INTEGER AUTO_INCREMENT,
    unickname       VARCHAR(20) NOT NULL,
    contenido       VARCHAR(140) NOT NULL,
    msg_time        TIMESTAMP DEFAULT NOW(),
    l_ipNumber      VARCHAR(30) NOT NULL,
CONSTRAINT pk_mensaje PRIMARY KEY (m_oid),
CONSTRAINT fk_nick_ip FOREIGN KEY (unickname) REFERENCES usuario (unickname));