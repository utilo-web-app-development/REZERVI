-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 22. September 2008 um 11:09
-- Server Version: 5.0.51
-- PHP-Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `rezervi_table`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_adresse`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_ADRESSE` (
  `ADRESSE_ID` int(11) NOT NULL auto_increment,
  `ANREDE` varchar(100) default NULL,
  `VORNAME` varchar(255) default NULL,
  `NACHNAME` varchar(255) default NULL,
  `STRASSE` varchar(255) default NULL,
  `PLZ` varchar(100) default NULL,
  `ORT` varchar(255) default NULL,
  `LAND` varchar(255) default NULL,
  `EMAIL` varchar(255) default NULL,
  `TELEFON` varchar(255) default NULL,
  `TELEFON2` varchar(255) default NULL,
  `FAX` varchar(255) default NULL,
  `WWW` varchar(255) default NULL,
  `FIRMA` varchar(255) default NULL,
  PRIMARY KEY  (`ADRESSE_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_antworten`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_ANTWORTEN` (
  `ANTWORTEN_ID` int(11) NOT NULL auto_increment,
  `TEXT` text,
  `TYPE` varchar(100) NOT NULL default '',
  `AKTIV` smallint(6) NOT NULL default '0',
  `GASTRO_ID` int(11) NOT NULL default '1',
  PRIMARY KEY  (`ANTWORTEN_ID`),
  KEY `FK_BOOKLINE_ANTWORTEN_1` (`GASTRO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_benutzer`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_BENUTZER` (
  `BENUTZER_ID` int(11) NOT NULL auto_increment,
  `NAME` varchar(100) NOT NULL default '',
  `PASSWORT` varchar(100) NOT NULL default '',
  `RECHTE` smallint(6) NOT NULL default '0',
  `GASTRO_ID` int(11) NOT NULL default '1',
  PRIMARY KEY  (`BENUTZER_ID`),
  KEY `FK_BOOKLINE_BENUTZER_1` (`GASTRO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_bilder`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_BILDER` (
  `BILDER_ID` int(11) NOT NULL auto_increment,
  `URL` varchar(100) NOT NULL default '',
  `GASTRO_ID` int(11) default NULL,
  `BILD` blob NOT NULL,
  `BESCHREIBUNG` text,
  `WIDTH` varchar(5) default NULL,
  `HEIGHT` varchar(5) default NULL,
  `MIME` varchar(5) NOT NULL default '',
  `MARKER` varchar(100) default NULL,
  PRIMARY KEY  (`BILDER_ID`),
  KEY `FK_BOOKLINE_BILDER_1` (`GASTRO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_css`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_CSS` (
  `CSS_ID` int(11) NOT NULL auto_increment,
  `CLASSNAME` varchar(150) NOT NULL default '',
  `WERT` text,
  `GASTRO_ID` int(11) NOT NULL default '1',
  PRIMARY KEY  (`CSS_ID`),
  KEY `FK_BOOKLINE_CSS_1` (`GASTRO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_file`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_FILE` (
  `FILE_ID` int(11) NOT NULL auto_increment,
  `FILE` blob NOT NULL,
  `BESCHREIBUNG` text,
  `MIME` varchar(5) NOT NULL default '',
  `ANTWORTEN_ID` int(11) default NULL,
  PRIMARY KEY  (`FILE_ID`),
  KEY `FK_BOOKLINE_FILE_1` (`ANTWORTEN_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_gast`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_GAST` (
  `GAST_ID` int(11) NOT NULL auto_increment,
  `ADRESSE_ID` int(11) NOT NULL default '0',
  `SPRACHE_ID` char(2) NOT NULL default '',
  `GASTRO_ID` int(11) NOT NULL default '1',
  `BEZEICHNUNG` varchar(100) default NULL,
  `BESCHREIBUNG` text,
  `ECHTBUCHUNG` tinyint(4) default NULL,
  PRIMARY KEY  (`GAST_ID`),
  KEY `FK_BOOKLINE_GAST_1` (`ADRESSE_ID`),
  KEY `FK_BOOKLINE_GAST_2` (`SPRACHE_ID`),
  KEY `FK_BOOKLINE_GAST_3` (`GASTRO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_gastgruppe`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_GASTGRUPPE` (
  `GASTRO_ID` int(11) NOT NULL,
  `GRUPPENBEZEICHNUNG` varchar(100) NOT NULL,
  `BESCHREIBUNG` text,
  `STATUS` tinyint(4) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_gastro`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_GASTRO` (
  `GASTRO_ID` int(11) NOT NULL auto_increment,
  `ADRESSE_ID` int(11) default '0',
  PRIMARY KEY  (`GASTRO_ID`),
  KEY `FK_BOOKLINE_GASTRO_1` (`ADRESSE_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_gastro_properties`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_GASTRO_PROPERTIES` (
  `PROPERTY_ID` int(11) NOT NULL auto_increment,
  `BEZEICHNUNG` varchar(100) NOT NULL default '',
  `WERT` text NOT NULL,
  `GASTRO_ID` int(11) NOT NULL default '1',
  PRIMARY KEY  (`PROPERTY_ID`),
  KEY `FK_BOOKLINE_GASTRO_PROPERTIES_1` (`GASTRO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_gast_texte`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_GAST_TEXTE` (
  `TEXTE_ID` int(11) NOT NULL auto_increment,
  `TEXT` text NOT NULL,
  `DATUM` varchar(12) NOT NULL default '',
  `GAST_ID` int(11) NOT NULL default '1',
  PRIMARY KEY  (`TEXTE_ID`),
  KEY `FK_BOOKLINE_GAST_TEXTE_1` (`GAST_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_oeffnungszeiten`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_OEFFNUNGSZEITEN` (
  `OEFFNUNGSZEITEN_ID` int(11) NOT NULL auto_increment,
  `VON` varchar(12) NOT NULL default '',
  `BIS` varchar(12) NOT NULL default '',
  `TYPE` varchar(100) NOT NULL default '',
  `GASTRO_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`OEFFNUNGSZEITEN_ID`),
  KEY `FK_BOOKLINE_OEFFNUNGSZEITEN_1` (`GASTRO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_raum`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_RAUM` (
  `RAUM_ID` int(11) NOT NULL auto_increment,
  `BEZEICHNUNG` varchar(100) NOT NULL default '',
  `BESCHREIBUNG` text NOT NULL,
  `BILDER_ID` int(11) default '0',
  `GASTRO_ID` int(11) NOT NULL default '1',
  PRIMARY KEY  (`RAUM_ID`),
  KEY `FK_BOOKLINE_RAUM_2` (`BILDER_ID`),
  KEY `FK_BOOKLINE_RAUM_3` (`GASTRO_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_reservierung`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_RESERVIERUNG` (
  `RESERVIERUNG_ID` int(11) NOT NULL auto_increment,
  `VON` varchar(12) NOT NULL default '',
  `BIS` varchar(12) NOT NULL default '',
  `STATUS` smallint(6) NOT NULL default '0',
  `ANZAHL_PERSONEN` int(11) NOT NULL default '0',
  `GAST_ID` int(11) NOT NULL default '0',
  `TISCH_ID` varchar(100) NOT NULL default '0',
  PRIMARY KEY  (`RESERVIERUNG_ID`),
  KEY `FK_BOOKLINE_RESERVIERUNG_1` (`TISCH_ID`),
  KEY `FK_BOOKLINE_RESERVIERUNG_2` (`GAST_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_reservierungseinschraenkung`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG` (
  `RESERVIERUNGSEINSCHRAENKUNG_ID` int(11) NOT NULL auto_increment,
  `TISCHNUMMER` varchar(100) default NULL,
  `VON` varchar(12) default NULL,
  `BIS` varchar(12) default NULL,
  `TYP` varchar(100) default NULL,
  PRIMARY KEY  (`RESERVIERUNGSEINSCHRAENKUNG_ID`),
  KEY `FK_BOOKLINE_RESERVIERUNGSEINSCHRAENKUNG_1` (`TISCHNUMMER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_ruhetage`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_RUHETAGE` (
  `WOCHENTAG` int(11) NOT NULL default '0',
  `GASTRO_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`GASTRO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_session`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_SESSION` (
  `SESSION_ID` int(11) NOT NULL auto_increment,
  `ERSTELLUNG` varchar(12) NOT NULL default '',
  `BEZEICHNUNG` varchar(255) default NULL,
  `WERT` text,
  `HTTP_SESSION_ID` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`SESSION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_sprachen`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_SPRACHEN` (
  `SPRACHE_ID` char(2) NOT NULL default '',
  `BEZEICHNUNG` varchar(100) NOT NULL default '',
  `BILDER_ID` int(11) default '0',
  PRIMARY KEY  (`SPRACHE_ID`),
  KEY `FK_BOOKLINE_SPRACHEN_1` (`BILDER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_spr_gastro`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_SPR_GASTRO` (
  `GASTRO_ID` int(11) NOT NULL default '0',
  `SPRACHE_ID` char(2) NOT NULL default '',
  PRIMARY KEY  (`GASTRO_ID`,`SPRACHE_ID`),
  KEY `FK_BOOKLINE_SPR_GASTRO_2` (`SPRACHE_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_tisch`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_TISCH` (
  `TISCHNUMMER` varchar(100) NOT NULL default '',
  `BESCHREIBUNG` text,
  `MINIMALE_BELEGUNG` int(11) NOT NULL default '0',
  `MAXIMALE_BELEGUNG` int(11) NOT NULL default '0',
  `STATUS` varchar(100) NOT NULL default '',
  `RAUM_ID` int(11) NOT NULL default '0',
  `LEFT_POS` int(11) NOT NULL default '0',
  `TOP_POS` int(11) NOT NULL default '0',
  `WIDTH` int(11) NOT NULL default '100',
  `HEIGHT` int(11) NOT NULL default '100',
  `GRUPPENBEZEICHNUNG` varchar(255) null,
  `BILDER_ID` int(11) null,
  PRIMARY KEY  (`TISCHNUMMER`),
  KEY `FK_BOOKLINE_TISCH_1` (`RAUM_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_tischkarte`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_TISCHKARTE` (
  `TISCHKARTE_ID` int(11) NOT NULL auto_increment,
  `GASTRO_ID` int(11) NOT NULL default '1',
  `BILDER_ID` int(11) default NULL,
  PRIMARY KEY  (`TISCHKARTE_ID`),
  KEY `FK_BOOKLINE_TISCHKARTE_2` (`GASTRO_ID`),
  KEY `FK_BOOKLINE_TISCHKARTE_3` (`BILDER_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_tischkarte_properties`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_TISCHKARTE_PROPERTIES` (
  `PROPERTY_ID` int(11) NOT NULL auto_increment,
  `TISCHKARTE_ID` int(11) NOT NULL default '0',
  `LABEL` varchar(100) NOT NULL default '',
  `VALUE` text,
  PRIMARY KEY  (`PROPERTY_ID`),
  KEY `FK_BOOKLINE_TISCHKARTE_PROPERTIES_1` (`TISCHKARTE_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_uebersetzungen`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_UEBERSETZUNGEN` (
  `UEBERSETZUNGS_ID` int(11) NOT NULL auto_increment,
  `TEXT` text NOT NULL,
  `TEXT_STANDARD` text NOT NULL,
  `SPRACHE_ID` char(2) NOT NULL default '',
  `GASTRO_ID` int(11) default NULL,
  PRIMARY KEY  (`UEBERSETZUNGS_ID`),
  KEY `FK_BOOKLINE_UEBERSETZUNGEN_1` (`GASTRO_ID`),
  KEY `FK_BOOKLINE_UEBERSETZUNGEN_2` (`SPRACHE_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookline_uebersetzungen_frontpage`
--
CREATE TABLE IF NOT EXISTS `BOOKLINE_UEBERSETZUNGEN_FRONTPAGE` (
  `UEBERSETZUNGS_ID` int(11) NOT NULL auto_increment,
  `TEXT` text NOT NULL,
  `TEXT_STANDARD` text NOT NULL,
  `SPRACHE_ID` char(2) NOT NULL default '',
  `GASTRO_ID` int(11) default NULL,
  PRIMARY KEY  (`UEBERSETZUNGS_ID`),
  KEY `FK_BOOKLINE_UEBERSETZUNGEN_FRONTPAGE_1` (`GASTRO_ID`),
  KEY `FK_BOOKLINE_UEBERSETZUNGEN_FRONTPAGE_2` (`SPRACHE_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
