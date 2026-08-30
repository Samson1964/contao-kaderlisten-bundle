# Kaderlisten Changelog

## Version 2.0.0 (2026-08-30)

* Add: Contao 5 wird unterstützt, die Erweiterung läuft jetzt unter Contao 4.13 und Contao 5 mit PHP 8.1 bis 8.4
* Change: `composer.json` -> `contao/core-bundle: ^4.13 || ^5.0` und `php: ^8.1`; die Abhängigkeit `codefog/contao-haste` und die tote Entwicklungsabhängigkeit `doctrine/doctrine-cache-bundle` sind entfallen
* Change: Umschalter „veröffentlicht“ in tl_kaderlisten, tl_kaderlisten_items und tl_kaderlisten_namen läuft über den Kern (`act=toggle&field=published` samt `'toggle' => true` am Feld) statt über den Haste-Toggler
* Change: `'dataContainer' => DC_Table::class` statt des Kurznamens `'Table'`, den Contao 5 nicht mehr auflöst
* Change: Alle Klassen werden voll qualifiziert angesprochen (`Contao\Backend`, `Contao\DataContainer`, `Contao\Database`, `Contao\Image`, `Contao\System`, `Contao\ContentElement`); Contao 5 kennt die globalen Klassenaliasse nicht mehr
* Change: Zahlenwerte für `mode` und `flag` durch die Konstanten von `DataContainer` ersetzt, Symbole von `.gif` auf `.svg` umgestellt
* Change: Landesverbände kommen über `options_callback` statt über eine feste `options`-Liste, damit die Auswahl auch dann gefüllt ist, wenn die Sprachdateien beim Einlesen des Data Containers noch nicht geladen sind
* Change: `tl_content.php` lädt die Sprachdatei `tl_kaderlisten_items` nach, damit die Bezeichnungen der Kaderstufen im Inhaltselement erscheinen
* Fix: Fatal error unter Contao 5, weil `src/Resources/contao/config/config.php` mit `if (!defined('TL_ROOT')) die(...)` begann — die Konstante gibt es dort nicht mehr
* Fix: Fatal error in der Kaderübersicht eines registrierten Spielers unter Contao 5: Die Konstanten `VERSION` und `REQUEST_TOKEN` sind entfallen, das Sicherheitsmerkmal kommt jetzt aus `contao.csrf.token_manager`
* Fix: `onsubmit_callback` in tl_kaderlisten_items entfernt; er schrieb nur über `log_message()` ins Protokoll, und diese Funktion gibt es in Contao 5 nicht mehr
* Fix: Parse error im Template `ce_kaderliste.html5` -> der Hinweis hinter dem Namen wurde mit der kurzen Auszeichnung `<? endif; ?>` beendet, die nur bei eingeschaltetem `short_open_tag` funktioniert
* Fix: Fatal error „count(): Argument #1 must be of type Countable|array, bool given“ im Inhaltselement, wenn keine Kaderstufe ausgewählt war -> `StringUtil::deserialize()` statt `unserialize()`
* Fix: Zeilen der Kaderliste im Frontend wechselten die Farbe nicht -> `isset($class) == 'odd'` lieferte immer denselben Wert
* Fix: Palette des Inhaltselements enthielt die Felder `guest` und `space` aus Contao 3, die es weder in 4.13 noch in 5 gibt
* Fix: Sprachdatei `modules.php` war nicht UTF-8-kodiert
* Change: `services.yml` verweist nicht mehr auf `Symfony\Component\DependencyInjection\ContainerAwareInterface`, das in Symfony 7 (Contao 5.7) entfernt wurde
* Change: Toter Code entfernt — `pagePicker()` aus Contao 2, die ungenutzten Callbacks `saveVorname()`/`saveNachname()` sowie die leere Callback-Klasse `tl_kaderlisten`
* Change: Alle Funktionen und Methoden mit deutschen Kommentarblöcken versehen

## Version 1.5.2 (2026-07-29)

* Fix: Warning: Undefined array key "deleteConfirm", "kaderlisten_landesverbaende" bei contao:migrate -> Lesezugriffe auf $GLOBALS['TL_LANG'] in den DCA-Dateien mit `?? null` bzw. `?? array()` abgesichert, da der DcaLoader die Sprachdateien noch nicht geladen hat
* Change: Beschreibung, Keywords und Homepage in der composer.json ergänzt, damit Packagist das Paket verständlich darstellt und über die Suche auffindbar macht

## Version 1.5.1 (2025-12-17)

