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
 *  @package  Properties
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Unit\PresentationAPI\Properties;

use IIIF\PresentationAPI\Parameters\DCType;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Properties\Thumbnail;
use PHPUnit\Framework\TestCase;


class ThumbnailTest extends TestCase
{
    private $thumbnail;

    public function setUp()
    {
        $this->thumbnail = new Thumbnail();
    }

    /**
     * Test the width.
     */
    public function testWidth()
    {
      $width = 100;

      $this->thumbnail->setWidth($width);

      $this->assertEquals($width, $this->thumbnail->getWidth());

    }

    /**
     * Test the height
     */
    public function testHeight()
    {
        $height = 50;

        $this->thumbnail->setHeight($height);

        $this->assertEquals($height, $this->thumbnail->getHeight());
    }


    /**
     * Test the toArray Method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/book1/canvas/p1/thumb.jpg";
        $width = 200;
        $height = 500;

        $this->thumbnail->setID($id);
        $this->thumbnail->setWidth($width);
        $this->thumbnail->setHeight($height);

        $array = $this->thumbnail->toArray();

        $this->assertEquals($width, $array[Identifier::WIDTH]);
        $this->assertEquals($height, $array[Identifier::HEIGHT]);
    }
}