CREATE TABLE Rezervi_Preise (
  PK_ID int(11) NOT NULL auto_increment,
  gueltig_von date default '0000-00-00',
  gueltig_bis date default '0000-00-00',
  Preis float NOT NULL default '0',
  Standard smallint(1) NOT NULL default '0',
  Waehrung varchar(30) NOT NULL default 'Euro',
  PRIMARY KEY  (PK_ID)
);