CREATE TABLE USERS(
        userid INT UNSIGNED NOT NULL AUTO_INCREMENT,
        username varchar(30) NOT NULL,
	password varchar(30) NOT NULL,
        deck1ID int unsigned DEFAULT NULL,
        deck2ID int unsigned DEFAULT NULL,
        deck3ID int unsigned DEFAULT NULL,
        wins int unsigned DEFAULT 0,
        ranking int unsigned DEFAULT NULL,
	primary key (userid)
);
