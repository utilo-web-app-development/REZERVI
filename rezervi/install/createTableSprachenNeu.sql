CREATE TABLE Rezervi_Sprachen_Neu (
	Sprache_ID VARCHAR( 2 ) NOT NULL ,
	Bezeichnung VARCHAR( 100 ) NOT NULL ,
	Fahne LONGBLOB NOT NULL ,
	Aktiv TINYINT( 1 ) DEFAULT '0' NOT NULL , 
	PRIMARY KEY ( Sprache_ID )
); 