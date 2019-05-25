<?php

declare(strict_types=1);

namespace ReviewZorro\Helpers;

/**
 * Helper for path building.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PathHelper
{
	/**
	 * Get root path of app.
	 *
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public static function root(): string
	{
		return dirname(dirname(__DIR__));
	}

	/**
	 * Build absolute path from relative.
	 *
	 * @param string[] $relative
	 *
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public static function path(string ...$relative): string
	{
		$relative = array_filter($relative);

		if (0 === count($relative)) {
			return static::root();
		}

		return static::root() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $relative);
	}
}
