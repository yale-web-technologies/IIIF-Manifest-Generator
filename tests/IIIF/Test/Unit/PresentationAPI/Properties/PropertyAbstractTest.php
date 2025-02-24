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
 *  @category TenThousandRooms\Test\Unit
 *  @package  Properties
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Unit\PresentationAPI\Properties;

use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Properties\PropertyAbstract;
use PHPUnit\Framework\TestCase;

/**
 * Test the rights and licensing properties that require more than just string information
 *
 */
class Property extends PropertyAbstract {

    public function toArray(){
    }

    public function setService(Service $service){
    }

    public function getService(){
    }
}

class PropertyAbstractTest extends TestCase
{
    private $property;

    public function setUp(): void
    {
        $this->property = new Property();
    }

    /**
     * Test the id.
     */
    public function testID()
    {
        $id = "http://example.org/images/book1-page1/full/80,100/0/default.jpg";

        $this->property->setID($id);

        $this->assertEquals($id, $this->property->getID());

    }
}