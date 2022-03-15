CREATE TABLE IF NOT EXISTS CARDS(
	cardId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name varchar(30) NOT NULL,
	type varchar(10) NOT NULL,
	rating INT UNSIGNED DEFAULT 1,
	atk INT UNSIGNED DEFAULT 100,
	def INT UNSIGNED DEFAULT 100,
	effect varchar(255) NOT NULL,
	primary key (cardId)
);

CREATE TABLE IF NOT EXISTS DECKS(
	deckId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	card1 INT UNSIGNED DEFAULT NULL,
	card2 INT UNSIGNED DEFAULT NULL,
	card3 INT UNSIGNED DEFAULT NULL,
	card4 INT UNSIGNED DEFAULT NULL,
	card5 INT UNSIGNED DEFAULT NULL,
	card6 INT UNSIGNED DEFAULT NULL,
	card7 INT UNSIGNED DEFAULT NULL,
	card8 INT UNSIGNED DEFAULT NULL,
	card9 INT UNSIGNED DEFAULT NULL,
	card10 INT UNSIGNED DEFAULT NULL,
	primary key (deckId),
	FOREIGN KEY (card1) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card2) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card3) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card4) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card5) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card6) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card7) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card8) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card9) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (card10) REFERENCES CARDS(cardId) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS USERS(
        userid INT UNSIGNED NOT NULL AUTO_INCREMENT,
        username varchar(30) NOT NULL,
        password varchar(30) NOT NULL,
        deck1ID int unsigned DEFAULT NULL,
        deck2ID int unsigned DEFAULT NULL,
        deck3ID int unsigned DEFAULT NULL,
        wins int unsigned DEFAULT 0,
        ranking int unsigned DEFAULT NULL,
        primary key (userid),
	FOREIGN KEY (deck1ID) REFERENCES DECKS(deckId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (deck2ID) REFERENCES DECKS(deckId) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (deck3ID) REFERENCES DECKS(deckId) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO USERS (username, password) values('testUser', 'testPassword');
