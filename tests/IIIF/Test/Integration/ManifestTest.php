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
use IIIF\PresentationAPI\Links\Related;
use IIIF\PresentationAPI\Links\Rendering;
use IIIF\PresentationAPI\Links\SeeAlso;
use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Metadata\Metadata;
use IIIF\PresentationAPI\Parameters\DCType;
use IIIF\PresentationAPI\Parameters\ViewingDirection;
use IIIF\PresentationAPI\Parameters\ViewingHint;
use IIIF\PresentationAPI\Properties\Logo;
use IIIF\PresentationAPI\Properties\Thumbnail;
use IIIF\PresentationAPI\Resources\Annotation;
use IIIF\PresentationAPI\Resources\AnnotationList;
use IIIF\PresentationAPI\Resources\Canvas;
use IIIF\PresentationAPI\Resources\Content;
use IIIF\PresentationAPI\Resources\Layer;
use IIIF\PresentationAPI\Resources\Manifest;
use IIIF\PresentationAPI\Resources\Range;
use IIIF\PresentationAPI\Resources\Sequence;

use PHPUnit\Framework\TestCase;

/**
 * Testing the Layer Resource
 *
 */
class ManifestTest extends TestCase
{

    private $generator;

    public function setUp(): void
    {
        $this->generator = new Generator();
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#manifest
     */
    public function testCreateManifest1()
    {
        $manifest = new Manifest(true);

        $manifest->setID("http://example.org/iiif/book1/manifest");
        $manifest->addLabel("Book 1");

        $metadata = new Metadata();
        $manifest->setMetadata($metadata);
        $metadata->addLabelValue("Author", "Anne Author");
        $metadata->addLabelMultiValue("Published", array(
            array("value" => "Paris, circa 1400", "language" => "en" ),
            array("value" => "Paris, environ 1400", "language" => "fr" ),
        ));
        $metadata->addLabelMultiValue("Notes", array("Text of note 1", "Text of note 2"));
        $metadata->addLabelValue("Source",  "<span>From: <a href=\"http://example.org/db/1.html\">Some Collection</a></span>");

        $manifest->addDescription("A longer description of this example book. It should give some real information.");

        $thumbnail = new Thumbnail();
        $manifest->addThumbnail($thumbnail);
        $thumbnail->setID( "http://example.org/images/book1-page1/full/80,100/0/default.jpg");

        $service_thumbnail = new Service();
        $thumbnail->setService($service_thumbnail);
        $service_thumbnail->setContext("http://iiif.io/api/image/2/context.json");
        $service_thumbnail->setID("http://example.org/images/book1-page1");
        $service_thumbnail->setProfile("http://iiif.io/api/image/2/level1.json");

        $manifest->setViewingDirection(ViewingDirection::RIGHT_TO_LEFT);
        $manifest->addViewingHint(ViewingHint::PAGED);
        $manifest->setNavDate("1856-01-01T00:00:00Z");
        $manifest->addLicense("http://example.org/license.html");
        $manifest->addAttribution("Provided by Example Organization");

        $logo = new Logo();
        $manifest->addLogo($logo);
        $logo->setID("http://example.org/logos/institution1.jpg");

        $service_logo = new Service();
        $logo->setService($service_logo);
        $service_logo->setContext("http://iiif.io/api/image/2/context.json");
        $service_logo->setID("http://example.org/service/inst1");
        $service_logo->setProfile("http://iiif.io/api/image/2/profiles/level2.json");

        $related = new Related();
        $manifest->addRelated($related);
        $related->setID("http://example.org/videos/video-book1.mpg");
        $related->setFormat("video/mpeg");

        $service = new Service();
        $manifest->addService($service);
        $service->setContext("http://example.org/ns/jsonld/context.json");
        $service->setID("http://example.org/service/example");
        $service->setProfile("http://example.org/docs/example-service.html");

        $seeAlso = new SeeAlso();
        $manifest->addSeeAlso($seeAlso);
        $seeAlso->setID("http://example.org/library/catalog/book1.xml");
        $seeAlso->setFormat("text/xml");
        $seeAlso->setProfile("http://example.org/profiles/bibliographic");

        $rendering = new Rendering();
        $manifest->addRendering($rendering);
        $rendering->setID("http://example.org/iiif/book1.pdf");
        $rendering->setLabel("Download as PDF");
        $rendering->setFormat("application/pdf");

        $manifest->addWithin("http://example.org/collections/books/");

        $sequence = new Sequence();
        $manifest->addSequence($sequence);
        $sequence->setID("http://example.org/iiif/book1/sequence/normal");
        $sequence->addLabel("Current Page Order");

        $canvas = new Canvas();
        $sequence->addCanvas($canvas);
        $canvas->setID("http://example.org/iiif/book1/canvas/p1");
        $canvas->addLabel("p. 1");
        $canvas->setWidth(500);
        $canvas->setHeight(500);

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/manifest1.json',$this->generator->generate($manifest));
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#range
     */
    public function testCreateManifest2()
    {
        $manifest = new Manifest(true);

        $manifest->setID("http://example.org/iiif/book1/manifest");
        $manifest->addLabel("Book 1");

        $sequence = new Sequence();
        $manifest->addSequence($sequence);
        $sequence->setID("http://example.org/iiif/book1/sequence/normal");
        $sequence->addLabel("Current Page Order");

        $canvas = new Canvas();
        $sequence->addCanvas($canvas);
        $canvas->setID("http://example.org/iiif/book1/canvas/p1");
        $canvas->addLabel("p. 1");
        $canvas->setWidth(500);
        $canvas->setHeight(500);

        $range1 = new Range();
        $manifest->addStructure($range1);
        $range1->setID("http://example.org/iiif/book1/range/r0");
        $range1->addLabel("Table of Contents");
        $range1->addViewingHint(ViewingHint::TOP);

        $range1_member1 = new Canvas();
        $range1->addMember($range1_member1);
        $range1_member1->returnOnlyMemberData();
        $range1_member1->setID("http://example.org/iiif/book1/canvas/cover");
        $range1_member1->addLabel("Front Cover");

        $range1_member2 = new Range();
        $range1->addMember($range1_member2);
        $range1_member2->returnOnlyMemberData();
        $range1_member2->setID("http://example.org/iiif/book1/range/r1");
        $range1_member2->addLabel("Introduction");
        $range1_member2->setContentLayer("http://example.org/iiif/book1/layer/introTexts");

        $range1_member3 = new Canvas();
        $range1->addMember($range1_member3);
        $range1_member3->returnOnlyMemberData();
        $range1_member3->setID("http://example.org/iiif/book1/canvas/backCover");
        $range1_member3->addLabel("Back Cover");

        $range2 = new Range();
        $manifest->addStructure($range2);
        $range2->setID("http://example.org/iiif/book1/range/r1");
        $range2->addLabel("Introduction");

        $range2_range1 = new Range();
        $range2->addRange($range2_range1);
        $range2_range1->returnOnlyID();
        $range2_range1->setID("http://example.org/iiif/book1/range/r1-1");

        $range2_canvas1 = new Canvas();
        $range2->addCanvas($range2_canvas1);
        $range2_canvas1->returnOnlyID();
        $range2_canvas1->setID("http://example.org/iiif/book1/canvas/p1");

        $range2_canvas2 = new Canvas();
        $range2->addCanvas($range2_canvas2);
        $range2_canvas2->returnOnlyID();
        $range2_canvas2->setID("http://example.org/iiif/book1/canvas/p2");

        $range2_canvas3 = new Canvas();
        $range2->addCanvas($range2_canvas3);
        $range2_canvas3->returnOnlyID();
        $range2_canvas3->setID("http://example.org/iiif/book1/canvas/p3#xywh=0,0,750,300");

        $range3 = new Range();
        $manifest->addStructure($range3);
        $range3->setID("http://example.org/iiif/book1/range/r1-1");
        $range3->addLabel("Objectives and Scope");

        $range3_canvas1 = new Canvas();
        $range3->addCanvas($range3_canvas1);
        $range3_canvas1->returnOnlyID();
        $range3_canvas1->setID("http://example.org/iiif/book1/canvas/p2#xywh=0,0,500,500");

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/manifest2.json',$this->generator->generate($manifest));

    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#comment-annotations
     */
    public function testCreateManifest3()
    {
        $manifest = new Manifest(true);

        $manifest->setID("http://example.org/iiif/book1/manifest");
        $manifest->addLabel("Book 1");

        $metadata = new Metadata();
        $manifest->setMetadata($metadata);
        $metadata->addLabelValue("Author", "Anne Author");
        $metadata->addLabelMultiValue("Published", array(
            array("value" => "Paris, circa 1400", "language" => "en" ),
            array("value" => "Paris, environ 14eme siecle", "language" => "fr" ),
        ));

        $manifest->addDescription("A longer description of this example book. It should give some real information.");
        $manifest->setNavDate("1856-01-01T00:00:00Z");
        $manifest->addLicense("http://example.org/license.html");
        $manifest->addAttribution("Provided by Example Organization");

        $service = new Service();
        $manifest->addService($service);
        $service->setContext("http://example.org/ns/jsonld/context.json");
        $service->setID("http://example.org/service/example");
        $service->setProfile("http://example.org/docs/example-service.html");

        $seeAlso = new SeeAlso();
        $manifest->addSeeAlso($seeAlso);
        $seeAlso->setID("http://example.org/library/catalog/book1.marc");
        $seeAlso->setFormat("application/marc");
        $seeAlso->setProfile("http://example.org/profiles/marc21");

        $rendering = new Rendering();
        $manifest->addRendering($rendering);
        $rendering->setID("http://example.org/iiif/book1.pdf");
        $rendering->setLabel("Download as PDF");
        $rendering->setFormat("application/pdf");

        $manifest->addWithin("http://example.org/collections/books/");

        $sequence = new Sequence();
        $manifest->addSequence($sequence);
        $sequence->setID("http://example.org/iiif/book1/sequence/normal");
        $sequence->addLabel("Current Page Order");
        $sequence->setViewingDirection(ViewingDirection::LEFT_TO_RIGHT);
        $sequence->addViewingHint(ViewingHint::PAGED);

        $sequence_canvas1 = new Canvas();
        $sequence->addCanvas($sequence_canvas1);
        $sequence_canvas1->setID("http://example.org/iiif/book1/canvas/p1");
        $sequence_canvas1->addLabel("p. 1");
        $sequence_canvas1->setHeight(1000);
        $sequence_canvas1->setWidth(750);

        $sequence_canvas1_annotation = new Annotation();
        $sequence_canvas1->addImage($sequence_canvas1_annotation);
        $sequence_canvas1_annotation->setOn("http://example.org/iiif/book1/canvas/p1");

        $sequence_canvas1_annotation_content = new Content();
        $sequence_canvas1_annotation->setContent($sequence_canvas1_annotation_content);
        $sequence_canvas1_annotation_content->setID("http://example.org/iiif/book1/res/page1.jpg");
        $sequence_canvas1_annotation_content->setType(DCType::IMAGE);
        $sequence_canvas1_annotation_content->setFormat("image/jpeg");
        $sequence_canvas1_annotation_content->setHeight(2000);
        $sequence_canvas1_annotation_content->setWidth(1500);

        $sequence_canvas1_annotation_content_service = new Service();
        $sequence_canvas1_annotation_content->addService($sequence_canvas1_annotation_content_service);
        $sequence_canvas1_annotation_content_service->setContext("http://iiif.io/api/image/2/context.json");
        $sequence_canvas1_annotation_content_service->setID("http://example.org/images/book1-page1");
        $sequence_canvas1_annotation_content_service->setProfile("http://iiif.io/api/image/2/level1.json");

        $sequence_canvas1_annotatonlist = new AnnotationList();
        $sequence_canvas1->addOtherContent($sequence_canvas1_annotatonlist);
        $sequence_canvas1_annotatonlist->setID("http://example.org/iiif/book1/list/p1");

        $sequence_canvas1_annotatonlist_within = new Layer();
        $sequence_canvas1_annotatonlist->addWithin($sequence_canvas1_annotatonlist_within);
        $sequence_canvas1_annotatonlist_within->returnOnlyMemberData();
        $sequence_canvas1_annotatonlist_within->setID("http://example.org/iiif/book1/layer/l1");
        $sequence_canvas1_annotatonlist_within->addLabel("Example Layer");

        $sequence_canvas2 = new Canvas();
        $sequence->addCanvas($sequence_canvas2);
        $sequence_canvas2->setID("http://example.org/iiif/book1/canvas/p2");
        $sequence_canvas2->addLabel("p. 2");
        $sequence_canvas2->setHeight(1000);
        $sequence_canvas2->setWidth(750);

        $sequence_canvas2_annotation = new Annotation();
        $sequence_canvas2->addImage($sequence_canvas2_annotation);
        $sequence_canvas2_annotation->setOn("http://example.org/iiif/book1/canvas/p2");

        $sequence_canvas2_annotation_content = new Content();
        $sequence_canvas2_annotation->setContent($sequence_canvas2_annotation_content);
        $sequence_canvas2_annotation_content->setID("http://example.org/images/book1-page2/full/1500,2000/0/default.jpg");
        $sequence_canvas2_annotation_content->setType(DCType::IMAGE);
        $sequence_canvas2_annotation_content->setFormat("image/jpeg");
        $sequence_canvas2_annotation_content->setHeight(2000);
        $sequence_canvas2_annotation_content->setWidth(1500);

        $sequence_canvas2_annotation_content_service = new Service();
        $sequence_canvas2_annotation_content->addService($sequence_canvas2_annotation_content_service);
        $sequence_canvas2_annotation_content_service->setContext("http://iiif.io/api/image/2/context.json");
        $sequence_canvas2_annotation_content_service->setID("http://example.org/images/book1-page2");
        $sequence_canvas2_annotation_content_service->setProfile("http://iiif.io/api/image/2/level1.json");

        $sequence_canvas2_annotatonlist = new AnnotationList();
        $sequence_canvas2->addOtherContent($sequence_canvas2_annotatonlist);
        $sequence_canvas2_annotatonlist->setID("http://example.org/iiif/book1/list/p2");

        $sequence_canvas2_annotatonlist->addWithin("http://example.org/iiif/book1/layer/l1");

        $sequence_canvas3 = new Canvas();
        $sequence->addCanvas($sequence_canvas3);
        $sequence_canvas3->setID("http://example.org/iiif/book1/canvas/p3");
        $sequence_canvas3->addLabel("p. 3");
        $sequence_canvas3->setHeight(1000);
        $sequence_canvas3->setWidth(750);

        $sequence_canvas3_annotation = new Annotation();
        $sequence_canvas3->addImage($sequence_canvas3_annotation);
        $sequence_canvas3_annotation->setOn("http://example.org/iiif/book1/canvas/p3");

        $sequence_canvas3_annotation_content = new Content();
        $sequence_canvas3_annotation->setContent($sequence_canvas3_annotation_content);
        $sequence_canvas3_annotation_content->setID("http://example.org/iiif/book1/res/page3.jpg");
        $sequence_canvas3_annotation_content->setType(DCType::IMAGE);
        $sequence_canvas3_annotation_content->setFormat("image/jpeg");
        $sequence_canvas3_annotation_content->setHeight(2000);
        $sequence_canvas3_annotation_content->setWidth(1500);

        $sequence_canvas3_annotation_content_service = new Service();
        $sequence_canvas3_annotation_content->addService($sequence_canvas3_annotation_content_service);
        $sequence_canvas3_annotation_content_service->setContext("http://iiif.io/api/image/2/context.json");
        $sequence_canvas3_annotation_content_service->setID("http://example.org/images/book1-page3");
        $sequence_canvas3_annotation_content_service->setProfile("http://iiif.io/api/image/2/level1.json");

        $sequence_canvas3_annotatonlist = new AnnotationList();
        $sequence_canvas3->addOtherContent($sequence_canvas3_annotatonlist);
        $sequence_canvas3_annotatonlist->setID("http://example.org/iiif/book1/list/p3");

        $sequence_canvas3_annotatonlist->addWithin("http://example.org/iiif/book1/layer/l1");

        $structure = new Range();
        $manifest->addStructure($structure);
        $structure->setID("http://example.org/iiif/book1/range/r1");
        $structure->addLabel("Introduction");

        $structure_canvas1 = new Canvas();
        $structure->addCanvas($structure_canvas1);
        $structure_canvas1->returnOnlyID();
        $structure_canvas1->setID("http://example.org/iiif/book1/canvas/p1");

        $structure_canvas2 = new Canvas();
        $structure->addCanvas($structure_canvas2);
        $structure_canvas2->returnOnlyID();
        $structure_canvas2->setID("http://example.org/iiif/book1/canvas/p2");

        $structure_canvas3 = new Canvas();
        $structure->addCanvas($structure_canvas3);
        $structure_canvas3->returnOnlyID();
        $structure_canvas3->setID("http://example.org/iiif/book1/canvas/p3#xywh=0,0,750,300");

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/manifest3.json',$this->generator->generate($manifest));

    }

}
