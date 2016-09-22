<?php

$mapping = array(
    'IIIF\Generator' => __DIR__ . '/src/IIIF/Generator.php',
    'IIIF\PresentationAPI\Links\LinkAbstract' => __DIR__ . '/src/IIIF/PresentationAPI/Links/LinkAbstract.php',
    'IIIF\PresentationAPI\Links\LinkInterface' => __DIR__ . '/src/IIIF/PresentationAPI/Links/LinkInterface.php',
    'IIIF\PresentationAPI\Links\Rendering' => __DIR__ . '/src/IIIF/PresentationAPI/Links/Rendering.php',
    'IIIF\PresentationAPI\Links\Related' => __DIR__ . '/src/IIIF/PresentationAPI/Links/Related.php',
    'IIIF\PresentationAPI\Links\SeeAlso' => __DIR__ . '/src/IIIF/PresentationAPI/Links/SeeAlso.php',
    'IIIF\PresentationAPI\Links\Service' => __DIR__ . '/src/IIIF/PresentationAPI/Links/Service.php',
    'IIIF\PresentationAPI\Metadata\Metadata' => __DIR__ . '/src/IIIF/PresentationAPI/Metadata/Metadata.php',
    'IIIF\PresentationAPI\Metadata\MetadataInterface' => __DIR__ . '/src/IIIF/PresentationAPI/Metadata/MetadataInterface.php',
    'IIIF\PresentationAPI\Parameters\Context' => __DIR__ . '/src/IIIF/PresentationAPI/Parameters/Context.php',
    'IIIF\PresentationAPI\Parameters\DCType' => __DIR__ . '/src/IIIF/PresentationAPI/Parameters/DCType.php',
    'IIIF\PresentationAPI\Parameters\Identifier' => __DIR__ . '/src/IIIF/PresentationAPI/Parameters/Identifier.php',
    'IIIF\PresentationAPI\Parameters\ImageProfileSupport' => __DIR__ . '/src/IIIF/PresentationAPI/Parameters/ImageProfileSupport.php',
    'IIIF\PresentationAPI\Parameters\Paging' => __DIR__ . '/src/IIIF/PresentationAPI/Parameters/Paging.php',
    'IIIF\PresentationAPI\Parameters\ViewingHint' => __DIR__ . '/src/IIIF/PresentationAPI/Parameters/ViewingHint.php',
    'IIIF\PresentationAPI\Parameters\ViewingDirection' => __DIR__ . '/src/IIIF/PresentationAPI/Parameters/ViewingDirection.php',
    'IIIF\PresentationAPI\Properties\Logo' => __DIR__ . '/src/IIIF/PresentationAPI/Properties/Logo.php',
    'IIIF\PresentationAPI\Properties\MimeAbstract' => __DIR__ . '/src/IIIF/PresentationAPI/Properties/MimeAbstract.php',
    'IIIF\PresentationAPI\Properties\PropertyAbstract' => __DIR__ . '/src/IIIF/PresentationAPI/Properties/PropertyAbstract.php',
    'IIIF\PresentationAPI\Properties\PropertyInterface' => __DIR__ . '/src/IIIF/PresentationAPI/Properties/PropertyInterface.php',
    'IIIF\PresentationAPI\Properties\Thumbnail' => __DIR__ . '/src/IIIF/PresentationAPI/Properties/Thumbnail.php',
    'IIIF\PresentationAPI\Resources\Annotation' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Annotation.php',
    'IIIF\PresentationAPI\Resources\AnnotationList' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/AnnotationList.php',
    'IIIF\PresentationAPI\Resources\Canvas' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Canvas.php',
    'IIIF\PresentationAPI\Resources\Collection' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Collection.php',
    'IIIF\PresentationAPI\Resources\Content' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Content.php',
    'IIIF\PresentationAPI\Resources\Layer' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Layer.php',
    'IIIF\PresentationAPI\Resources\Manifest' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Manifest.php',
    'IIIF\PresentationAPI\Resources\Range' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Range.php',
    'IIIF\PresentationAPI\Resources\Resource' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Resource.php',
    'IIIF\PresentationAPI\Resources\ResourceAbstract' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/ResourceAbstract.php',
    'IIIF\PresentationAPI\Resources\ResourceInterface' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/ResourceInterface.php',
    'IIIF\PresentationAPI\Resources\Sequence' => __DIR__ . '/src/IIIF/PresentationAPI/Resources/Sequence.php',
    'IIIF\Utils\ArrayCreator' => __DIR__ . '/src/IIIF/Utils/ArrayCreator.php',
    'IIIF\Utils\Validator' => __DIR__ . '/src/IIIF/Utils/Validator.php',
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require $mapping[$class];
    }
}, true);
