CREATE TABLE Rezervi_CSS (
  PK_ID int(11) NOT NULL auto_increment,
  backgroundColor text,
  standardSchrift text,
  belegt text,
  samstagBelegt text,
  frei text,
  samstagFrei text,
  reserviert text,
  samstagReserviert text,
  standardSchriftBold text,
  ueberschrift text,
  tableStandard text,
  tableColor text,
  button200pxA text,
  FK_Unterkunft_ID int(11) NOT NULL default '0',
  button200pxB text,
  PRIMARY KEY  (PK_ID)
);