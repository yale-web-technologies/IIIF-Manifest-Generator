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
 *  @category IIIF\Test\Functional\PresentationAPI
 *  @package  Resources
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Unit\PresentationAPI\contents;

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Resources\Annotation;
use IIIF\PresentationAPI\Resources\AnnotationList;
use IIIF\PresentationAPI\Resources\Canvas;
use PHPUnit\Framework\TestCase;

class CanvasTest extends TestCase
{
    private $canvas;

    public function setUp()
    {
        $this->canvas = new Canvas();
    }

    /**
     * Test the width property
     */
    public function testWidth()
    {
        $width = 750;

        $this->canvas->setWidth($width);

        $this->assertEquals($width, $this->canvas->getWidth());
    }

    /**
     * Test the height property
     */
    public function testHeight()
    {
        $height = 1000;

        $this->canvas->setHeight($height);

        $this->assertEquals($height, $this->canvas->getHeight());
    }

    /**
     * Test the images.
     */
    public function testImages()
    {
        $this->canvas->addImage($this->createMock(Annotation::class));

        $this->assertInstanceOf(Annotation::class, $this->canvas->getImages()[0]);
    }

    /**
     * Test the otherContent.
     */
    public function testOtherContent()
    {
        $this->canvas->addOtherContent($this->createMock(AnnotationList::class));

        $this->assertInstanceOf(AnnotationList::class, $this->canvas->getOtherContents()[0]);
    }



    /**
     * Test the toArray method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/book1/canvas/p1";
        $label = "p. 1";
        $height = 1000;
        $width = 750;

        $this->canvas->setID($id);
        $this->canvas->addLabel($label);
        $this->canvas->setHeight($height);
        $this->canvas->setWidth($width);

        $array = $this->canvas->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($this->canvas->type, $array[Identifier::TYPE]);
        $this->assertEquals($label, $array[Identifier::LABEL]);
        $this->assertEquals($height, $array[Identifier::HEIGHT]);
        $this->assertEquals($width, $array[Identifier::WIDTH]);

    }
}
