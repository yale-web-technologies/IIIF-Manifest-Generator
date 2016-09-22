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
 *  @package  Links
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Unit\PresentationAPI\Links;

use IIIF\PresentationAPI\Links\Rendering;
use IIIF\PresentationAPI\Parameters\Identifier;
use PHPUnit\Framework\TestCase;

class RenderingTest extends TestCase
{
    private $rendering;

    public function setUp()
    {
        $this->rendering = new Rendering();
    }

    /**
     * Test the setProfile method which should throw an Exception as it is not implemented.
     */
    public function testSetProfile()
    {
        $this->expectException(\Exception::class);
        $this->rendering->setProfile("test");
    }

    /**
     * Test the getProfile method which should throw an Exception as it is not implemented.
     */
    public function testGetProfile()
    {
        $this->expectException(\Exception::class);
        $this->rendering->setProfile("test");
    }

    /**
     * Test to toArray method
     */
    public function testToArray()
    {

        $id = "http://example.org/iiif/book1.pdf";
        $label = "Download as PDF";
        $format = "application/pdf";

        $this->rendering->setID($id);
        $this->rendering->setLabel($label);
        $this->rendering->setFormat($format);

        $array = $this->rendering->toArray();
        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($label, $array[Identifier::LABEL]);
        $this->assertEquals($format, $array[Identifier::FORMAT]);
    }

    /**
     * Test the toArray method to ensure that a blank ID is not set.
     */
    public function testToArrayBlankId()
    {
        $this->expectException(\Exception::class);
        $this->rendering->toArray();
    }

    /**
     * Test the toArray method to ensure that a blank label is not set.
     */
    public function testToArrayBlankLabel()
    {
        $id = "http://example.org/iiif/book1.pdf";
        $label = "";
        $format = "application/pdf";

        $this->rendering->setID($id);
        $this->rendering->setLabel($label);
        $this->rendering->setFormat($format);

        $this->expectException(\Exception::class);
        $this->rendering->toArray();
    }

    /**
     * Test the toArray method to ensure that a blank format is not set.
     */
    public function testToArrayBlankFormat()
    {
        $id = "http://example.org/iiif/book1.pdf";
        $label = "Download as PDF";
        $format = "";

        $this->rendering->setID($id);
        $this->rendering->setLabel($label);
        $this->rendering->setFormat($format);

        $this->expectException(\Exception::class);
        $this->rendering->toArray();
    }
}