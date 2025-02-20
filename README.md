# IIIF Manifest Generator #

This is a IIIF Manifest Generator written in PHP.  It implements the [IIIF API Specification](http://iiif.io/api). Currently this only supports the [Presentation API](http://iiif.io/api/presentation/2.1/).

### Installation ###
composer require yale-web-technologies/iiif-manifest-generator

Requires PHP >=8.1.

### Usage ###
Resources are mapped to class types.  Methods are available to add objects embedded within a resource. Passing true to the constructor of a resource will make it a top level resource within the JSON.
```php
<?php

  require_once 'iif-manifest-generator/autoload.php';
  $manifest = new Manifest(true);

  $manifest->setID("http://example.org/iiif/book1/manifest");
  $manifest->addLabel("Book 1");

  $thumbnail = new Thumbnail();
  $manifest->addThumbnail($thumbnail);
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

### Generating Documentation
Documentation is generated through [`phpdocumentor`](https://docs.phpdoc.org/). To create the documentation run the following:

```sh
composer install
composer docs
```

To modify how the documentation is generated, a custom `phpdoc.xml` file can be provided. See the [`phpdocumentor` configuration docs](https://docs.phpdoc.org/guide/getting-started/configuration.html#configuration) for more details.

## Contributing ##
### Developing with Docker ###
Build image locally and run it to execute the test suite.

```sh
docker build . -t iiif-manifest-generator
docker run iiif-manifest-generator
```

### TODO ###
  - Implement Image API
  - Unit tests for Utils
