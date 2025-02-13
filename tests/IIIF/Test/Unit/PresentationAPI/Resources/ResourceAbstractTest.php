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

use IIIF\PresentationAPI\Links\SeeAlso;
use IIIF\PresentationAPI\Links\Related;
use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Links\Rendering;
use IIIF\PresentationAPI\Metadata\Metadata;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Parameters\ViewingDirection;
use IIIF\PresentationAPI\Parameters\ViewingHint;
use IIIF\PresentationAPI\Properties\Thumbnail;
use IIIF\PresentationAPI\Properties\Logo;
use IIIF\PresentationAPI\Resources\ResourceAbstract;
use PHPUnit\Framework\TestCase;

class Resource extends ResourceAbstract
{
    protected $type = "sc:Test";

    public function toArray()
    {}
}

class ResourceAbstractTest extends TestCase
{

    private $resource;

    public function setUp(): void
    {
        $this->resource = new Resource();
    }

    /**
     * Test the onlyid property.
     */
    public function testOnlyID()
    {
        $this->resource->returnOnlyID();

        $this->assertEquals(true, $this->resource->getOnlyID());
    }

    /**
     * Test the onlymemberdata property.
     */
    public function testOnlyMemberData()
    {
        $this->resource->returnOnlyMemberData();

        $this->assertEquals(true, $this->resource->getOnlyMemberData());
    }

    /**
     * Test the toplevel property.
     */
    public function testIsTopLevel()
    {
        $this->assertEquals(false, $this->resource->isTopLevel());

        $resource = new Resource(true);

        $this->assertEquals(true, $resource->isTopLevel());
    }

    /**
     * Test the context property.
     */
    public function testContexts()
    {
        $resource = new Resource(true);

        $this->assertEquals($resource->getDefaultContext(), $resource->getContexts());

        $newContext = "http://example.org/extension/context.json";

        $resource->addContext($newContext);

        $this->assertEquals($resource->getDefaultContext(), $resource->getContexts()[0]);
        $this->assertEquals($newContext, $resource->getContexts()[1]);
    }

    /**
     * Test the ID property.
     */
    public function testID()
    {
        $id = "http://example.org/iiif/book1/manifest";

        $this->resource->setID("http://example.org/iiif/book1/manifest");

        $this->assertEquals($id, $this->resource->getID());
    }

    /**
     * Test the type property.
     */
    public function testType()
    {
        $this->assertEquals('sc:Test', $this->resource->getType());
    }

    /**
     * Test the label property.
     */
    public function testLabel()
    {
        $label = "Book 1";
        $language = "en";

        $this->resource->addLabel($label);

        $this->assertEquals($label, $this->resource->getLabels()[0]);

        $this->resource->addLabel($label, $language);

        $this->assertEquals(array(Identifier::ATVALUE => $label, Identifier::LANGUAGE => $language), $this->resource->getLabels()[1]);
    }

    /**
     * Test the viewingHint property.
     */
    public function testViewingHint()
    {
        $viewingHint = ViewingHint::TOP;

        $this->resource->addViewingHint($viewingHint);

        $this->assertEquals($viewingHint, $this->resource->getViewingHints()[0]);
    }

    /**
     * Test a bad value for the viewingHint.
     */
    public function testViewingHintInvalid()
    {
        $this->expectException(\Exception::class);

        $viewingHint = "Bad Value";

        $this->resource->addViewingHint($viewingHint);
    }

    /**
     * Test the description property.
     */
    public function testDescriptions()
    {
        $description = "A longer description of this example book. It should give some real information.";

        $this->resource->addDescription($description);

        $this->assertEquals($description, $this->resource->getDescriptions()[0]);

        $description2 = "Here is a longer description of the object";
        $language = "en";

        $this->resource->addDescription($description2, $language);

        $this->assertEquals(array(Identifier::ATVALUE => $description2, Identifier::LANGUAGE => $language), $this->resource->getDescriptions()[1]);
    }

