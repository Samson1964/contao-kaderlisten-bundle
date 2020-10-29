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
 * Table tl_kaderlisten_namen
 */
$GLOBALS['TL_DCA']['tl_kaderlisten_namen'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'flag'                    => 1,
			'fields'                  => array('lastname ASC'),
			'panelLayout'             => 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'                  => array('lastname', 'firstname', 'birthyear', 'spielerregister_id'),
			'showColumns'             => true,
			'format'                  => '%s %s %s',
		),
		'global_operations' => array
		(
			'kaderlisten' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['kaderlisten'],
				'href'                => 'table=tl_kaderlisten',
				'icon'                => 'bundles/contaokaderlisten/images/icon_16.png',
			),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_kaderlisten_namen', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},firstname,lastname;{live_legend},birthyear;{kader_legend},kader;{register_legend},spielerregister_id;{comment_legend},note;{publish_legend},published'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'firstname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['firstname'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'lastname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['lastname'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'birthyear' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['birthyear'],
			'exclude'                 => true,
			'search'                  => true,
			'default'                 => date('Y'),
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false,
				'maxlength'           => 4,
				'tl_class'            => 'w50',
				'rgxp'                => 'alnum'
			),
			'sql'                     => "int(4) unsigned NOT NULL default '0'"
		),
		// Gibt die Kaderzugehörigkeiten aus
		'kader' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['kader'],
			'input_field_callback'    => array('tl_kaderlisten_namen', 'getKader'),
		),
		'spielerregister_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['spielerregister_id'],
			'exclude'                 => true,
			'options_callback'        => array('\Schachbulle\ContaoSpielerregisterBundle\Klassen\Helper', 'getRegister'),
			'inputType'               => 'select',
			'eval'                    => array
			(
				'mandatory'           => false,
				'multiple'            => false,
				'chosen'              => true,
				'submitOnChange'      => false,
				'includeBlankOption'  => true,
				'tl_class'            => 'long'
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'note' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['note'],
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['published'],
			'default'                 => 1,
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
	)
);


