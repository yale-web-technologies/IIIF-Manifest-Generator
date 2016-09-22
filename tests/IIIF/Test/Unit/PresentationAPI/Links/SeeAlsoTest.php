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

use IIIF\PresentationAPI\Links\SeeAlso;
use IIIF\PresentationAPI\Parameters\Identifier;
use PHPUnit\Framework\TestCase;

class SeeAlsoTest extends TestCase
{
    private $seeAlso;

    public function setUp()
    {
        $this->seeAlso = new SeeAlso();
    }

    /**
     * Test to toArray method.
     */
    public function testToArray()
    {

        $id = "http://example.org/descriptions/book1.xml";
        $format = "text/xml";
        $profile = "http://example.org/profiles/bibliographic";

        $this->seeAlso->setID($id);
        $this->seeAlso->setFormat($format);
        $this->seeAlso->setProfile($profile);

        $array = $this->seeAlso->toArray();
        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($format, $array[Identifier::FORMAT]);
        $this->assertEquals($profile, $array[Identifier::PROFILE]);
    }

    /**
     * Test toArray method with ID only.
     */
    public function testToArrayIdOnly()
    {
        $id =  "http://example.org/descriptions/book1.csv";

        $this->seeAlso->setID($id);

        $this->assertEquals($id, $this->seeAlso->toArray());
    }
}