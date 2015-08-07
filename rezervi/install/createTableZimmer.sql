CREATE TABLE Rezervi_Zimmer (
  PK_ID int(11) NOT NULL auto_increment,
  FK_Unterkunft_ID int(11) NOT NULL default '0',
  Zimmernr varchar(20) default NULL,
  Betten smallint(6) NOT NULL default '0',
  Betten_Kinder smallint(6) default '0',
  Zimmerart varchar(30) NOT NULL default 'Zimmer',
  Link varchar(255) default NULL,
  Haustiere varchar(5) default 'false',
  Parent_ID int(11),
  PRIMARY KEY (PK_ID)
);