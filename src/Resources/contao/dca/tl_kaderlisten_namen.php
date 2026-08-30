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
use Contao\Image;
use Contao\System;

/**
 * Tabelle tl_kaderlisten_namen
 */
$GLOBALS['TL_DCA']['tl_kaderlisten_namen'] = array
(

	// Config
	'config' => array
	(
		// Ab Contao 5 ist nur noch der voll qualifizierte Klassenname erlaubt.
		'dataContainer'               => DC_Table::class,
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
			'mode'                    => DataContainer::MODE_SORTABLE,
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
			'fields'                  => array('lastname ASC'),
			'panelLayout'             => 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'                  => array('lastname', 'firstname', 'birthyear', 'spielerregister_id'),
			'showColumns'             => true,
			'format'                  => '%s %s %s %s',
			'label_callback'          => array('tl_kaderlisten_namen', 'viewRecord')
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
				'icon'                => 'edit.svg'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
			),
			// Umschalter des Kerns statt des Haste-Togglers, siehe tl_kaderlisten.
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['toggle'],
				'href'                => 'act=toggle&amp;field=published',
				'icon'                => 'visible.svg',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten_namen']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
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
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
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
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
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
			'options_callback'        => array('Schachbulle\ContaoSpielerregisterBundle\Klassen\Helper', 'getRegister'),
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
 * Stellt die Callbacks des Data Containers tl_kaderlisten_namen bereit.
 *
 * Die Klasse erbt von Contao\Backend statt vom früheren globalen Alias
 * `Backend`, den Contao 5 nicht mehr registriert.
 */
class tl_kaderlisten_namen extends Backend
{

	/**
	 * Baut eine Tabelle mit allen Kaderlisten, in denen der Spieler steht.
	 *
	 * Die Tabelle wird als Ersatz für ein Eingabefeld eingeblendet und ist rein
	 * informativ; sie speichert nichts. Jede Zeile trägt zwei Verknüpfungen, die
	 * den betreffenden Listeneintrag beziehungsweise die Kaderliste selbst in
	 * einem Modalfenster zum Bearbeiten öffnen.
	 *
	 * Die frühere Fallunterscheidung über die Konstante VERSION ist entfallen:
	 * Contao 5 definiert sie nicht mehr, und der Zweig für Contao 3 wird nicht
	 * mehr gebraucht. Ebenso ersetzt der CSRF-Dienst die Konstante
	 * REQUEST_TOKEN, die es in Contao 5 ebenfalls nicht mehr gibt.
	 *
	 * @param DataContainer $dc     Data Container des bearbeiteten Spielers
	 * @param string        $xlabel Zusatzbeschriftung des Kerns, wird nicht benutzt
	 *
	 * @return string HTML der Tabelle; bei einem Spieler ohne Kaderzugehörigkeit
	 *                bleibt sie bis auf die Kopfzeile leer
	 */
	public function getKader(DataContainer $dc, $xlabel = '')
	{
		$container = System::getContainer();

		$linkprefix = $container->get('router')->generate('contao_backend');
		$strToken = $container->get('contao.csrf.token_manager')->getDefaultTokenValue();

		$imageEditHeader = Image::getHtml('header.svg', 'Kaderliste %s bearbeiten');
		$imageEdit = Image::getHtml('edit.svg', 'Spielereintrag %s in der Kaderliste bearbeiten');

		$spieler_id = $dc->id;

		$objRegister = Database::getInstance()->prepare("SELECT k.id AS listen_id, k.year, k.type, k.title, i.fidetitel, i.elo, i.dwz, i.nachname, i.vorname, i.id AS item_id, i.type AS item_type FROM tl_kaderlisten_items AS i, tl_kaderlisten AS k WHERE i.pid = k.id AND i.name_id=? ORDER BY k.year DESC")
		                                      ->execute($spieler_id);

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

		while ($objRegister->next())
		{
			$liste = $objRegister->year . '-' . strtoupper((string) $objRegister->type);
			$oddeven = $oddeven == 'odd' ? 'even' : 'odd';

			$ausgabe .= '<tr class="' . $oddeven . '" onmouseover="Theme.hoverRow(this,1)" onmouseout="Theme.hoverRow(this,0)">';
			$ausgabe .= '<td class="tl_file_list">' . $liste . '</td>';
			$ausgabe .= '<td class="tl_file_list">' . $objRegister->title . '</td>';
			$ausgabe .= '<td class="tl_file_list">' . $objRegister->item_type . '</td>';
			$ausgabe .= '<td class="tl_file_list">' . $objRegister->nachname . ',' . $objRegister->vorname . '</td>';
			$ausgabe .= '<td class="tl_file_list">' . $objRegister->fidetitel . '</td>';
			$ausgabe .= '<td class="tl_file_list">' . ($objRegister->elo ?: '') . '</td>';
			$ausgabe .= '<td class="tl_file_list">' . ($objRegister->dwz ?: '') . '</td>';
			$ausgabe .= '<td class="tl_file_list tl_right_nowrap">';
			$ausgabe .= '<a href="' . $linkprefix . '?do=kaderlisten&amp;table=tl_kaderlisten_items&amp;act=edit&amp;id=' . $objRegister->item_id . '&amp;popup=1&amp;rt=' . $strToken . '" onclick="Backend.openModalIframe({\'width\':768,\'title\':\'Eintrag ' . $objRegister->item_id . ' in Kaderliste ' . $liste . ' bearbeiten\',\'url\':this.href});return false">' . $imageEdit . '</a>';
			$ausgabe .= '<a href="' . $linkprefix . '?do=kaderlisten&amp;table=tl_kaderlisten&amp;act=edit&amp;id=' . $objRegister->listen_id . '&amp;popup=1&amp;rt=' . $strToken . '" onclick="Backend.openModalIframe({\'width\':768,\'title\':\'Kaderliste ' . $liste . ' bearbeiten\',\'url\':this.href});return false">' . $imageEditHeader . '</a>';
			$ausgabe .= '</td>';
			$ausgabe .= '</tr>';
		}

		$ausgabe .= '</tbody></table>';
		$ausgabe .= '</div>';

		return $ausgabe;
	}

	/**
	 * Ersetzt zwei Spalten der Listenansicht durch besser lesbare Angaben.
	 *
	 * Ein fehlender Jahrgang wird als Strich dargestellt, und statt der reinen
	 * ID aus dem Spielerregister erscheint ein Ja- beziehungsweise
	 * Nein-Sinnbild, das die Zuordnung anzeigt.
	 *
	 * @param array         $row   Datensatz der Zeile
	 * @param string        $label Vom Kern erzeugte Beschriftung
	 * @param DataContainer $dc    Data Container der Listenansicht
	 * @param array         $args  Die einzelnen Spaltenwerte in der Reihenfolge
	 *                             von 'label' => 'fields'
	 *
	 * @return array Die geänderten Spaltenwerte; sie werden bei
	 *               'showColumns' => true spaltenweise ausgegeben
	 */
	public function viewRecord($row, $label, DataContainer $dc, $args)
	{
		$args[2] = $args[2] ?: '-';
		$args[3] = $args[3] ? '<img src="bundles/contaokaderlisten/images/ja.png" alt="zugeordnet">' : '<img src="bundles/contaokaderlisten/images/nein.png" alt="nicht zugeordnet">';

		return $args;
	}

}
