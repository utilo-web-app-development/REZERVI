CREATE TABLE Rezervi_Role (
  PK_ID int(11) NOT NULL auto_increment,
  FK_Role_ID smallint(6) NOT NULL default '',
  Name varchar(20) NOT NULL default '',
  PRIMARY KEY  (PK_ID)
);