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
 *  @package  Links
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Unit\PresentationAPI\Links;

use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Parameters\Identifier;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    private $service;

    public function setUp()
    {
        $this->service = new Service();
    }

    /**
     * Test the context.
     */
    public function testContext()
    {
        $context = "http://example.org/ns/jsonld/context.json";

        $this->service->setContext($context);

        $this->assertEquals($context, $this->service->getContext());
    }

    /**
     * Test to toArray method
     */
    public function testToArray()
    {
        $context = "http://example.org/ns/jsonld/context.json";
        $id = "http://example.org/service/example";
        $profile = "http://example.org/docs/example-service.html";
        $label = "Some Service";

        $this->service->setContext($context);
        $this->service->setID($id);
        $this->service->setProfile($profile);
        $this->service->setLabel($label);

        $array = $this->service->toArray();
        $this->assertEquals($context, $array[Identifier::CONTEXT]);
        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($profile, $array[Identifier::PROFILE]);
        $this->assertEquals($label, $array[Identifier::LABEL]);
    }

}