<?php

/**
 * Resize controller
 *
 * @author Alexis Smadja <alexis.smadja@bigyouth.fr>
 */

namespace Bigyouth\BigyouthImageResizerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @package BigyouthBackBundle\Controller\Media
 *
 * @Route("/resizer")
 */
class ImageResizeController extends Controller
{

    /**
     * @param Request $request
     * @param string $path The path where the original file is expected to be
     * @param string $filter The name of the imagine filter in effect
     * @return RedirectResponse
     *
     * @Route("/filter/{filter}/{path}", name="by_resize", requirements={"filter"="[A-z0-9_\-]*", "path" = ".+"})
     *
     */
    public function filterAction(Request $request, $filter = 'default', $path)
    {
        $width  = $request->query->getInt('w', null);
        $height = $request->query->getInt('h', null);
        $scheme = $request->query->get('scheme');

        $redirectUrl = $this->get('by.resizer')->resolvePath($path, $filter, $width, $height, $scheme);

        if ($redirectUrl) {
            return new RedirectResponse($redirectUrl, Response::HTTP_MOVED_PERMANENTLY);
        } else {
            return new Response("", 404);
        }
    }
}
