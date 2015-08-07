CREATE TABLE Rezervi_Benutzer (
  PK_ID int(11) NOT NULL auto_increment,
  FK_Unterkunft_ID int(11) NOT NULL default '0',
  Name varchar(20) NOT NULL default '',
  Passwort varchar(250) NOT NULL default '',
  Rechte smallint(6) NOT NULL default '0',
  PRIMARY KEY  (PK_ID)
);