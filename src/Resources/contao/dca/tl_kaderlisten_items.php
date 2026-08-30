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
use Contao\DC_Table;

/**
 * Tabelle tl_kaderlisten_items
 */
$GLOBALS['TL_DCA']['tl_kaderlisten_items'] = array
(

	// Config
	'config' => array
	(
		// Ab Contao 5 ist nur noch der voll qualifizierte Klassenname erlaubt.
		'dataContainer'               => DC_Table::class,
		'ptable'                      => 'tl_kaderlisten',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => DataContainer::MODE_PARENT,
			'fields'                  => array('type ASC', 'nummer ASC', 'nachname ASC'),
			'headerFields'            => array('year', 'title', 'fromDate', 'toDate'),
			'panelLayout'             => 'filter;sort,search,limit',
			'disableGrouping'         => true,
			'child_record_callback'   => array('tl_kaderlisten_items', 'listPersons'),
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
			),
			// Umschalter des Kerns statt des Haste-Togglers, siehe tl_kaderlisten.
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['toggle'],
				'href'                => 'act=toggle&amp;field=published',
				'icon'                => 'visible.svg',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{type_legend},type,nummer;{listen_legend},name_id;{name_legend},vorname,nachname;{options_legend},landesverband,fidetitel,dwz,elo;{comment_legend},note,comment;{publish_legend},published'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_kaderlisten.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['type'],
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_ASC,
			'inputType'               => 'select',
			'options'                 => array('WK', 'PK', 'NK1', 'NK2', 'A', 'B', 'C', 'DC'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['type_lang'],
			'eval'                    => array('submitOnChange'=>false,'tl_class'=>'w50'),
			'sql'                     => "varchar(3) NOT NULL default ''"
		),
		'nummer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['nummer'],
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_ASC,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'maxlength'=>3, 'tl_class'=>'w50'),
			'sql'                     => "int(3) unsigned NOT NULL default '0'"
		),
		'name_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['name_id'],
			'exclude'                 => true,
			'options_callback'        => array('tl_kaderlisten_items', 'getNamenliste'),
			'inputType'               => 'select',
			'eval'                    => array
			(
				'includeBlankOption'  => true,
				'mandatory'           => false,
				'multiple'            => false,
				'chosen'              => true,
				'submitOnChange'      => true,
				'tl_class'            => 'long'
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'vorname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['vorname'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_ASC,
			'inputType'               => 'text',
			'load_callback'           => array(array('tl_kaderlisten_items','loadVorname')),
			'eval'                    => array
			(
				'maxlength'           => 40,
				'alwaysSave'          => true,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(40) NOT NULL default ''"
		),
		'nachname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['nachname'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_ASC,
			'inputType'               => 'text',
			'load_callback'           => array(array('tl_kaderlisten_items','loadNachname')),
			'eval'                    => array
			(
				'maxlength'           => 40,
				'alwaysSave'          => true,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(40) NOT NULL default ''"
		),
		'landesverband' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['landesverband'],
			'exclude'                 => true,
			'default'                 => '',
			'inputType'               => 'select',
			// Als Callback statt als feste 'options'-Liste: Beim Einlesen der
			// DCA-Datei sind die Sprachdateien noch nicht zwingend geladen, die
			// Auswahl wäre dann leer. Der Callback läuft erst beim Rendern.
			'options_callback'        => array('tl_kaderlisten_items', 'getLandesverbaende'),
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'includeBlankOption'  => true
			),
			'sql'                     => "varchar(2) NOT NULL default ''"
		),
		'fidetitel' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['fidetitel'],
			'exclude'                 => true,
			'default'                 => '',
			'inputType'               => 'select',
			'options'                 => array('GM', 'IM', 'WGM', 'FM', 'WIM', 'CM', 'WFM', 'WCM'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['fidetitel_list'],
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'includeBlankOption'  => true
			),
			'sql'                     => "varchar(3) NOT NULL default ''"
		),
		'dwz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['dwz'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50', 'maxlength'=>4),
			'sql'                     => "int(4) unsigned NOT NULL default '0'"
		),
		'elo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['elo'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50', 'maxlength'=>4),
			'sql'                     => "int(4) unsigned NOT NULL default '0'"
		),
		'note' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['note'],
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'comment' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['comment'],
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['published'],
			'toggle'                  => true,
			'default'                 => 1,
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
	)
);


/**
 * Stellt die Callbacks des Data Containers tl_kaderlisten_items bereit.
 *
 * Die Klasse erbt von Contao\Backend statt vom früheren globalen Alias
 * `Backend`, den Contao 5 nicht mehr registriert.
 */
class tl_kaderlisten_items extends Backend
{

