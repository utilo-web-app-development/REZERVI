-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 09. Mai 2006 um 19:27
-- Server Version: 4.1.11
-- PHP-Version: 4.4.0
-- 
-- Datenbank: `Rezervi_Generic`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_ADRESSE`
-- 

DROP TABLE IF EXISTS REZ_GEN_ADRESSE;
CREATE TABLE REZ_GEN_ADRESSE (
  ADRESSE_ID int(11) NOT NULL auto_increment,
  ANREDE varchar(255) default NULL,
  VORNAME varchar(255) default NULL,
  NACHNAME varchar(255) default NULL,
  STRASSE varchar(255) default NULL,
  PLZ varchar(10) default NULL,
  ORT varchar(255) default NULL,
  LAND varchar(255) default NULL,
  EMAIL varchar(255) default NULL,
  TELEFON varchar(255) default NULL,
  TELEFON2 varchar(255) default NULL,
  FAX varchar(255) default NULL,
  URL varchar(255) default NULL,
  FIRMA varchar(255) default NULL,
  PRIMARY KEY  (ADRESSE_ID)
) TYPE=MyISAM COMMENT='Adressen für Vermieter und Mieter';

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_ANTWORTEN`
-- 

DROP TABLE IF EXISTS REZ_GEN_ANTWORTEN;
CREATE TABLE REZ_GEN_ANTWORTEN (
  ANTWORTEN_ID int(11) NOT NULL auto_increment,
  VERMIETER_ID int(11) NOT NULL default '0',
  SPRACHE_ID char(2) NOT NULL default '',
  ANREDE varchar(255) default NULL,
  `SUBJECT` text,
  BODY text,
  UNTERSCHRIFT text,
  BEZEICHNUNG varchar(255) default NULL,
  AKTIV smallint(6) default NULL,
  PRIMARY KEY  (ANTWORTEN_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_BENUTZER`
-- 

DROP TABLE IF EXISTS REZ_GEN_BENUTZER;
CREATE TABLE REZ_GEN_BENUTZER (
  BENUTZER_ID int(11) NOT NULL auto_increment,
  VERMIETER_ID int(11) NOT NULL default '0',
  NAME varchar(100) NOT NULL default '',
  PASSWORT varchar(100) NOT NULL default '',
  RECHTE smallint(6) NOT NULL default '0',
  PRIMARY KEY  (BENUTZER_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_BILDER`
-- 

DROP TABLE IF EXISTS REZ_GEN_BILDER;
CREATE TABLE REZ_GEN_BILDER (
  BILDER_ID int(11) NOT NULL auto_increment,
  MIETOBJEKT_ID int(11) default NULL,
  BILD blob,
  BESCHREIBUNG text,
  WIDTH varchar(5) default NULL,
  HEIGHT varchar(5) default NULL,
  MIME varchar(5) NOT NULL default '',
  PRIMARY KEY  (BILDER_ID)
) TYPE=MyISAM COMMENT='Bilder zu Mietobjekten';

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_BUCHUNGSEINSCHRAENKUNG`
-- 

DROP TABLE IF EXISTS REZ_GEN_BUCHUNGSEINSCHRAENKUNG;
CREATE TABLE REZ_GEN_BUCHUNGSEINSCHRAENKUNG (
  EINSCHRAENKUNGS_ID int(11) NOT NULL auto_increment,
  VON varchar(12) NOT NULL default '',
  BIS varchar(12) NOT NULL default '',
  MIETOBJEKT_ID int(11) NOT NULL default '0',
  TYP varchar(100) NOT NULL default '',
  PRIMARY KEY  (EINSCHRAENKUNGS_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_CSS`
-- 

DROP TABLE IF EXISTS REZ_GEN_CSS;
CREATE TABLE REZ_GEN_CSS (
  CSS_ID int(11) NOT NULL auto_increment,
  VERMIETER_ID int(11) default NULL,
  CLASSNAME varchar(150) default NULL,
  WERT text,
  PRIMARY KEY  (CSS_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_MIETER`
-- 

DROP TABLE IF EXISTS REZ_GEN_MIETER;
CREATE TABLE REZ_GEN_MIETER (
  MIETER_ID int(11) NOT NULL auto_increment,
  SPRACHE_ID char(2) NOT NULL default '',
  ADRESSE_ID int(11) NOT NULL default '0',
  VERMIETER_ID int(11) NOT NULL default '0',
  PRIMARY KEY  (MIETER_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_MIETER_TEXTE`
-- 

DROP TABLE IF EXISTS REZ_GEN_MIETER_TEXTE;
CREATE TABLE REZ_GEN_MIETER_TEXTE (
  TEXTE_ID int(11) NOT NULL auto_increment,
  MIETER_ID int(11) NOT NULL default '0',
  `TEXT` text NOT NULL,
  DATUM date NOT NULL default '0000-00-00',
  PRIMARY KEY  (TEXTE_ID)
) TYPE=MyISAM COMMENT='Beliebige Texte von und an den Mieter';

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_MIETOBJEKT`
-- 

DROP TABLE IF EXISTS REZ_GEN_MIETOBJEKT;
CREATE TABLE REZ_GEN_MIETOBJEKT (
  MIETOBJEKT_ID int(11) NOT NULL auto_increment,
  VERMIETER_ID int(11) NOT NULL default '0',
  BEZEICHNUNG varchar(255) default NULL,
  BESCHREIBUNG text,
  PREIS varchar(255) default NULL,
  LINK varchar(255) default NULL,
  PRIMARY KEY  (MIETOBJEKT_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_MIE_EIGENSCHAFTEN`
-- 

DROP TABLE IF EXISTS REZ_GEN_MIE_EIGENSCHAFTEN;
CREATE TABLE REZ_GEN_MIE_EIGENSCHAFTEN (
  EIGENSCHAFT_ID int(11) NOT NULL auto_increment,
  MIETOBJEKT_ID int(11) NOT NULL default '0',
  BEZEICHNUNG varchar(255) default NULL,
  WERT text,
  BESCHREIBUNG text,
  PRIMARY KEY  (EIGENSCHAFT_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_RESERVIERUNG`
-- 

DROP TABLE IF EXISTS REZ_GEN_RESERVIERUNG;
CREATE TABLE REZ_GEN_RESERVIERUNG (
  RESERVIERUNG_ID int(11) NOT NULL auto_increment,
  MIETOBJEKT_ID int(11) default NULL,
  MIETER_ID int(11) NOT NULL default '0',
  VON varchar(12) NOT NULL default '',
  BIS varchar(12) NOT NULL default '',
  `STATUS` smallint(6) default NULL,
  ANZAHL_MIETOBJEKTE int(11) default NULL,
  PRIMARY KEY  (RESERVIERUNG_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_SESSION`
-- 

DROP TABLE IF EXISTS REZ_GEN_SESSION;
CREATE TABLE REZ_GEN_SESSION (
  SESSION_ID int(11) NOT NULL auto_increment,
  ERSTELLUNG varchar(12) NOT NULL default '',
  BEZEICHNUNG varchar(255) default NULL,
  WERT text,
  HTTP_SESSION_ID varchar(255) NOT NULL default '',
  PRIMARY KEY  (SESSION_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_SPRACHEN`
-- 

DROP TABLE IF EXISTS REZ_GEN_SPRACHEN;
CREATE TABLE REZ_GEN_SPRACHEN (
  SPRACHE_ID char(2) NOT NULL default '',
  BILDER_ID int(11) default NULL,
  BEZEICHNUNG varchar(255) default NULL,
  PRIMARY KEY  (SPRACHE_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_SPR_VER`
-- 

DROP TABLE IF EXISTS REZ_GEN_SPR_VER;
CREATE TABLE REZ_GEN_SPR_VER (
  VERMIETER_ID int(11) NOT NULL default '0',
  SPRACHE_ID char(2) NOT NULL default '',
  PRIMARY KEY  (VERMIETER_ID,SPRACHE_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_UEBERSETZUNGEN`
-- 

DROP TABLE IF EXISTS REZ_GEN_UEBERSETZUNGEN;
CREATE TABLE REZ_GEN_UEBERSETZUNGEN (
  UEBERSETZUNGS_ID int(11) NOT NULL auto_increment,
  VERMIETER_ID int(11) NOT NULL default '0',
  SPRACHE_ID char(2) NOT NULL default '',
  `TEXT` text,
  TEXT_STANDARD text,
  PRIMARY KEY  (UEBERSETZUNGS_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_VERMIETER`
-- 

DROP TABLE IF EXISTS REZ_GEN_VERMIETER;
CREATE TABLE REZ_GEN_VERMIETER (
  VERMIETER_ID int(11) NOT NULL auto_increment,
  ADRESSE_ID int(11) NOT NULL default '0',
  MIETOBJEKT_EZ varchar(255) default NULL,
  MIETOBJEKT_MZ varchar(255) default NULL,
  ANZAHL_MIETOBJEKTE int(11) default NULL,
  ANZAHL_BENUTZER int(11) default NULL,
  PRIMARY KEY  (VERMIETER_ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `REZ_GEN_VER_EIGENSCHAFTEN`
-- 

DROP TABLE IF EXISTS REZ_GEN_VER_EIGENSCHAFTEN;
CREATE TABLE REZ_GEN_VER_EIGENSCHAFTEN (
  EIGENSCHAFTEN_ID int(11) NOT NULL auto_increment,
  VERMIETER_ID int(11) NOT NULL default '0',
  BEZEICHNUNG varchar(255) default NULL,
  WERT text,
  PRIMARY KEY  (EIGENSCHAFTEN_ID)
) TYPE=MyISAM;
