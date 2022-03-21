CREATE DATABASE IF NOT EXISTS webdb;

CREATE TABLE IF NOT EXISTS DECKS(
	deckId varchar(31) NOT NULL,
	card1 JSON DEFAULT NULL,
	card2 JSON DEFAULT NULL,
	card3 JSON DEFAULT NULL,
	card4 JSON DEFAULT NULL,
	card5 JSON DEFAULT NULL,
	card6 JSON DEFAULT NULL,
	card7 JSON DEFAULT NULL,
	card8 JSON DEFAULT NULL,
	card9 JSON DEFAULT NULL,
	card10 JSON DEFAULT NULL,
	primary key (deckId)
);

CREATE TABLE IF NOT EXISTS USERS(
        userid INT UNSIGNED NOT NULL AUTO_INCREMENT,
        username varchar(30) NOT NULL,
        password varchar(30) NOT NULL,
        deck1ID varchar(31) DEFAULT NULL,
        deck2ID varchar(31) DEFAULT NULL,
        deck3ID varchar(31) DEFAULT NULL,
        wins int unsigned DEFAULT 0,
        ranking int DEFAULT 0,
        primary key (userid)
);

INSERT INTO USERS (username, password) values('testUser', 'testPassword');
INSERT INTO USERS (username, password) values('Brett', 'BrettPassword123');
INSERT INTO USERS (username, password) values('Brett2', 'BrettPass');