	/**
	 * Baut die Beschriftung eines Spielereintrags in der Listenansicht.
	 *
	 * Ausgegeben werden Kaderstufe, laufende Nummer und Name. Dahinter steht,
	 * ob der Eintrag einem registrierten Spieler zugeordnet ist: ein Häkchen,
	 * wenn der im Eintrag hinterlegte Name mit dem des registrierten Spielers
	 * übereinstimmt, sonst ein Kreuz. Unveröffentlichte Einträge werden rot
	 * dargestellt.
	 *
	 * @param array $arrRow Datensatz der Zeile aus tl_kaderlisten_items
	 *
	 * @return string HTML des Listeneintrags
	 */
	public function listPersons($arrRow)
	{
		$unpublished = $arrRow['published'] ? '' : 'color:#c33;';
		$temp = '<div class="tl_content_left" style="' . $unpublished . '"><b style="' . $unpublished . '">' . $arrRow['type'] . '</b>';
		$temp .= ' <b style="' . $unpublished . '">' . $arrRow['nummer'] . '</b>';

		if ($arrRow['nachname'])
		{
			$temp .= ' - ' . $arrRow['nachname'] . ',' . $arrRow['vorname'];
		}
		else
		{
			$temp .= ' ---';
		}

		if ($arrRow['name_id'])
		{
			$objRegister = Database::getInstance()->prepare("SELECT * FROM tl_kaderlisten_namen WHERE id=?")
			                                      ->execute($arrRow['name_id']);

			if ($objRegister->lastname == $arrRow['nachname'] && $objRegister->firstname == $arrRow['vorname'])
			{
				$temp .= ' (<img src="bundles/contaokaderlisten/images/check.png" width="12"> ' . $objRegister->lastname . ',' . $objRegister->firstname . ' zugeordnet)';
			}
			else
			{
				$temp .= ' (<img src="bundles/contaokaderlisten/images/remove.png" width="12"> ' . $objRegister->lastname . ',' . $objRegister->firstname . ' zugeordnet)';
			}
		}
		else
		{
			$temp .= ' (<img src="bundles/contaokaderlisten/images/remove.png" width="12"> niemand zugeordnet)';
		}

		// FIDE-Titel, Elo und DWZ ausgeben
		if ($arrRow['fidetitel'])
		{
			$temp .= ' | <span>' . $arrRow['fidetitel'] . '</span>';
		}

		if ($arrRow['elo'])
		{
			$temp .= ' |  <span>Elo ' . $arrRow['elo'] . '</span>';
		}

		if ($arrRow['dwz'])
		{
			$temp .= ' |  <span>DWZ ' . $arrRow['dwz'] . '</span>';
		}

		return $temp . '</div>';
	}

	/**
	 * Liefert die Auswahlliste aller registrierten Spieler.
	 *
	 * @param DataContainer $dc Data Container des bearbeiteten Eintrags,
	 *                          wird nicht ausgewertet
	 *
	 * @return array Zuordnung "ID des registrierten Spielers" => "Vorname
	 *               Nachname (Jahrgang)"; leer, wenn noch niemand registriert ist
	 */
	public function getNamenliste(DataContainer $dc)
	{
		$array = array();

		$objRegister = Database::getInstance()->prepare("SELECT * FROM tl_kaderlisten_namen ORDER BY lastname, firstname ASC")
		                                      ->execute();

		while ($objRegister->next())
		{
			$array[$objRegister->id] = $objRegister->firstname . ' ' . $objRegister->lastname . ' (' . $objRegister->birthyear . ')';
		}

		return $array;
	}

	/**
	 * Liefert die Auswahlliste der Landesverbände.
	 *
	 * Die Bezeichnungen stammen aus der Sprachdatei default.php. Der Umweg über
	 * einen Callback ist nötig, weil die Sprachdateien beim Einlesen der
	 * DCA-Datei noch nicht geladen sein müssen — etwa bei contao:migrate.
	 *
	 * @param DataContainer|null $dc Data Container des bearbeiteten Eintrags,
	 *                               wird nicht ausgewertet
	 *
	 * @return array Zuordnung "Kürzel" => "Name des Landesverbandes"; leer, wenn
	 *               die Sprachdatei nicht geladen werden konnte
	 */
	public function getLandesverbaende($dc = null)
	{
		return $GLOBALS['TL_LANG']['kaderlisten_landesverbaende'] ?? array();
	}

	/**
	 * Übernimmt den Vornamen des zugeordneten Spielers, wenn das Feld leer ist.
	 *
	 * @param mixed         $varValue Bisheriger Feldwert
	 * @param DataContainer $dc       Data Container des bearbeiteten Eintrags
	 *
	 * @return mixed Der unveränderte Wert, oder der Vorname aus
	 *               tl_kaderlisten_namen, wenn das Feld leer war und ein
	 *               registrierter Spieler zugeordnet ist
	 */
	public function loadVorname($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->name_id && trim((string) $varValue) === '')
		{
			$objRegister = Database::getInstance()->prepare("SELECT * FROM tl_kaderlisten_namen WHERE id = ?")
			                                      ->limit(1)
			                                      ->execute($dc->activeRecord->name_id);

			$varValue = $objRegister->firstname;
		}

		return $varValue;
	}

	/**
	 * Übernimmt den Nachnamen des zugeordneten Spielers, wenn das Feld leer ist.
	 *
	 * @param mixed         $varValue Bisheriger Feldwert
	 * @param DataContainer $dc       Data Container des bearbeiteten Eintrags
	 *
	 * @return mixed Der unveränderte Wert, oder der Nachname aus
	 *               tl_kaderlisten_namen, wenn das Feld leer war und ein
	 *               registrierter Spieler zugeordnet ist
	 */
	public function loadNachname($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->name_id && trim((string) $varValue) === '')
		{
			$objRegister = Database::getInstance()->prepare("SELECT * FROM tl_kaderlisten_namen WHERE id = ?")
			                                      ->limit(1)
			                                      ->execute($dc->activeRecord->name_id);

			$varValue = $objRegister->lastname;
		}

		return $varValue;
	}

}
