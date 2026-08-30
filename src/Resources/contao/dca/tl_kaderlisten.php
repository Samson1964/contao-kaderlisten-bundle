<?php

/**
 * Kaderlisten für Contao Open Source CMS
 *
 * @author    Frank Binding
 * @license   LGPL-3.0-or-later
 */

use Contao\DataContainer;
use Contao\DC_Table;

/**
 * Tabelle tl_kaderlisten
 */
$GLOBALS['TL_DCA']['tl_kaderlisten'] = array
(

	// Config
	'config' => array
	(
		// Ab Contao 5 ist nur noch der voll qualifizierte Klassenname erlaubt,
		// der Kurzname 'Table' wird dort nicht mehr aufgelöst.
		'dataContainer'               => DC_Table::class,
		'ctable'                      => array('tl_kaderlisten_items'),
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id'    => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => DataContainer::MODE_SORTED,
			'fields'                  => array('year DESC', 'title ASC'),
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('year', 'type', 'title', 'fromDate', 'toDate'),
			'showColumns'             => true,
		),
		'global_operations' => array
		(
			'namen' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten']['namen'],
				'href'                => 'table=tl_kaderlisten_namen',
				'icon'                => 'bundles/contaokaderlisten/images/players.png',
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
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten']['edit'],
				'href'                => 'table=tl_kaderlisten_items',
				'icon'                => 'edit.svg'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.svg',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"',
			),
			// Umschalter des Kerns statt des Haste-Togglers: funktioniert ab
			// Contao 4.13 und in Contao 5 unverändert, sobald das Feld
			// 'published' mit 'toggle' => true gekennzeichnet ist.
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten']['toggle'],
				'href'                => 'act=toggle&amp;field=published',
				'icon'                => 'visible.svg',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_kaderlisten']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},year,title;{options_legend},type,fromDate,toDate,dwzSuffix,eloSuffix;{page_legend},page;{publish_legend},published'
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
		'year' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['year'],
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
			'inputType'               => 'text',
			'default'                 => date('Y'),
			'eval'                    => array('maxlength'=>4, 'tl_class'=>'w50'),
			'sql'                     => "int(4) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['title'],
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_ASC,
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['type'],
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_ASC,
			'inputType'               => 'radio',
			'options'                 => array('m', 'w'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_kaderlisten']['type_lang'],
			'eval'                    => array('submitOnChange'=>false,'tl_class'=>'clr'),
			'sql'                     => "varchar(1) NOT NULL default 'm'"
		),
		'fromDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['fromDate'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_MONTH_DESC,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'toDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['toDate'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => DataContainer::SORT_MONTH_DESC,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'dwzSuffix' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['dwzSuffix'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>8, 'tl_class'=>'w50'),
			'sql'                     => "varchar(8) NOT NULL default ''"
		),
		'eloSuffix' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['eloSuffix'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>8, 'tl_class'=>'w50'),
			'sql'                     => "varchar(8) NOT NULL default ''"
		),
		'page' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['page'],
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'foreignKey'              => 'tl_page.title',
			'eval'                    => array('mandatory'=>false, 'fieldType'=>'radio'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'hasOne', 'load'=>'eager')
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_kaderlisten']['published'],
			'toggle'                  => true,
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => DataContainer::SORT_INITIAL_LETTER_ASC,
			'default'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array
			(
				'doNotCopy'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
	)
);

// Eine Callback-Klasse tl_kaderlisten gibt es nicht mehr: Sie enthielt nur
// einen Konstruktor, der das nirgends benutzte Backend-Benutzerobjekt
// importierte. Der Data Container kommt ohne eigene Callbacks aus.
