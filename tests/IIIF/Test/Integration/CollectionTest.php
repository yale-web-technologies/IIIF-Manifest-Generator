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
 *  @category IIIF\Test
 *  @package  Integration
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Integration;

use IIIF\Generator;
use IIIF\PresentationAPI\Parameters\ViewingHint;
use IIIF\PresentationAPI\Resources\Collection;
use IIIF\PresentationAPI\Resources\Manifest;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Collection Resource
 *
 */
class CollectionTest extends TestCase
{

    private $generator;

    public function setUp()
    {
        $this->generator = new Generator();
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#collection
     */
    public function testCreateCollections()
      {
        $collection = new Collection(true);

        $collection->setID("http://example.org/iiif/collection/top");
        $collection->addLabel("Top Level Collection for Example Organization");
        $collection->addViewingHint(ViewingHint::TOP);
        $collection->addDescription("Description of Collection");
        $collection->addAttribution("Provided by Example Organization");

        $collection1 = new Collection();
        $collection->addCollection($collection1);
        $collection1->setID("http://example.org/iiif/collection/sub1");
        $collection1->addLabel("Sub-Collection 1");

        $mem_collection1 = new Collection();
        $collection1->addMember($mem_collection1);
        $mem_collection1->setID("http://example.org/iiif/collection/part1");
        $mem_collection1->addLabel("My Multi-volume Set");
        $mem_collection1->addViewingHint(ViewingHint::MULTI_PART);

        $mem_manifest1 = new Manifest();
        $collection1->addMember($mem_manifest1);
        $mem_manifest1->setID("http://example.org/iiif/book1/manifest1");
        $mem_manifest1->addLabel("My Book");

        $mem_collection2 = new Collection();
        $collection1->addMember($mem_collection2);
        $mem_collection2->setID("http://example.org/iiif/collection/part2");
        $mem_collection2->addLabel("My Sub Collection");
        $mem_collection2->addViewingHint(ViewingHint::INDIVIDUALS);

        $collection2 = new Collection();
        $collection->addCollection($collection2);
        $collection2->setID("http://example.org/iiif/collection/part2");
        $collection2->addLabel("Sub Collection 2");

        $manifest1 = new Manifest();
        $collection->addManifest($manifest1);
        $manifest1->setID("http://example.org/iiif/book1/manifest");
        $manifest1->addLabel("Book 1");

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/collection.json',$this->generator->generate($collection));
    }


}
