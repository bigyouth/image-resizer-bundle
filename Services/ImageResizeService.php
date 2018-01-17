<?php

/**
 * Service
 *
 * @author Alexis Smadja <alexis.smadja@bigyouth.fr>
 */

namespace Bigyouth\BigyouthImageResizerBundle\Services;

use Bigyouth\BigyouthImageResizerBundle\Helper\Helper;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;

/**
 * Class ImageResizeService
 *
 * @package BigyouthBackBundle\Services
 */
class ImageResizeService
{

    /**
     * @var CacheManager $cacheManager
     */
    protected $cacheManager;

    /**
     * @var DataManager $dataManager
     */
    protected $dataManager;

    /**
     * @var FilterManager $filterManager
     */
    protected $filterManager;


    public function __construct(CacheManager $cacheManager, DataManager $dataManager, FilterManager $filterManager)
    {
        $this->cacheManager = $cacheManager;
        $this->dataManager = $dataManager;
        $this->filterManager = $filterManager;
    }

    /**
     * @param string $path
     * @param string $filter
     * @param null $width
     * @param null $height
     * @param $scheme
     * @return null
     */
    public function resolvePath($path = '', $filter = 'default', $width = null, $height = null, $scheme = 'http')
    {
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        if (!$width || !$height) {
            $absolutePath = Helper::getRootDir() . '/../web/' . $path;

            if (!file_exists($absolutePath)) {
                return null;
            }

            $size   = getimagesize($absolutePath);
            $width  = $size[0];
            $height = $size[1];
        }

        if (!$this->cacheManager->isStored($width . '/' . $height . '/' . $path, $filter)) {
            $binary = $this->dataManager->find($filter, $path);

            $filteredBinary = $this->filterManager->applyFilter($binary, $filter, array(
                'filters' => array(
                    'thumbnail' => array(
                        'size' => array($width, $height)
                    )
                )
            ));

            $this->cacheManager->store($filteredBinary, $width . '/' . $height . '/' . $path, $filter);
        }

        $url = $this->cacheManager->resolve($width . '/' . $height . '/' . $path, $filter);

        if ($scheme == 'https') {
            $url = str_replace('http://', 'https://', $url);
        }

        return $url;
    }
}