/**
 * Class tl_kaderlisten_namen
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_kaderlisten_namen extends Backend
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

	public function getKader(DataContainer $dc)
	{

		// Link-Prefixe generieren, ab C4 ist das ein symbolischer Link zu "contao"
		if(version_compare(VERSION, '4.0', '>='))
		{
			$linkprefix = \System::getContainer()->get('router')->generate('contao_backend');
			$imageEditHeader = \Image::getHtml('header.svg', 'Kaderliste %s bearbeiten');
			$imageEdit = \Image::getHtml('edit.svg', 'Spielereintrag %s in der Kaderliste bearbeiten');
		}
		else
		{
			$linkprefix = 'contao/main.php';
			$imageEditHeader = \Image::getHtml('header.gif', 'Kaderliste %s bearbeiten');
			$imageEdit = \Image::getHtml('edit.gif', 'Spielereintrag %s in der Kaderliste bearbeiten');
		}

		$spieler_id = $dc->activeRecord->id;

		$objRegister = $this->Database->prepare("SELECT k.id AS listen_id, k.year, k.type, k.title, i.fidetitel, i.elo, i.dwz, i.nachname, i.vorname, i.id AS item_id, i.type AS item_type FROM tl_kaderlisten_items AS i, tl_kaderlisten AS k WHERE i.pid = k.id AND i.name_id=?")->execute($spieler_id);
		//$ausgabe = '<div class="tl_listing_container list_view">';
		$ausgabe = '<div class="long widget">'; // Wichtig damit das Auf- und Zuklappen funktioniert
		$ausgabe .= '<table class="tl_listing showColumns">';
		$ausgabe .= '<tbody><tr>';
		$ausgabe .= '<th class="tl_folder_tlist">Kaderliste</th>';
		$ausgabe .= '<th class="tl_folder_tlist">Listenname</th>';
		$ausgabe .= '<th class="tl_folder_tlist">Kader</th>';
		$ausgabe .= '<th class="tl_folder_tlist">Alternativer Name</th>';
		$ausgabe .= '<th class="tl_folder_tlist">Titel</th>';
		$ausgabe .= '<th class="tl_folder_tlist">Elo</th>';
		$ausgabe .= '<th class="tl_folder_tlist">DWZ</th>';
		$ausgabe .= '<th class="tl_folder_tlist tl_right_nowrap">&nbsp;</th>';
		$ausgabe .= '</tr>';
		$oddeven = 'odd';
		while($objRegister->next())
		{
			$liste = $objRegister->year.'-'.strtoupper($objRegister->type);
			$oddeven = $oddeven == 'odd' ? 'even' : 'odd';
			$ausgabe .= '<tr class="'.$oddeven.'" onmouseover="Theme.hoverRow(this,1)" onmouseout="Theme.hoverRow(this,0)">';
			$ausgabe .= '<td class="tl_file_list">'.$liste.'</td>';
			$ausgabe .= '<td class="tl_file_list">'.$objRegister->title.'</td>';
			$ausgabe .= '<td class="tl_file_list">'.$objRegister->item_type.'</td>';
			$ausgabe .= '<td class="tl_file_list">'.$objRegister->nachname . ',' . $objRegister->vorname.'</td>';
			$ausgabe .= '<td class="tl_file_list">'.$objRegister->fidetitel.'</td>';
			$ausgabe .= '<td class="tl_file_list">'.($objRegister->elo ? $objRegister->elo : '').'</td>';
			$ausgabe .= '<td class="tl_file_list">'.($objRegister->dwz ? $objRegister->dwz : '').'</td>';
			$ausgabe .= '<td class="tl_file_list tl_right_nowrap">';
			$ausgabe .= '<a href="'.$linkprefix.'?do=kaderlisten&amp;table=tl_kaderlisten_items&amp;act=edit&amp;id='.$objRegister->item_id.'&amp;popup=1&amp;rt='.REQUEST_TOKEN.'" onclick="Backend.openModalIframe({\'width\':768,\'title\':\'Eintrag '.$objRegister->item_id.' in Kaderliste '.$liste.' bearbeiten\',\'url\':this.href});return false">'.$imageEdit.'</a>';
			$ausgabe .= '<a href="'.$linkprefix.'?do=kaderlisten&amp;table=tl_kaderlisten&amp;act=edit&amp;id='.$objRegister->listen_id.'&amp;popup=1&amp;rt='.REQUEST_TOKEN.'" onclick="Backend.openModalIframe({\'width\':768,\'title\':\'Kaderliste '.$liste.' bearbeiten\',\'url\':this.href});return false">'.$imageEditHeader.'</a>';
			$ausgabe .= '</td>';
			$ausgabe .= '</tr>';
		}
		$ausgabe .= '</tbody></table>';
		$ausgabe .= '</div>';
		return $ausgabe;

	}

	/**
	 * Ändert das Aussehen des Toggle-Buttons.
	 * @param $row
	 * @param $href
	 * @param $label
	 * @param $title
	 * @param $icon
	 * @param $attributes
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		$this->import('BackendUser', 'User');

		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 0));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_kaderlisten_namen::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;id='.$this->Input->get('id').'&amp;tid='.$row['id'].'&amp;state='.$row[''];

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Toggle the visibility of an element
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnPublished)
	{
		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_kaderlisten_namen::published', 'alexf'))
		{
			$this->log('Not enough permissions to show/hide record ID "'.$intId.'"', 'tl_kaderlisten_namen toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_kaderlisten_namen', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_kaderlisten_namen']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_kaderlisten_namen']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_kaderlisten_namen SET tstamp=". time() .", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
		               ->execute($intId);
		$this->createNewVersion('tl_kaderlisten_namen', $intId);
	}

}
