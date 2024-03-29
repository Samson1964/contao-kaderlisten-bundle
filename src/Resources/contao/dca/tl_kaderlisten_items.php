<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package News
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Table tl_kaderlisten_items
 */
$GLOBALS['TL_DCA']['tl_kaderlisten_items'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_kaderlisten',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'onsubmit_callback'           => array(array('tl_kaderlisten_items', 'saveForm')),
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
			'mode'                    => 4,
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
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['toggle'],
				'attributes'           => 'onclick="Backend.getScrollOffset()"',
				'haste_ajax_operation' => array
				(
					'field'            => 'published',
					'options'          => array
					(
						array('value' => '', 'icon' => 'invisible.svg'),
						array('value' => '1', 'icon' => 'visible.svg'),
					),
				),
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
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
			'flag'                    => 11,
			'inputType'               => 'select',
			'options'                 => array('A', 'B', 'C', 'DC'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['type_lang'],
			'eval'                    => array('submitOnChange'=>false,'tl_class'=>'w50'),
			'sql'                     => "varchar(2) NOT NULL default ''"
		),
		'nummer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_items']['nummer'],
			'sorting'                 => true,
			'flag'                    => 11,
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
			'flag'                    => 11,
			'inputType'               => 'text',
			'load_callback'           => array(array('tl_kaderlisten_items','loadVorname')),
			//'save_callback'           => array(array('tl_kaderlisten_items','saveVorname')),
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
			'flag'                    => 11,
			'inputType'               => 'text',
			'load_callback'           => array(array('tl_kaderlisten_items','loadNachname')),
			//'save_callback'           => array(array('tl_kaderlisten_items','saveNachname')),
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
			'options'                 => $GLOBALS['TL_LANG']['kaderlisten_landesverbaende'],
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
			'default'                 => 1,
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
	)
);


/**
 * Class tl_kaderlisten_items
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_kaderlisten_items extends Backend
{

	var $nummer = 0;

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Return the link picker wizard
	 * @param \DataContainer
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_'. $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
	}

	public function listPersons($arrRow)
	{
		//echo "<pre>";
		//print_r($arrRow);
		//echo "</pre>";
		$unpublished = $arrRow['published'] ? '' : 'color:#c33;';
		$temp = '<div class="tl_content_left" style="'.$unpublished.'"><b style="'.$unpublished.'">'.$arrRow['type'].'</b>';
		$temp .= ' <b style="'.$unpublished.'">'.$arrRow['nummer'].'</b>';
		if($arrRow['nachname']) $temp .= ' - '.$arrRow['nachname'].','.$arrRow['vorname'];
		else $temp .= ' ---';
		if($arrRow['name_id'])
		{
			$objRegister = $this->Database->prepare("SELECT * FROM tl_kaderlisten_namen WHERE id=?")->execute($arrRow['name_id']);
			if($objRegister->lastname == $arrRow['nachname'] && $objRegister->firstname == $arrRow['vorname'])
				$temp .= ' (<img src="bundles/contaokaderlisten/images/check.png" width="12"> '.$objRegister->lastname.','.$objRegister->firstname.' zugeordnet)';
			else
				$temp .= ' (<img src="bundles/contaokaderlisten/images/remove.png" width="12"> '.$objRegister->lastname.','.$objRegister->firstname.' zugeordnet)';
		}
		else
			$temp .= ' (<img src="bundles/contaokaderlisten/images/remove.png" width="12"> niemand zugeordnet)';
		return $temp.'</div>';
	}

	public function getNamenliste(DataContainer $dc)
	{
		$array = array();
		$objRegister = $this->Database->prepare("SELECT * FROM tl_kaderlisten_namen ORDER BY lastname,firstname ASC ")->execute();
		$array = array();
		while($objRegister->next())
		{
			//$array[] = array($objRegister->id => $objRegister->firstname.' '.$objRegister->lastname.' ('.$objRegister->birthyear.')');
			$array[$objRegister->id] = $objRegister->firstname.' '.$objRegister->lastname.' ('.$objRegister->birthyear.')';
		}
		return $array;

	}

	public function loadVorname($varValue, DataContainer $dc)
	{
		// Füllt Vorname aus, wenn leer und ein Spieler ausgewählt wurde
		if($dc->activeRecord->name_id && trim($varValue) == '')
		{
			$objRegister = $this->Database->prepare("SELECT * FROM tl_kaderlisten_namen WHERE id = ?")
			                              ->limit(1)
			                              ->execute($dc->activeRecord->name_id);
			$varValue = $objRegister->firstname;
		}
		
		return $varValue;
	}

	public function saveVorname($varValue, DataContainer $dc)
	{
		return $varValue.' ';
	}

	public function loadNachname($varValue, DataContainer $dc)
	{
		// Füllt Nachname aus, wenn leer und ein Spieler ausgewählt wurde
		if($dc->activeRecord->name_id && trim($varValue) == '')
		{
			$objRegister = $this->Database->prepare("SELECT * FROM tl_kaderlisten_namen WHERE id = ?")  
			                              ->limit(1)
			                              ->execute($dc->activeRecord->name_id);
			$varValue = $objRegister->lastname;
		}

		return $varValue;
	}

	public function saveNachname($varValue, DataContainer $dc)
	{
		return $varValue.' ';
	}

	public function saveForm(DataContainer $dc)
	{
		log_message('function saveForm','kaderlisten.log');
		log_message(print_r($dc->activeRecord, true),'kaderlisten.log');
		return;
	}

}
