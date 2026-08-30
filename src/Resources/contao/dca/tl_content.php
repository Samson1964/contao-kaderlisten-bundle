<?php

/**
 * Kaderlisten für Contao Open Source CMS
 *
 * @author    Frank Binding
 * @license   LGPL-3.0-or-later
 */

use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;
use Contao\System;

// Die Bezeichnungen der Kaderstufen stehen in der Sprachdatei von
// tl_kaderlisten_items und werden weiter unten als 'reference' benutzt.
System::loadLanguageFile('tl_kaderlisten_items');

/**
 * Paletten
 *
 * Die Felder 'guest' und 'space' sind entfallen: Sie stammen aus Contao 3 und
 * existieren weder in Contao 4.13 (dort heißt das Feld 'guests') noch in
 * Contao 5, wo die Gästefunktion ganz weggefallen ist.
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['kaderlisten'] = '{type_legend},type,headline;{kaderliste_legend},kaderliste_id,kaderliste_invisibleDWZ,kaderliste_invisibleElo,kaderliste_stufen;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';

/**
 * Felder
 */

// Auszugebende Kaderliste
$GLOBALS['TL_DCA']['tl_content']['fields']['kaderliste_id'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['kaderliste_id'],
	'exclude'                 => true,
	'options_callback'        => array('tl_content_kaderliste', 'getKaderliste'),
	'inputType'               => 'select',
	'eval'                    => array
	(
		'mandatory'           => false,
		'multiple'            => false,
		'chosen'              => true,
		'submitOnChange'      => false,
		'tl_class'            => 'long'
	),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['kaderliste_invisibleDWZ'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['kaderliste_invisibleDWZ'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkbox',
	'eval'                    => array
	(
		'tl_class'            => 'w50'
	),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['kaderliste_invisibleElo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['kaderliste_invisibleElo'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkbox',
	'eval'                    => array
	(
		'tl_class'            => 'w50'
	),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['kaderliste_stufen'] = array
(
	'label'                => &$GLOBALS['TL_LANG']['tl_content']['kaderliste_stufen'],
	'exclude'              => true,
	'default'              => 'a:4:{i:0;s:2:"WK";i:1;s:2:"PK";i:2;s:3:"NK1";i:3;s:3:"NK2";}',
	'options'              => array('WK', 'PK', 'NK1', 'NK2', 'A', 'B', 'C', 'DC'),
	'reference'            => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['type_lang'],
	'inputType'            => 'checkboxWizard',
	'eval'                 => array
	(
		'mandatory'        => false,
		'multiple'         => true,
		'tl_class'         => 'clr w50'
	),
	'sql'                  => "blob NULL",
);

/**
 * Stellt die Callbacks des Inhaltselements bereit.
 *
 * Die Klasse erbt von Contao\Backend statt vom früheren globalen Alias
 * `Backend`, den Contao 5 nicht mehr registriert.
 */
class tl_content_kaderliste extends Backend
{

	/**
	 * Liefert die Auswahlliste aller angelegten Kaderlisten.
	 *
	 * @param DataContainer $dc Data Container des Inhaltselements, wird nicht
	 *                          ausgewertet
	 *
	 * @return array Zuordnung "ID der Kaderliste" => "Titel"; leer, wenn noch
	 *               keine Kaderliste angelegt wurde
	 */
	public function getKaderliste(DataContainer $dc)
	{
		$array = array();

		$objListe = Database::getInstance()->prepare("SELECT * FROM tl_kaderlisten ORDER BY title ASC")
		                                   ->execute();

		while ($objListe->next())
		{
			$array[$objListe->id] = $objListe->title;
		}

		return $array;
	}

}
