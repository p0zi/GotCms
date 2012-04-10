<?php

/**
 * @namespace
 */
namespace Es;

use Zend\Json\Json;

final class Version
{
    /**
     * Easy Setting version identification - see compareVersion()
     */
    const VERSION = '0.1a';

    /**
     * The latest stable version Easy Setting available
     *
     * @var string
     */
    protected static $latestVersion;

    /**
     * Compare the specified Easy Setting version string $version
     * with the current Es\Version::VERSION of Easy Setting.
     *
     * @param  string  $version  A version string (e.g. "0.7.1").
     * @return int           -1 if the $version is older,
     *                           0 if they are the same,
     *                           and +1 if $version is newer.
     *
     */
    public static function compareVersion($version)
    {
        $version = strtolower($version);
        $version = preg_replace('/(\d)pr(\d?)/', '$1a$2', $version);
        return version_compare($version, strtolower(self::VERSION));
    }

    /**
     * Fetches the version of the latest stable release.
     *
     * This uses the GitHub API (v3) and only returns refs that begin with
     * 'tags/release-'. Because GitHub returns the refs in alphabetical order,
     * we need to reduce the array to a single value, comparing the version
     * numbers with version_compare().
     *
     * @see http://developer.github.com/v3/git/refs/#get-all-references
     * @link https://api.github.com/repos/zendframework/zf2/git/refs/tags/release-
     * @return string
     */
    public static function getLatest()
    {
        if (null === self::$latestVersion) {
            //@TODO
            self::$latestVersion = self::VERSION;
        }

        return self::$latestVersion;
    }

    /**
     * Returns true if the running version of Easy Setting is
     * the latest (or newer??) than the latest tag on GitHub,
     * which is returned by static::getLatest().
     *
     * @return boolean
     */
    public static function isLatest()
    {
        return static::compareVersion(static::getLatest()) < 1;
    }
}