* Fix: Warning: Undefined array key "" in src/ContentElements/Kaderliste.php (line 107) -> wenn kein Landesverband definiert ist
* Fix: Sortierung nach Kadertyp (WK, PK, A, B usw.) im Inhaltselement wird ignoriert

## Version 1.5.0 (2025-12-16)

* Add: Neue Kadertypen -> WK = Weltklassekader, PK = Perspektivkader, NK 1 = Nachwuchskader 1, NK 2 = Nachwuchskader 2
* Change: tl_kaderlisten_items.type -> varchar(3) statt varchar(2)

## Version 1.4.3 (2024-12-20)

* Add: tl_content.kaderlisten_stufen -> Nur bestimmte Kader ausgeben
* Fix: Warning: Undefined variable $dwzSuffix in src/ContentElements/Kaderliste.php (line 111) 
* Fix: Warning: Undefined array key 339 in src/ContentElements/Kaderliste.php (line 112) 
* Fix: Warning: Undefined variable $class in src/Resources/contao/templates/ce_kaderliste.html5 (line 18) 

## Version 1.4.2 (2024-12-16)

* Add: FIDE-Titel, DWZ und Elo in Kaderliste Backend anzeigen

## Version 1.4.1 (2022-12-01)

* Change: Anpassungen PHP 8 wegen undefinierter Variablen
* Add: Abhängigkeit codefog/contao-haste
* Change: Toggle-Funktion durch Haste-Toggler ersetzt
* Change: Verbesserungen in der Listenansicht der registrierten Spieler

## Version 1.4.0 (2022-11-29)

* Add: Freigabe für PHP 8

## Version 1.3.1 (2022-11-23)

* Fix: In den Spielerdetails werden die Kaderzugehörigkeiten falsch sortiert -> ORDER hat in SQL-Abfrage gefehlt

## Version 1.3.0 (2021-12-09)

* Add: tl_content Möglichkeit die Spalten DWZ und Elo auszublenden

## Version 1.2.2 (2019-12-15)

* Fix: load_callback in tl_kaderlisten_items.vorname und tl_kaderlisten_items.nachname hat Werte nicht abgespeichert - alwaysSave = true in eval war erforderlich

## Version 1.2.1 (2019-12-08)

* Fix: Klasse Kaderliste.php von Classes nach ContentElements verschoben
* Fix: Bei DWZ/Elo wurde die Suffix vom Vorjahr angezeigt
* Change: tl_kaderlisten_items.vorname und tl_kaderlisten_items.nachname von 255 auf 40 Zeichen gekürzt

## Version 1.2.0 (2019-10-29)

* Add: Kaderliste BE - Bei inaktivem Spieler Zeile rot machen (funktioniert im Moment nur bei Reload)
* Kaderlisten-Übersicht BE: Sortierung hinzugefügt auf/ab nach Jahr
* Kaderlisten-Übersicht BE: von-bis-Spalten hinzugefügt
* Frontend: Sortierung der Kaderliste nach Kadertyp ASC, Nummer ASC und jetzt zusätzlich nach ID ASC
* Fix Registrierte Spieler: Kaderzugehörigkeiten CSS-Klasse widget ergänzt
* Add: Ausgabe von FIDE-Titel, Elo und DWZ bei den Kaderzugehörigkeiten im Backend
* Add Registrierte Spieler: Hinweisfeld hinzugefügt, z.B. bei Namensänderungen
* Add Kaderspieler: Hinweisfeld hinzugefügt, z.B. bei Namensänderungen (für das Frontend)
* Ausgabe des Hinweises aus der Kaderspielerliste im Frontend

## Version 1.1.0 (2019-10-28)

* Fix Kadereingabe: Übersetzung comment fehlte
* Fix Spieler registrieren: Eintrag Spielerregister nicht neu laden bei Änderung
* Fix Spieler registrieren: Einträge Spielerregister -> Helper-Funktion nutzen
* Add Template: CSS-Klasse odd/even hinzugefügt
* Add Kaderliste BE: Sortieren nach Kader + Nummer als Standard, danach Nachname + Vorname
* Add Template: Landesverband beim Hovern mit der Maus anzeigen
* Change: Lokales Landesverbände-Array durch globales Array ersetzt
* Fix Kaderliste BE: Statt des alternativen Namens wurde nur der zugeordnete registrierte Spieler angezeigt

## Version 1.0.0 (2019-10-27)

* Übersehene Fehler bei Migration beseitigt
* Abhängigkeit Spielerregister hinzugefügt
* Suffixe für Kopfspalten DWZ/Elo hinzugefügt

## Version 0.0.1 (2019-10-27)

* Übernahme Entwickler-Version von Contao 3 als Contao-4-Bundle
