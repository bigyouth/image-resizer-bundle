<?php

namespace Bigyouth\BigyouthImageResizerBundle\Twig\Extension;

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
     * @return null
     */
    public function resize($path, $width = null, $height = null, $filter = 'default')
    {

        if($path[0] === '/') {
            $path = substr($path, 1);
        }

        if(!$width || !$height) {
        }

        return $this->container->get('router')->generateUrl('by_resize', [
            "path"   => $path,
            "filter" => $filter,
            "w"      => $width,
            "h"      => $height
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
