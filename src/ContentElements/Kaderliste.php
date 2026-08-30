<?php

declare(strict_types=1);

/**
 * Kaderlisten für Contao Open Source CMS
 *
 * @author    Frank Binding
 * @license   LGPL-3.0-or-later
 */

namespace Schachbulle\ContaoKaderlistenBundle\ContentElements;

use Contao\ContentElement;
use Contao\Database;
use Contao\StringUtil;

/**
 * Inhaltselement, das eine gespeicherte Kaderliste im Frontend ausgibt.
 *
 * Die Klasse erbt vom klassischen Contao-Inhaltselement statt vom
 * Fragment-Controller, weil `AbstractContentElementController` in Contao 4.13
 * und Contao 5 unterschiedliche Signaturen für `getResponse()` besitzt. Der
 * Weg über `ContentElement` läuft in beiden Fassungen unverändert.
 */
class Kaderliste extends ContentElement
{

	/**
	 * Name des Frontend-Templates
	 *
	 * @var string
	 */
	protected $strTemplate = 'ce_kaderliste';

	/**
	 * Baut die Daten für das Template auf.
	 *
	 * Der Ablauf besteht aus drei Schritten: Zuerst wird die Vorjahresliste
	 * gesucht, um für jeden Spieler die Kaderzugehörigkeit des Vorjahres in der
	 * Spalte "davor" ausgeben zu können. Danach werden die Einträge der
	 * gewählten Liste geladen, und zuletzt wird die Liste in der Reihenfolge der
	 * im Inhaltselement gewählten Kaderstufen sortiert. Die Sortierung geschieht
	 * bewusst in PHP und nicht per ORDER BY, weil die Reihenfolge der Kaderstufen
	 * (WK vor PK vor NK1 …) nicht der alphabetischen Reihenfolge entspricht.
	 *
	 * @return void
	 */
	protected function compile()
	{
		$objDatabase = Database::getInstance();

		// Vorhergehende Kaderliste ermitteln, dazu alle Kaderlisten laden
		$vorjahr = array(); // Enthält später die Kaderzuordnungen der Vorjahresliste
		$dwzSuffix = '';
		$eloSuffix = '';

		$objListen = $objDatabase->prepare("SELECT * FROM tl_kaderlisten ORDER BY year DESC, type")
		                         ->execute();

		if ($objListen)
		{
			$liste_vorjahr = false;
			$liste_typ = false;

			while ($objListen->next())
			{
				// Nach aktueller Liste suchen
				if ($objListen->id == $this->kaderliste_id)
				{
					// Liste gefunden, Parameter für vorhergehende Liste festlegen
					$liste_vorjahr = (int) $objListen->year - 1;
					$liste_typ = $objListen->type;
					// Suffixe sichern
					$dwzSuffix = (string) $objListen->dwzSuffix;
					$eloSuffix = (string) $objListen->eloSuffix;
				}

				// Nach Vorjahresliste suchen
				if ($liste_vorjahr == $objListen->year && $liste_typ == $objListen->type)
				{
					// Liste gefunden, jetzt Spielerdaten der Liste laden
					$objVorjahr = $objDatabase->prepare("SELECT * FROM tl_kaderlisten_items WHERE pid = ?")
					                          ->execute($objListen->id);

					if ($objVorjahr)
					{
						while ($objVorjahr->next())
						{
							// $vorjahr[ID des Spielers] = Kaderzuordnung (A, B, C, DC)
							$vorjahr[$objVorjahr->name_id] = $objVorjahr->type;
						}
					}

					break;
				}
			}
		}

		// Einträge der Liste laden
		$objListe = $objDatabase->prepare("SELECT ki.type AS type,
		                                          ki.id AS id,
		                                          ki.note AS note,
		                                          ki.nummer AS nummer,
		                                          ki.vorname AS vorname_alt,
		                                          ki.nachname AS nachname_alt,
		                                          ki.fidetitel AS fidetitel,
		                                          ki.elo AS elo,
		                                          ki.dwz AS dwz,
		                                          ki.landesverband AS landesverband,
		                                          ki.name_id AS name_id,
		                                          kn.firstname AS vorname,
		                                          kn.lastname AS nachname,
		                                          kn.birthyear AS jahrgang
		                                   FROM tl_kaderlisten_items AS ki,
		                                        tl_kaderlisten_namen AS kn
		                                   WHERE ki.name_id = kn.id
		                                         AND ki.pid=?
		                                         AND ki.published=?
		                                   ORDER BY ki.type,
		                                            ki.nummer,
		                                            ki.id,
		                                            ki.nachname,
		                                            ki.vorname")
		                        ->execute($this->kaderliste_id, 1);

		// Kadertypen aus Inhaltselement laden. StringUtil::deserialize() statt
		// unserialize(): Bei einem leeren Feld liefert unserialize() false, und
		// count(false) ist seit PHP 8.0 ein TypeError.
		$kadertypen = StringUtil::deserialize($this->kaderliste_stufen, true);

		if (0 === \count($kadertypen))
		{
			$kadertypen = array('A', 'B', 'C', 'DC');
		}

		// Übersetzungstabelle der Landesverbände einmalig holen
		$arrVerbaende = $GLOBALS['TL_LANG']['kaderlisten_landesverbaende'] ?? array();

		// Liste generieren
		$liste = array();

		if ($objListe)
		{
			while ($objListe->next())
			{
				if (!\in_array($objListe->type, $kadertypen))
				{
					continue;
				}

				$liste[] = array
				(
					'kader'         => $objListe->type,
					'nummer'        => $objListe->nummer ?: '',
					'url'           => '', //$this->addToUrl('kader='.$objListe->name_id),
					'name'          => ($objListe->nachname_alt . $objListe->vorname_alt) ? $objListe->vorname_alt . ' ' . $objListe->nachname_alt : $objListe->vorname . ' ' . $objListe->nachname,
					'jahrgang'      => $objListe->jahrgang,
					'verband_kurz'  => $objListe->landesverband,
					'verband_lang'  => $arrVerbaende[$objListe->landesverband] ?? '',
					'hinweis'       => $objListe->note,
					'fidetitel'     => $objListe->fidetitel,
					'elo'           => $objListe->elo ?: '',
					'dwz'           => $objListe->dwz ?: '',
					'vorjahr'       => $vorjahr[$objListe->name_id] ?? 'neu'
				);
			}
		}

		// Liste nach Kadertypen sortieren
		$neuliste = array();

		foreach ($kadertypen as $kadertyp)
		{
			foreach ($liste as $eintrag)
			{
				if ($eintrag['kader'] == $kadertyp)
				{
					$neuliste[] = $eintrag;
				}
			}
		}

		$this->Template->head = array
		(
			'dwzSuffix' => $dwzSuffix ? ' ' . $dwzSuffix : '',
			'eloSuffix' => $eloSuffix ? ' ' . $eloSuffix : ''
		);
		$this->Template->visibleElo = !$this->kaderliste_invisibleElo;
		$this->Template->visibleDWZ = !$this->kaderliste_invisibleDWZ;
		$this->Template->headline = $this->headline;
		$this->Template->liste = $neuliste;
	}

}
