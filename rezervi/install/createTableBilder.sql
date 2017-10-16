CREATE TABLE Rezervi_Bilder (  
  PK_ID int(11) NOT NULL auto_increment,
  Pfad text,
  Pfad_Thumbnail text,
  Beschreibung text,
  FK_Zimmer_ID int(11),
  Width varchar(5),
  Height varchar(5),
  PRIMARY KEY  (PK_ID)
);