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
 *  @category IIIF\Test\Unit\PresentationAPI
 *  @package  Resources
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Unit\PresentationAPI\contents;

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Parameters\ViewingDirection;
use IIIF\PresentationAPI\Resources\Layer;
use IIIF\PresentationAPI\Resources\AnnotationList;
use IIIF\PresentationAPI\Resources\Manifest;
use PHPUnit\Framework\TestCase;

class LayerTest extends TestCase
{
    private $layer;

    public function setUp()
    {
        $this->layer = new Layer();
    }

    /**
     * Test the first property.
     */
    public function testFirst()
    {
        $first = "http://example.org/iiif/book1/list/l1";

        $this->layer->setFirst($first);

        $this->assertEquals($first, $this->layer->getFirst());
    }

    /**
     * Test the last property.
     */
    public function testLast()
    {
        $last = "http://example.org/iiif/book1/list/l5";

        $this->layer->setLast($last);

        $this->assertEquals($last, $this->layer->getLast());
    }

    /**
     * Test the total property.
     */
    public function testTotal()
    {
        $total = 50;

        $this->layer->setTotal($total);

        $this->assertEquals($total, $this->layer->getTotal());
    }

    /**
     * Test failure when using non-positive integer for total.
     */
    public function testNonPositiveTotal()
    {
        $this->expectException(\Exception::class);

        $total = -25;

        $this->layer->setTotal($total);
    }

    /**
     * Test the otherContent
     */
    public function testOtherContent()
    {
        $this->layer->addOtherContent($this->createMock(AnnotationList::class));

        $annotationList = $this->createMock(AnnotationList::class);

        $this->assertInstanceOf(AnnotationList::class, $this->layer->getOtherContents()[0]);
    }


    /**
     * Test the toArray method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/book1/list/l1";
        $viewingDirection = ViewingDirection::BOTTOM_TO_TOP;
        $label = "Diplomatic Transcription";
        $total = 100;

        $this->layer->setID($id);
        $this->layer->setLabel($label);
        $this->layer->setViewingDirection($viewingDirection);
        $this->layer->setTotal($total);

        $array = $this->layer->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($this->layer->type, $array[Identifier::TYPE]);
        $this->assertEquals($viewingDirection, $array[Identifier::VIEWINGDIRECTION]);
        $this->assertEquals($total, $array[Identifier::TOTAL]);
    }
}

