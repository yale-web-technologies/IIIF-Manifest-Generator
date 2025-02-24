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
use IIIF\PresentationAPI\Parameters\DCType;
use IIIF\PresentationAPI\Resources\Annotation;
use IIIF\PresentationAPI\Resources\Content;
use IIIF\PresentationAPI\Resources\AnnotationList;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Annotation Resource
 *
 */
class AnnotationListTest extends TestCase
{

    private $generator;

    public function setUp(): void
    {
        $this->generator = new Generator();
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#annotation-list
     */
    public function testCreateAnnotation()
    {
        $annotationlist = new AnnotationList(true);

        $annotationlist->setID("http://example.org/iiif/book1/list/p1");

        $annotation1 = new Annotation();
        $annotationlist->addAnnotation($annotation1);
        $annotation1->setOn("http://example.org/iiif/book1/canvas/p1");

        $content1_1 = new Content;
        $annotation1->setContent($content1_1);
        $content1_1->setID("http://example.org/iiif/book1/res/music.mp3");
        $content1_1->setType(DCType::SOUND);
        $content1_1->setFormat("audio/mpeg");

        $annotation2 = new Annotation();
        $annotationlist->addAnnotation($annotation2);
        $annotation2->setOn("http://example.org/iiif/book1/canvas/p1");

        $content2_1 = new Content;
        $annotation2->setContent($content2_1);
        $content2_1->setID("http://example.org/iiif/book1/res/tei-text-p1.xml");
        $content2_1->setType(DCType::TEXT);
        $content2_1->setFormat("application/tei+xml");

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/annotationlist.json',$this->generator->generate($annotationlist));

    }


}
