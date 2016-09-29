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
use IIIF\PresentationAPI\Resources\AnnotationList;
use IIIF\PresentationAPI\Resources\Layer;
use IIIF\PresentationAPI\Resources\Manifest;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Layer Resource
 *
 */
class LayerTest extends TestCase
{

    private $generator;

    public function setUp()
    {
        $this->generator = new Generator();
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#layer
     */
    public function testCreateLayer1()
    {
        $layer = new Layer(true);

        $layer->setID("http://example.org/iiif/book1/layer/transcription");
        $layer->addLabel("Diplomatic Transcription");

        $annotationlist1 = new AnnotationList();
        $annotationlist2 = new AnnotationList();
        $annotationlist3 = new AnnotationList();
        $annotationlist4 = new AnnotationList();

        $layer->addOtherContent($annotationlist1);
        $layer->addOtherContent($annotationlist2);
        $layer->addOtherContent($annotationlist3);
        $layer->addOtherContent($annotationlist4);

        $annotationlist1->returnOnlyID();
        $annotationlist2->returnOnlyID();
        $annotationlist3->returnOnlyID();
        $annotationlist4->returnOnlyID();

        $annotationlist1->setID("http://example.org/iiif/book1/list/l1");
        $annotationlist2->setID("http://example.org/iiif/book1/list/l2");
        $annotationlist3->setID("http://example.org/iiif/book1/list/l3");
        $annotationlist4->setID("http://example.org/iiif/book1/list/l4");

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/layer1.json',$this->generator->generate($layer));
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#paging
     */
    public function testCreateLayer2()
    {
        $layer = new Layer(true);

        $layer->setID("http://example.org/iiif/book1/layer/transcription");
        $layer->addLabel("Example Long Transcription");
        $layer->setTotal(496923);
        $layer->setFirst("http://example.org/iiif/book1/list/l1");

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/layer2.json',$this->generator->generate($layer));
    }

}
