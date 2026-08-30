<?php

/**
 * Kaderlisten für Contao Open Source CMS
 *
 * @author    Frank Binding
 * @license   LGPL-3.0-or-later
 */

/**
 * Backend-Module
 *
 * Der frühere Schutz `if (!defined('TL_ROOT')) die(...)` steht hier bewusst
 * nicht mehr: Contao 5 definiert die Konstante TL_ROOT nicht mehr, die Zeile
 * hätte den Aufruf dort kommentarlos beendet.
 */
$GLOBALS['BE_MOD']['content']['kaderlisten'] = array
(
	'tables'         => array('tl_kaderlisten', 'tl_kaderlisten_items', 'tl_kaderlisten_namen'),
	'icon'           => 'bundles/contaokaderlisten/images/icon_16.png',
);

/**
 * Inhaltselemente
 */
$GLOBALS['TL_CTE']['schach']['kaderlisten'] = Schachbulle\ContaoKaderlistenBundle\ContentElements\Kaderliste::class;
