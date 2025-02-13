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

use IIIF\PresentationAPI\Links\Related;
use IIIF\PresentationAPI\Parameters\Identifier;
use PHPUnit\Framework\TestCase;

class RelatedTest extends TestCase
{
    private $related;

    public function setUp(): void
    {
        $this->related = new Related();
    }

    /**
     * Test the setProfile method which should throw an Exception as it is not implemented.
     */
    public function testSetProfile()
    {
        $this->expectException(\Exception::class);
        $this->related->setProfile("test");
    }

    /**
     * Test the getProfile method which should throw an Exception as it is not implemented.
     */
    public function testGetProfile()
    {
        $this->expectException(\Exception::class);
        $this->related->getProfile();
    }

    /**
     * Test to toArray method
     */
    public function testToArray()
    {

        $id = "http://example.org/videos/video-book1.mpg";
        $label = "Test Book";
        $format = "video/mpeg";

        $this->related->setID($id);
        $this->related->setLabel($label);
        $this->related->setFormat($format);

        $array = $this->related->toArray();
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
        $this->related->toArray();
    }
}