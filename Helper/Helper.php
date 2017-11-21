<?php

namespace Bigyouth\BigyouthImageResizerBundle\Helper;

class Helper
{
    /**
     * @var string
     */
    protected static $rootDir;

    /**
     * @param $dir
     */
    public static function setRootDir($dir)
    {
        self::$rootDir = $dir;
    }

    /**
     * @return mixed
     */
    public static function getRootDir()
    {
        return self::$rootDir;
    }

    /**
     * @return mixed
     */
    public static function getWebRootDir()
    {
        return self::$rootDir . '/../web/';
    }
}
