CREATE TABLE Rezervi_Zimmer_Preise (
  FK_Preise_ID int(11) NOT NULL default '0',
  FK_Zimmer_ID int(11) NOT NULL default '0',
  PRIMARY KEY (FK_Preise_ID,FK_Zimmer_ID)
);