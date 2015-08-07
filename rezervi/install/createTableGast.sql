CREATE TABLE Rezervi_Gast (
  PK_ID int(11) NOT NULL auto_increment,
  Vorname VARCHAR(20) NOT NULL, 
  Nachname VARCHAR(30) NOT NULL, 
  Strasse VARCHAR(40) NOT NULL, 
  PLZ VARCHAR(10) NOT NULL, 
  Ort VARCHAR(30) NOT NULL, 
  Land VARCHAR(30), 
  EMail VARCHAR(50) NOT NULL, 
  Tel VARCHAR(30), 
  Fax VARCHAR(30), 
  Anmerkung TEXT, 
  Anrede VARCHAR(10), 
  FK_Unterkunft_ID INT DEFAULT '1' NOT NULL, 
  Sprache CHAR(2) DEFAULT 'de' NOT NULL,
  PRIMARY KEY (PK_ID)
);