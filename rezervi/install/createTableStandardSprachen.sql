CREATE TABLE Rezervi_Standard_Sprachen (  
  Sprache_ID varchar(2) NOT NULL,
  Modul int(1) NOT NULL,  
  Einstellungen_ID int(11) NOT NULL default '1',
  PK_ID int(11) NOT NULL auto_increment,
  PRIMARY KEY  (PK_ID)
);