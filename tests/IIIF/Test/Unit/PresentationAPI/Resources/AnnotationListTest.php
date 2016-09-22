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
use IIIF\PresentationAPI\Parameters\Paging;
use IIIF\PresentationAPI\Resources\Annotation;
use IIIF\PresentationAPI\Resources\AnnotationList;
use IIIF\PresentationAPI\Resources\Content;
use PHPUnit\Framework\TestCase;

class AnnotationListTest extends TestCase
{
    private $annotationlist;

    public function setUp()
    {
        $this->annotationlist = new AnnotationList();
    }

    /**
     * Test the content.
     */
    public function testAnnotation()
    {
        $this->annotationlist->addAnnotation($this->createMock(Annotation::class));

        $this->assertInstanceOf(Annotation::class, $this->annotationlist->getAnnotations()[0]);
    }

    /**
     * Make sure the type is properly set.
     */
    public function testType()
    {
        $this->assertEquals($this->annotationlist->type, $this->annotationlist->getType());
    }

    /**
     * Test the next property.
     */
    public function testNext()
    {
        $next = "http://example.org/iiif/book1/list/l2";

        $this->annotationlist->setNext($next);

        $this->assertEquals($next, $this->annotationlist->getNext());
    }

    /**
     * Test the prev property.
     */
    public function testPrev()
    {
        $prev = "http://example.org/iiif/book1/list/l1";

        $this->annotationlist->setPrev($prev);

        $this->assertEquals($prev, $this->annotationlist->getPrev());
    }

    /**
     * Test the startIndex property.
     */
    public function testStartIndex()
    {
        $startIndex = 10;

        $this->annotationlist->setStartIndex($startIndex);

        $this->assertEquals($startIndex, $this->annotationlist->getStartIndex());
    }

    /**
     * Test failure when using non-positive integer for startIndex.
     */
    public function testNonPositiveStartIndex()
    {
        $this->expectException(\Exception::class);

        $startIndex = -5;

        $this->annotationlist->setStartIndex($startIndex);
    }

    /**
     * Test the toArray method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/book1/list/p1";
        $prev = "http://example.org/iiif/book1/list/l1";
        $next = "http://example.org/iiif/book1/list/l2";
        $startIndex = 5;

        $this->annotationlist->setID($id);
        $this->annotationlist->setPrev($prev);
        $this->annotationlist->setNext($next);
        $this->annotationlist->setStartIndex($startIndex);

        $array = $this->annotationlist->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($this->annotationlist->type, $array[Identifier::TYPE]);
        $this->assertEquals($prev, $array[Paging::PREVIOUS]);
        $this->assertEquals($next, $array[Paging::NEXT]);
        $this->assertEquals($startIndex, $array[Paging::STARTINDEX]);
    }
}

