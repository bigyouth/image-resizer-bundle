<?php
namespace Bigyouth\BigyouthImageResizerBundle\Twig\Extension;

use Bigyouth\BigyouthImageResizerBundle\Helper\Helper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormView;

class ImageResizeExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * PaginateExtension constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('by_resize', [$this, 'resize'], [
                'is_safe' => ['html']
            ])
        ];
    }

    /**
     * @param $path
     * @param null $width
     * @param null $height
     * @param string $filter
     * @param string $scheme
     * @return mixed
     */
    public function resize($path, $width = null, $height = null, $filter = 'default', $scheme = 'http')
    {
        if ($path[0] === '/') {
            $path = substr($path, 1);
        }

        if (!$width || !$height) {
            $size = getimagesize(Helper::getWebRootDir() . '/' . $path);

            $width  = $size[0];
            $height = $size[1];

            if ($width > 1280) {
                $height = ($height / $width) * 1280;
                $width  = 1280;
            }
        }

        return $this->container->get('router')->generate('by_resize', [
            "path"   => $path,
            "filter" => $filter,
            "w"      => $width,
            "h"      => $height,
            "scheme" => $scheme
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bigyouthresizer_extension';
    }
}
