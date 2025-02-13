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
use IIIF\PresentationAPI\Parameters\ViewingHint;
use IIIF\PresentationAPI\Resources\Canvas;
use IIIF\PresentationAPI\Resources\Manifest;
use IIIF\PresentationAPI\Resources\Range;
use IIIF\PresentationAPI\Resources\Sequence;
use PHPUnit\Framework\TestCase;

class SequenceTest extends TestCase
{
    private $sequence;

    public function setUp(): void
    {
        $this->sequence = new Sequence();
    }

    /**
     * Test the startCanvas property
     */
    public function testStartCanvas()
    {
        $startCanvas = "http://example.org/iiif/book1/range/p2";

        $this->sequence->setStartCanvas($startCanvas);

        $this->assertEquals($startCanvas, $this->sequence->getStartCanvas());
    }

    /**
     * Test the Canvas resource
     */
    public function testCanvas()
    {
        $this->sequence->addCanvas($this->createMock(Canvas::class));

        $this->assertInstanceOf(Canvas::class, $this->sequence->getCanvases()[0]);
    }

    /**
     * Test the toArray method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/book1/sequence/normal";
        $label = "Current Page Order";
        $viewingHint = ViewingHint::PAGED;

        $this->sequence->setID($id);
        $this->sequence->addLabel($label);
        $this->sequence->addViewingHint($viewingHint);
        $this->sequence->addCanvas($this->createMock(Canvas::class));

        $array = $this->sequence->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($this->sequence->type, $array[Identifier::TYPE]);
        $this->assertEquals($label, $array[Identifier::LABEL]);
        $this->assertEquals($viewingHint, $array[Identifier::VIEWINGHINT]);
    }
}
