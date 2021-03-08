CREATE TABLE usuario(
    unickname       VARCHAR(20) NOT NULL,
    upuntuacion     VARCHAR(20) NOT NULL,
    upass           VARCHAR(255) NOT NULL,
CONSTRAINT pk_user PRIMARY KEY (unickname));

CREATE TABLE lastIp(
    l_odi           INTEGER AUTO_INCREMENT,
    l_ipNumber      VARCHAR(30) NOT NULL,
    l_horaUlti      TIMESTAMP DEFAULT NOW(),
CONSTRAINT pk_lasip PRIMARY KEY (l_oid));