    /**
     * Test the attribution property.
     */
    public function testAttributions()
    {
        $attribution = "Provided by Example Organization";

        $this->resource->addAttribution($attribution);

        $this->assertEquals($attribution, $this->resource->getAttributions()[0]);

        $attribution2 = "Provided by Another Organization";
        $language = "en";

        $this->resource->addAttribution($attribution2, $language);

        $this->assertEquals(array(Identifier::ATVALUE => $attribution2, Identifier::LANGUAGE => $language), $this->resource->getAttributions()[1]);
    }

    /**
     * Test the license property.
     */
    public function testLicenses()
    {
        $license = "http://example.org/license.html";

        $this->resource->addLicense($license);

        $this->assertEquals($license, $this->resource->getLicenses()[0]);
    }

    /**
     * Test an invalid license property.
     */
    public function testLicensesInvalid()
    {
        $this->expectException(\Exception::class);

        $license = "Not a URL";

        $this->resource->addLicense($license);
    }

    /**
     * Test the Thumbnail resource.
     */
    public function testThumbnail()
    {
        $this->resource->addThumbnail($this->createMock(Thumbnail::class));

        $this->assertInstanceOf(Thumbnail::class, $this->resource->getThumbnails()[0]);
    }

    /**
     * Test the Logo resource.
     */
    public function testLogo()
    {
        $this->resource->addLogo($this->createMock(Logo::class));

        $this->assertInstanceOf(Logo::class, $this->resource->getLogos()[0]);
    }

    /**
     * Test the Metadata resource.
     */
    public function testMetadata()
    {
        $this->resource->setMetadata($this->createMock(Metadata::class));

        $this->assertInstanceOf(Metadata::class, $this->resource->getMetadata());
    }

    /**
     * Test the seeAlso resource.
     */
    public function testSeeAlso()
    {
        $this->resource->addSeeAlso($this->createMock(SeeAlso::class));

        $this->assertInstanceOf(SeeAlso::class, $this->resource->getSeeAlso()[0]);
    }

    /**
     * Test the navDate property.
     */
    public function testNavDate()
    {
        $navDate = "1856-01-01T00:00:00Z";

        $this->resource->setNavDate($navDate);

        $this->assertEquals($navDate, $this->resource->getNavDate());
    }

    /**
     * Test an invalid navDate property.
     */
    public function testNavDateInvalid()
    {
        $navDate = "Bad Nav Date";

        $this->resource->setNavDate($navDate);

        $this->assertEquals("00:00:00", $this->resource->getNavDate());
    }

    /**
     * Test the Service property.
     */
    public function testService()
    {
        $this->resource->addService($this->createMock(Service::class));

        $this->assertInstanceOf(Service::class, $this->resource->getServices()[0]);
    }

    /**
     * Test the Related property.
     */
    public function testRelated()
    {
        $this->resource->addRelated($this->createMock(Related::class));

        $this->assertInstanceOf(Related::class, $this->resource->getRelated()[0]);
    }

    /**
     * Test the Rendering property.
     */
    public function testRendering()
    {
        $this->resource->addRendering($this->createMock(Rendering::class));

        $this->assertInstanceOf(Rendering::class, $this->resource->getRendering()[0]);
    }

    /**
     * Test the within property.
     */
    public function testWithin()
    {
        $within = "http://example.org/collections/books/";

        $this->resource->addWithin($within);

        $this->assertEquals($within, $this->resource->getWithin()[0]);
    }

    /**
     * Test the viewingDirection property.
     */
    public function testViewingDirection()
    {
        $viewingDirection = ViewingDirection::LEFT_TO_RIGHT;

        $this->resource->setViewingDirection($viewingDirection);

        $this->assertEquals($viewingDirection, $this->resource->getViewingDirection());
    }

    /**
     * Test a bad value for the viewingDirection.
     */
    public function testViewingDirectionInvalid()
    {
        $this->expectException(\Exception::class);

        $veiwingDirection = "Bad Value";

        $this->resource->setViewingDirection($veiwingDirection);
    }







}
