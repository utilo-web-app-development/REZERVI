CREATE TABLE Rezervi_Reservierung (
  PK_ID int(11) NOT NULL auto_increment,
  FK_Zimmer_ID int(11) NOT NULL default '0',
  FK_Gast_ID int(11) NOT NULL default '0',
  Datum_von date NOT NULL default '0000-00-00',
  Datum_bis date NOT NULL default '0000-00-00',
  Status smallint(6) NOT NULL default '-1',
  Erwachsene int(2) default '0',
  Kinder int(2) default '0',
  Pension varchar(255) default NULL,
  ANFRAGEDATUM timestamp NOT NULL,
  PRIMARY KEY  (PK_ID)
);