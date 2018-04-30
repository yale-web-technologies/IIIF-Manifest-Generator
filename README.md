# IIIF Manifest Generator #

This is a IIIF Manifest Generator written in PHP.  It implements the [IIIF API Specification](http://iiif.io/api). Currently this only supports the [Presentation API](http://iiif.io/api/presentation/2.1/).

### Installation ###
composer require yale-web-technologies/iiif-manifest-generator

### Usage ###
Resources are mapped to class types.  Methods are available to add objects embedded within a resource. Passing true to the constructor of a resource will make it a top level resource within the JSON. 
```PHP
<?php

  require_once 'iif-manifest-generator/autoload.php'; 
  $manifest = new Manifest(true);

  $manifest->setID("http://example.org/iiif/book1/manifest");
  $manifest->addLabel("Book 1");
  
  $thumbnail = new Thumbnail();
  $thumbnail->setID("http://example.org/images/book1-page1/full/80,100/0/default.jpg");
  
  $service_thumbnail = new Service();
  $thumbnail->setService($service_thumbnail);
  $service_thumbnail->setContext("http://iiif.io/api/image/2/context.json");
  $service_thumbnail->setID("http://example.org/images/book1-page1");
  $service_thumbnail->setProfile("http://iiif.io/api/image/2/level1.json");
  
  $sequence = new Sequence();
  $manifest->addSequence($sequence);
  $sequence->setID("http://example.org/iiif/book1/sequence/normal");
  $sequence->addLabel("Current Page Order");

  $canvas = new Canvas();
  $sequence->addCanvas($canvas);
  $canvas->setID("http://example.org/iiif/book1/canvas/p1");
  $canvas->addLabel("p. 1");
  $canvas->setWidth(500);
  $canvas->setHeight(500);
```
See the docs folder for implementation specifications.

### TODO ###
  - Implement Image API
  - Unit tests for Utils
