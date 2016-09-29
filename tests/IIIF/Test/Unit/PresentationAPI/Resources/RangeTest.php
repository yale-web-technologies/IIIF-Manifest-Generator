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
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    private $range;

    public function setUp()
    {
        $this->range = new Range();
    }

    /**
     * Test the startCanvas property
     */
    public function testStartCanvas()
    {
        $startCanvas = "http://example.org/iiif/book1/range/p2";

        $this->range->setStartCanvas($startCanvas);

        $this->assertEquals($startCanvas, $this->range->getStartCanvas());
    }

    /**
     * Test the Range resource
     */
    public function testRange()
    {
        $this->range->addRange($this->createMock(Range::class));

        $this->assertInstanceOf(Range::class, $this->range->getRanges()[0]);
    }

    /**
     * Test the Canvas resource
     */
    public function testCanvas()
    {
        $this->range->addCanvas($this->createMock(Canvas::class));

        $this->assertInstanceOf(Canvas::class, $this->range->getCanvases()[0]);
    }

    /**
     * Test the Member property
     */
    public function testMember()
    {
        $this->range->addMember($this->createMock(Range::class));
        $this->range->addMember($this->createMock(Canvas::class));

        $this->assertInstanceOf(Range::class, $this->range->getMembers()[0]);
        $this->assertInstanceOf(Canvas::class, $this->range->getMembers()[1]);
    }

    /**
     * Test the contentLayer property
     */
    public function testContentLayer()
    {
        $contentLayer = "http://example.org/iiif/book1/layer/introTexts";

        $this->range->setContentLayer($contentLayer);

        $this->assertEquals($contentLayer, $this->range->getContentLayer());
    }

    public function testValidateMember()
    {
        $range = $this->createMock(Range::class);
        $range->method('getID')->willReturn('http://example.org/iiif/book1/range/r1');
        $range->method('getType')->willReturn('sc:Range');
        $range->method('getLabels')->willReturn(array('Introduction'));

        $this->range->validateMember($range);
    }

    public function testValidateMemberInvalid()
    {
        $this->expectException(\Exception::class);

        $range = $this->createMock(Range::class);
        $range->method('getID')->willReturn('http://example.org/iiif/book1/range/r1');
        $range->method('getType')->willReturn('sc:Range');

        $this->range->validateMember($range);
    }

    /**
     * Test the toArray method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/book1/range/r0";
        $label = "Table of Contents";
        $viewingHint = ViewingHint::TOP;

        $this->range->setID($id);
        $this->range->addLabel($label);
        $this->range->addViewingHint($viewingHint);

        $array = $this->range->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($this->range->type, $array[Identifier::TYPE]);
        $this->assertEquals($label, $array[Identifier::LABEL]);
        $this->assertEquals($viewingHint, $array[Identifier::VIEWINGHINT]);
    }
}
