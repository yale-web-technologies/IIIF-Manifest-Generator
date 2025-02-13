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

use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Properties\MimeAbstract;
use PHPUnit\Framework\TestCase;

class Mime extends MimeAbstract {
}

/**
 * Test the rights and licensing properties that require more than just string information
 *
 */
class MimeAbstractTest extends TestCase
{
    private $mime;
    private $service;

    public function setUp(): void
    {
        $this->mime = new Mime();
        $this->service = $this->createMock(Service::class);
    }

    /**
     * Test the service.
     */
    public function testService()
    {
      $this->mime->setService($this->service);

      $this->assertInstanceOf(Service::class, $this->mime->getService());

    }

    /**
     * Test the toArray Method
     */
    public function testToArray()
    {
        $id =  "http://example.org/logos/institution1.jpg";

        $this->mime->setID($id);
        $array = $this->mime->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
    }


    /**
     * Test the toArray Method with no ID set
     */
    public function testToArrayNoID()
    {
        $this->expectException(\Exception::class);
        $this->mime->setService($this->service);
        $this->mime->toArray();
    }
}