<?php

declare(strict_types=1);

/**
 * Kaderlisten für Contao Open Source CMS
 *
 * @author    Frank Binding
 * @license   LGPL-3.0-or-later
 */

namespace Schachbulle\ContaoKaderlistenBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Schachbulle\ContaoKaderlistenBundle\ContaoKaderlistenBundle;

/**
 * Meldet das Bundle beim Contao Manager an.
 */
class Plugin implements BundlePluginInterface
{
	/**
	 * Gibt die Ladereihenfolge des Bundles bekannt.
	 *
	 * Das Bundle wird nach dem Contao-Kern geladen, damit dessen Data Container
	 * und Sprachdateien bereits vorliegen, wenn tl_content erweitert wird.
	 *
	 * @param ParserInterface $parser Parser für Konfigurationsdateien anderer
	 *                                Formate, wird hier nicht gebraucht
	 *
	 * @return array Liste mit der Bundle-Konfiguration
	 */
	public function getBundles(ParserInterface $parser)
	{
		return [
			BundleConfig::create(ContaoKaderlistenBundle::class)
				->setLoadAfter([ContaoCoreBundle::class]),
		];
	}
}
