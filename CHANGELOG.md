# Kaderlisten Changelog

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
