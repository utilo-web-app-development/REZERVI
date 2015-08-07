CREATE TABLE Rezervi_Properties (  
  PK_ID int(11) NOT NULL auto_increment,
  Name varchar(100),  
  Value varchar(255),
  FK_Unterkunft_ID int(11) default '0',
  PRIMARY KEY  (PK_ID)
);