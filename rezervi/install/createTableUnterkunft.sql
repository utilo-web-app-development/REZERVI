CREATE TABLE Rezervi_Unterkunft (
  PK_ID int(11) NOT NULL auto_increment,
  Name varchar(100) NOT NULL default '',
  Strasse varchar(100) NOT NULL default '',
  PLZ varchar(10) NOT NULL default '',
  Ort varchar(100) NOT NULL default '',
  Land varchar(100) default NULL,
  Email varchar(100) NOT NULL default '',
  Tel varchar(100) NOT NULL default '',
  Tel2 varchar(100) default NULL,
  Fax varchar(100) default NULL,
  Art varchar(100) default NULL,
  Waehrung varchar(30) default 'Euro',
  AnzahlBenutzer int(11) default '1',
  Kindesalter int(2) default '12',
  AnzahlZimmer int(11) NOT NULL default '1',
  Zimmerart_EZ varchar(100) default NULL,
  Zimmerart_MZ varchar(100) default NULL,
  PRIMARY KEY  (PK_ID)
);