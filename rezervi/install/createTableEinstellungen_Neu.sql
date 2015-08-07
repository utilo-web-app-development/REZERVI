CREATE TABLE Rezervi_Einstellungen_Neu (  
  Ansicht int(1),
  Frame_left_WI varchar(5) default '280',  
  Frame_left_BP varchar(5) default '280',
  Frame_right_WI varchar(5) default '*',  
  Frame_right_BP varchar(5) default '*',
  FK_Unterkunft_ID int(11) default '0' NOT NULL,
  PRIMARY KEY  (FK_Unterkunft_ID)
);