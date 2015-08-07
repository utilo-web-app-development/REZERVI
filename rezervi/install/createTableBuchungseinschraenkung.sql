CREATE TABLE Rezervi_Buch_Einschraenkung (
  PK_ID int(11) NOT NULL auto_increment,
  Tag_von VARCHAR(2) NOT NULL, 
  Tag_bis VARCHAR(2) NOT NULL, 
  Datum_von DATE NOT NULL, 
  Datum_bis DATE NOT NULL, 
  FK_Zimmer_ID INT DEFAULT '1' NOT NULL,
  PRIMARY KEY (PK_ID)
);