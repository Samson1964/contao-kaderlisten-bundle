<?php

namespace Schachbulle\ContaoKaderlistenBundle\ContentElements;

class Kaderliste extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_kaderliste';

	/**
	 * Generate the Content Element
	 */
	protected function compile()
	{

		// Vorhergehende Kaderliste ermitteln, dazu alle Kaderlisten laden
		$objListen = $this->Database->prepare("SELECT * FROM tl_kaderlisten ORDER BY year DESC, type")
		                            ->execute();
		if($objListen)
		{
			$vorjahr = array(); // Enthält später die Spielerdaten der Vorjahresliste
			$liste_vorjahr = false;
			$liste_typ = false;
			while($objListen->next())
			{
				// Nach aktueller Liste suchen
				if($objListen->id == $this->kaderliste_id)
				{
					// Liste gefunden, Parameter für vorhergehende Liste festlegen
					$liste_vorjahr = $objListen->year - 1;
					$liste_typ = $objListen->type;
					// Suffixe sichern
					$dwzSuffix = $objListen->dwzSuffix;
					$eloSuffix = $objListen->eloSuffix;
				}
				// Nach Vorjahresliste suchen
				if($liste_vorjahr == $objListen->year && $liste_typ == $objListen->type)
				{
					// Liste gefunden, jetzt Spielerdaten der Liste laden
					$objVorjahr = $this->Database->prepare("SELECT * FROM tl_kaderlisten_items WHERE pid = ?")
					                             ->execute($objListen->id);
					if($objVorjahr)
					{
						while($objVorjahr->next())
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
		$objListe = $this->Database->prepare("SELECT ki.type AS type,
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
		// Liste generieren
		$liste = array();
		if($objListe)
		{
			while($objListe->next())
			{
				$liste[] = array
				(
					'kader'         => $objListe->type,
					'nummer'        => $objListe->nummer ? $objListe->nummer : '',
					'url'           => '', //$this->addToUrl('kader='.$objListe->name_id),
					'name'          => ($objListe->nachname_alt.$objListe->vorname_alt) ? $objListe->vorname_alt.' '.$objListe->nachname_alt : $objListe->vorname.' '.$objListe->nachname,
					'jahrgang'      => $objListe->jahrgang,
					'verband_kurz'  => $objListe->landesverband,
					'verband_lang'  => $GLOBALS['TL_LANG']['kaderlisten_landesverbaende'][$objListe->landesverband],
					'hinweis'       => $objListe->note,
					'fidetitel'     => $objListe->fidetitel,
					'elo'           => $objListe->elo ? $objListe->elo : '',
					'dwz'           => $objListe->dwz ? $objListe->dwz : '',
					'vorjahr'       => $vorjahr[$objListe->name_id] ? $vorjahr[$objListe->name_id] : 'neu'
				);
			}
		}

		$this->Template->head = array
		(
			'dwzSuffix' => $dwzSuffix ? ' '.$dwzSuffix : '',
			'eloSuffix' => $eloSuffix ? ' '.$eloSuffix : ''
		);
		$this->Template->visibleElo = $this->kaderliste_invisibleElo ? false : true;
		$this->Template->visibleDWZ = $this->kaderliste_invisibleDWZ ? false : true;
		$this->Template->headline = $this->headline;
		$this->Template->liste = $liste;
		return;

	}

}
