CREATE TABLE Rezervi_Zimmer_Attribute (
  PK_ID int(11) NOT NULL auto_increment,
  FK_Unterkunft_ID int(11) NOT NULL default '0',
  Bezeichnung varchar(255) NOT NULL,
  Beschreibung text,
  PRIMARY KEY (PK_ID)
);