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

use IIIF\PresentationAPI\Parameters\DCType;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Resources\Content;
use IIIF\PresentationAPI\Resources\Manifest;
use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    private $content;

    public function setUp()
    {
        $this->content = new Content();
    }

    /**
     * Test the type property
     */
    public function testType()
    {
        $this->content->setType(DCType::IMAGE);

        $this->assertEquals(DCType::IMAGE, $this->content->getType());
    }

    /**
     * Test the format property
     */
    public function testFormat()
    {
        $format = "images/jpeg";

        $this->content->setFormat($format);

        $this->assertEquals($format, $this->content->getFormat());
    }

    /**
     * Test the width property
     */
    public function testWidth()
    {
        $width = 750;

        $this->content->setWidth($width);

        $this->assertEquals($width, $this->content->getWidth());
    }

    /**
     * Test the height property
     */
    public function testHeight()
    {
        $height = 1000;

        $this->content->setHeight($height);

        $this->assertEquals($height, $this->content->getHeight());
    }


    /**
     * Test the toArray method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/book1/res/page1.jpg";
        $type = DCType::IMAGE;
        $format = "image/jpeg";
        $width = 1500;
        $height = 2000;


        $this->content->setID($id);
        $this->content->setType($type);
        $this->content->setFormat($format);
        $this->content->setWidth($width);
        $this->content->setHeight($height);

        $array = $this->content->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($type, $array[Identifier::TYPE]);
        $this->assertEquals($format, $array[Identifier::FORMAT]);
        $this->assertEquals($width, $array[Identifier::WIDTH]);
        $this->assertEquals($height, $array[Identifier::HEIGHT]);
    }
}

