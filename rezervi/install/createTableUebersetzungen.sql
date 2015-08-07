CREATE TABLE Rezervi_Uebersetzungen (
	Sprache_ID VARCHAR( 2 ) NOT NULL ,
	Standardsprache_ID int(11) NOT NULL ,
	PK_ID int(11) NOT NULL auto_increment,
	FK_Unterkunft_ID int(11) , 
	Text TEXT,
	PRIMARY KEY ( PK_ID )
); 