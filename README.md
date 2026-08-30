# Kaderlisten

Erweiterung für Contao, die Kaderlisten von Schachspielern im Backend verwaltet
und im Frontend als Tabelle ausgibt.

**Frank Binding**

## Voraussetzungen

| | |
| --- | --- |
| Contao | 4.13 LTS oder 5.x |
| PHP | 8.1 bis 8.4 |
| Weitere Erweiterungen | `schachbulle/contao-spielerregister-bundle` |

## Installation

```
composer require schachbulle/contao-kaderlisten-bundle
```

Anschließend die Datenbank aktualisieren (Contao Manager oder
`vendor/bin/contao-console contao:migrate`).

## Aufbau

Die Erweiterung legt drei Tabellen an:

| Tabelle | Inhalt |
| --- | --- |
| `tl_kaderlisten` | Die Kaderliste selbst: Jahr, Titel, Art (Männer/Frauen), Gültigkeitszeitraum, Suffixe für DWZ und Elo |
| `tl_kaderlisten_items` | Die Spielereinträge einer Liste mit Kaderstufe, laufender Nummer, Landesverband, FIDE-Titel, DWZ und Elo |
| `tl_kaderlisten_namen` | Die registrierten Spieler, auf die sich die Einträge beziehen; hier lässt sich auch eine Verknüpfung ins Spielerregister setzen |

Das Backend-Modul heißt **Kaderlisten** und liegt in der Gruppe *Inhalte*.

## Benutzung

1. Unter *Kaderlisten* zunächst über die Schaltfläche **Registrierte Spieler**
   die Personen anlegen, die in Kaderlisten auftauchen sollen.
2. Eine Kaderliste anlegen und darin die Spieler mit ihrer Kaderstufe eintragen.
3. Im Seitenbaum ein Inhaltselement vom Typ **Kaderliste** einfügen, dort die
   gewünschte Liste auswählen und festlegen, welche Kaderstufen ausgegeben
   werden und ob DWZ und Elo sichtbar sein sollen.

In der Ausgabe zeigt die Spalte *davor* die Kaderstufe des Spielers aus der
Liste des Vorjahres; wer neu dazugekommen ist, erhält den Vermerk *neu*. Als
Vorjahresliste gilt die Liste mit demselben Typ und der um eins verringerten
Jahreszahl.

## Kaderstufen

`WK` Weltklassekader, `PK` Perspektivkader, `NK1` Nachwuchskader 1,
`NK2` Nachwuchskader 2 sowie die älteren Stufen `A`, `B`, `C` und `DC`.

## Vorlage anpassen

Das Frontend benutzt die Vorlage `ce_kaderliste`. Eine eigene Fassung wird wie
üblich unter `templates/` im Projekt abgelegt und überschreibt die mitgelieferte.

## Lizenz

LGPL-3.0-or-later, siehe [LICENSE](LICENSE).
