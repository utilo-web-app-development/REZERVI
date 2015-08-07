CREATE TABLE Rezervi_Zimmer_Attribute_Wert (
  FK_Attribut_ID int(11) NOT NULL default '0',
  FK_Zimmer_ID int(11) NOT NULL default '0',
  Wert text,
  PRIMARY KEY (FK_Attribut_ID,FK_Zimmer_ID)
);