CREATE TABLE Rezervi_Buchungsformular (
  PK_ID INT NOT NULL AUTO_INCREMENT, 
  Attribut VARCHAR(255) NOT NULL, 
  FK_Unterkunft_ID INT NOT NULL, 
  Art VARCHAR(255) NOT NULL, 
  Erforderlich TINYINT(1) DEFAULT '0' NOT NULL,
  Typ VARCHAR( 255 ) NOT NULL,
  PRIMARY KEY (PK_ID)
);