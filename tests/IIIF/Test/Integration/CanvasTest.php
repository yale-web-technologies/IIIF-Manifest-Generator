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
use IIIF\PresentationAPI\Properties\Thumbnail;
use IIIF\PresentationAPI\Resources\Annotation;
use IIIF\PresentationAPI\Resources\AnnotationList;
use IIIF\PresentationAPI\Resources\Canvas;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Canvas Resource
 *
 */
class CanvasTest extends TestCase
{

    private $generator;

    public function setUp()
    {
        $this->generator = new Generator();
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#canvas
     */
    public function testCreateCanvas()
    {
        $canvas = new Canvas(true);
        $canvas->setID("http://example.org/iiif/book1/canvas/p1");
        $canvas->addLabel("p. 1");
        $canvas->setHeight(1000);
        $canvas->setWidth(750);

        $thumbnail = new Thumbnail();
        $canvas->addThumbnail($thumbnail);
        $thumbnail->setID('http://example.org/iiif/book1/canvas/p1/thumb.jpg');
        $thumbnail->setHeight(200);
        $thumbnail->setWidth(150);

        $annotation = new Annotation();
        $canvas->addImage($annotation);
        $annotation->setOn("http://example.org/iiif/book1/canvas/p1");

        $annotationlist = new AnnotationList();
        $canvas->addOtherContent($annotationlist);
        $annotationlist->setID("http://example.org/iiif/book1/list/p1");

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/canvas.json',$this->generator->generate($canvas));

    }


}
