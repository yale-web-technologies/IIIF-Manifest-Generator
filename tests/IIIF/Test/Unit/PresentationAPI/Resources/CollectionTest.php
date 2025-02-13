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
use IIIF\PresentationAPI\Resources\Annotation;
use IIIF\PresentationAPI\Parameters\ViewingHint;
use IIIF\PresentationAPI\Resources\Collection;
use IIIF\PresentationAPI\Resources\Manifest;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    private $collection;

    public function setUp(): void
    {
        $this->collection = new Collection();
    }

    /**
     * Test the collections
     */
    public function testCollection()
    {
        $this->collection->addCollection($this->createMock(Collection::class));

        $this->assertInstanceOf(Collection::class, $this->collection->getCollections()[0]);
    }

    /**
     * Test the collections
     */
    public function testManifest()
    {
        $this->collection->addManifest($this->createMock(Manifest::class));

        $this->assertInstanceOf(Manifest::class, $this->collection->getManifests()[0]);
    }

    /**
     * Test the members using a collection
     */
    public function testMember()
    {
        $this->collection->addMember($this->createMock(Collection::class));
        $this->collection->addMember($this->createMock(Manifest::class));

        $this->assertInstanceOf(Collection::class, $this->collection->getMembers()[0]);
        $this->assertInstanceOf(Manifest::class, $this->collection->getMembers()[1]);
    }

    /**
     * Test when a non Collection or Manifest type is passed
     */
    public function testMemberInvalid()
    {
        $this->expectException(\Exception::class);

        $this->collection->addMember($this->createMock(Annotation::class));
    }

    /**
     * Test the first property.
     */
    public function testFirst()
    {
        $first = "http://example.org/iiif/collection/c1";

        $this->collection->setFirst($first);

        $this->assertEquals($first, $this->collection->getFirst());
    }

    /**
     * Test the last property.
     */
    public function testLast()
    {
        $last = "http://example.org/iiif/collection/c5";

        $this->collection->setLast($last);

        $this->assertEquals($last, $this->collection->getLast());
    }

    /**
     * Test the total property.
     */
    public function testTotal()
    {
        $total = 50;

        $this->collection->setTotal($total);

        $this->assertEquals($total, $this->collection->getTotal());
    }

    /**
     * Test failure when using non-positive integer for total.
     */
    public function testNonPositiveTotal()
    {
        $this->expectException(\Exception::class);

        $total = -25;

        $this->collection->setTotal($total);
    }

    /**
     * Test the next property.
     */
    public function testNext()
    {
        $next = "http://example.org/iiif/collection/c2";

        $this->collection->setNext($next);

        $this->assertEquals($next, $this->collection->getNext());
    }

    /**
     * Test the prev property.
     */
    public function testPrev()
    {
        $prev = "http://example.org/iiif/collection/c1";

        $this->collection->setPrev($prev);

        $this->assertEquals($prev, $this->collection->getPrev());
    }

    /**
     * Test the startIndex property.
     */
    public function testStartIndex()
    {
        $startIndex = 0;

        $this->collection->setStartIndex($startIndex);

        $this->assertEquals($startIndex, $this->collection->getStartIndex());
    }

    /**
     * Test failure when using non-positive integer for startIndex.
     */
    public function testNonPositiveStartIndex()
    {
        $this->expectException(\Exception::class);

        $startIndex = "afwdf";

        $this->collection->setStartIndex($startIndex);
    }

    /**
     * Test the viewingHint validation for a collection
     */
    public function testCollecionViewingHint()
    {
        $newCollection = new Collection();
        $newCollection->addViewingHint(ViewingHint::PAGED);
        $this->collection->validateMemberCollection($newCollection);
    }


    /**
     * Test the viewingHint validation for a collection for an invalid item
     */
    public function testCollecionViewingHintInvalid()
    {
        $this->expectException(\Exception::class);
        $newCollection = new Collection();
        $newCollection->addViewingHint("Bad Value");
        $this->collection->validateMemberCollection($newCollection);
    }


    /**
     * Test the toArray method
     */
    public function testToArray()
    {
        $id = "http://example.org/iiif/collection/top";
        $label = "Top Level Collection for Example Organization";
        $viewingHint = ViewingHint::TOP;
        $description = "Description of Collection";

        $this->collection->setID($id);
        $this->collection->addLabel($label);
        $this->collection->addViewingHint($viewingHint);
        $this->collection->addDescription($description);

        $array = $this->collection->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($this->collection->type, $array[Identifier::TYPE]);
        $this->assertEquals($label, $array[Identifier::LABEL]);
        $this->assertEquals($viewingHint, $array[Identifier::VIEWINGHINT]);
        $this->assertEquals($description, $array[Identifier::DESCRIPTION]);
    }
}
