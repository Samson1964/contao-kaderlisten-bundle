<?php

/**
 * Paletten
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['kaderlisten'] = '{type_legend},type,headline;{kaderliste_legend},kaderliste_id,kaderliste_invisibleDWZ,kaderliste_invisibleElo;{protected_legend:hide},protected;{expert_legend:hide},guest,cssID,space;{invisible_legend:hide},invisible,start,stop';

/**
 * Felder
 */

// Adressenliste anzeigen
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

/*****************************************
 * Klasse tl_content_kaderliste
 *****************************************/

class tl_content_kaderliste extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Funktion editAdresse
	 * @param \DataContainer
	 * @return string
	 */
	public function getKaderliste(DataContainer $dc)
	{
		$array = array();
		$objListe = $this->Database->prepare("SELECT * FROM tl_kaderlisten ORDER BY title ASC")->execute();
		while($objListe->next())
		{
			$array[$objListe->id] = $objListe->title;
		}
		return $array;

	}

}
