# BigyouthImageResizerBundle

## What is it ?

This bundle gives you a simple way to generate resized images (using LiipImagineBundle) with dynamical sizes directly from your Controller or views.

## Requirements

    "php": "^5.3.9|^7.0",
    "liip/imagine-bundle": "^1.8"
    
## Installation

### Download the bundle

Download composer at https://getcomposer.org/download/

    composer require bigyouth/image-resizer-bundle 0.1.*

### Register the bundle

Then, enable the bundle by adding it to the bundles array of the registerBundles method in your project's app/AppKernel.php file:

    <?php
    
    # app/AppKernel.php
    
    // ...
    
    class AppKernel extends Kernel
    {
	    public function registerBundles()
		{
	        $bundles = [
	            // ...

	            new Bigyouth\BigyouthImageResizerBundle\BigyouthImageResizerBundle(),
	        ];

	        // ...
	    }

	    // ...
	}


### Add routing

    # app/config/routing.yml
    
	by_resizer:
	    resource: "@BigyouthImageResizerBundle/Controller"
	    type:     annotation

## Configuration

First you need to install and configure the [LiipImagineBundle](https://symfony.com/doc/current/bundles/LiipImagineBundle/index.html). We recommend to set the default configuration without sizes specified :

    # app/config/config.yml
   
	liip_imagine:
	    filter_sets:
	        cache: ~
	        default:
	            quality: 95
	            filters:
	                thumbnail: { mode: inset }


## Usage

### In your controller

To use the ImageResizerBundle in your controller, you only have to generate the **by_resize** route with the *router* service :

    <?php
    // ...
    
    /**
    * Class PageController
    *
    * @package Bigyouth\FrontBundle\Controller
    */
	class PageController extends PageCacheController
	{
	  
	    // ...
	    public function indexAction(Request $request)
	    {

	        // ...
	
			$route = $this->generateUrl('by_resize', [
				'filter'=> 'default',
				'path'	=> '/uploads/images/my-image.jpg',
				'w'		=> 1280,
				'h'		=> 720
			]);

	    }
    }

#### filter
*default : **'default'***

The name of the filter you setted in *app/config/config.yml* within the LiipImagineBundle configuration and which you wish to use.

#### path

The web path of the image you wish to resize.

#### w
*default : **null***

The width you want to set to your image.

#### h
*default : **null***

The height you want to set to your image.


### In your views

In your views, you can use the Twig extension **by_resize** as follows :

	// ...
	
	{{ by_resize('/uploads/images/my-image.jpg', 1280, 720, 'default', 'https') }}

	// ...


#### path

The web path of the image you wish to resize.

#### w
*default : **null***

The width you want to set to your image.

#### h
*default : **null***

The height you want to set to your image.

#### filter
*default : **'default'***

The name of the filter you setted in *app/config/config.yml* within the LiipImagineBundle configuration and which you wish to use.

#### scheme
*default : **'http'***

The scheme in which you want the url to be generated.


----------


*author : [Alexis Smadja](mailto:alexis.smadja@bigyouth.fr)*