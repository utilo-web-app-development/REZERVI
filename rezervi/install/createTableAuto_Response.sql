CREATE TABLE Rezervi_Auto_Response (
  PK_ID int(11) NOT NULL auto_increment,
  FK_Unterkunft_ID INT NOT NULL, 
  Subject TEXT, 
  Body TEXT, 
  Unterschrift TEXT,  
  Art VARCHAR(30) NOT NULL, 
  Anrede TEXT NOT NULL, 
  aktiviert TINYINT(0) NOT NULL,
  PRIMARY KEY (PK_ID)
);