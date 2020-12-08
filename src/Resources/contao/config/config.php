<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   bdf
 * @author    Frank Hoppe
 * @license   GNU/LGPL
 * @copyright Frank Hoppe 2014
 */

$GLOBALS['BE_MOD']['content']['kaderlisten'] = array
(
	'tables'         => array('tl_kaderlisten', 'tl_kaderlisten_items', 'tl_kaderlisten_namen'),
	'icon'           => 'bundles/contaokaderlisten/images/icon_16.png',
);

/**
 * -------------------------------------------------------------------------
 * CONTENT ELEMENTS
 * -------------------------------------------------------------------------
 */
$GLOBALS['TL_CTE']['schach']['kaderlisten'] = 'Schachbulle\ContaoKaderlistenBundle\ContentElements\Kaderliste';
