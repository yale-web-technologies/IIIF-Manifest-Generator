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

use IIIF\PresentationAPI\Links\LinkAbstract;
use PHPUnit\Framework\TestCase;

class Link extends LinkAbstract {

  public function toArray() {}

}

class LinkAbstractTest extends TestCase
{
    private $link;

    public function setUp(): void
    {
        $this->link = new Link();
    }

   /**
    * Test to make sure the ID is set properly.
    */
   public function testID()
   {
       $id = "http://www.example.org";
       $this->link->setID($id);
       $this->assertEquals($id, $this->link->getID());
   }

   /**
    * Test to make sure the format is set properly.
    */
   public function testFormat()
   {
       $format = "text/html";
       $this->link->setFormat($format);
       $this->assertEquals($format, $this->link->getFormat());
   }

   /**
    * Test to make sure the profile is set properly.
    */
   public function testProfile()
   {
       $profile = "http://example.org/docs/example-service.html";
       $this->link->setProfile($profile);
       $this->assertEquals($profile, $this->link->getProfile());
   }

   /**
    * Test to make sure the label is set properly.
    */
   public function testLabel()
   {
       $label = "Download as HTML";
       $this->link->setLabel($label);
       $this->assertEquals($label, $this->link->getLabel());
   }

}

