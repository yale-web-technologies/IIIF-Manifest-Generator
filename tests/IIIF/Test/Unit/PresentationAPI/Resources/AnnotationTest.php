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
use IIIF\PresentationAPI\Resources\Content;
use PHPUnit\Framework\TestCase;

class AnnotationTest extends TestCase
{
    private $annotation;

    public function setUp(): void
    {
        $this->annotation = new Annotation();
    }

    /**
     * Test the motivation property
     */
    public function testMotivation()
    {
        $motivation = "sc:test";

        $this->annotation->setMotivation($motivation);

        $this->assertEquals($motivation, $this->annotation->getMotivation());
    }

    /**
     * Make sure the default motivation is set when non exists
     */
    public function testDefaultMotivation()
    {
        $this->assertEquals($this->annotation->motivation, $this->annotation->getMotivation());
    }

    /**
     * Test the content.
     */
    public function testContent()
    {
      $this->annotation->setContent($this->createMock(Content::class));

      $this->assertInstanceOf(Content::class, $this->annotation->getContent());
    }

    /**
     * Test the on property
     */
    public function testOn()
    {
        $on = "http://example.org/iiif/book1/canvas/p1";

        $this->annotation->setOn($on);

        $this->assertEquals($on, $this->annotation->getOn());
    }

    /**
     * Test the toArray method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/book1/annotation/p0001-image";
        $on = "http://example.org/iiif/book1/canvas/p1";

        $this->annotation->setID($id);
        $this->annotation->setOn($on);

        $array = $this->annotation->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($this->annotation->type, $array[Identifier::TYPE]);
        $this->assertEquals($on, $array[Identifier::ON]);
    }
}

