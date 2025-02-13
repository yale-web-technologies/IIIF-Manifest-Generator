<?php
/*
 *  This file is part of IIIF Manifest Creator.
 *
 *  IIIF Manifest Creator is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  IIIF Manifest Creator is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with IIIF Manifest Creator.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @category IIIF\Test
 *  @package  Integration
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Integration;

use IIIF\Generator;
use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Parameters\DCType;
use IIIF\PresentationAPI\Resources\Annotation;
use IIIF\PresentationAPI\Resources\Content;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Annotation Resource
 *
 */
class AnnotationTest extends TestCase
{

    private $generator;

    public function setUp(): void
    {
        $this->generator = new Generator();
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#image-resources
     */
    public function testCreateAnnotation()
    {
        $annotation = new Annotation(true);

        $id = "http://example.org/iiif/book1/annotation/p0001-image";
        $on = "http://example.org/iiif/book1/canvas/p1";

        $annotation->setID($id);
        $annotation->setOn($on);

        $content = new Content();

        $annotation->setContent($content);

        $content->setID("http://example.org/iiif/book1/res/page1.jpg");
        $content->setType(DCType::IMAGE);
        $content->setFormat("image/jpeg");
        $content->setHeight(2000);
        $content->setWidth(1500);

        $service = new Service();
        $content->addService($service);

        $service->setID("http://example.org/images/book1-page1");
        $service->setProfile("http://iiif.io/api/image/2/profiles/level2.json");

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/annotation.json',$this->generator->generate($annotation));

    }


}

