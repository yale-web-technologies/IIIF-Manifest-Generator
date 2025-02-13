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
 *  @package  Metadata
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\Test\Unit\PresentationAPI\Metadata;

use IIIF\PresentationAPI\Metadata\Metadata;
use IIIF\PresentationAPI\Parameters\Identifier;
use PHPUnit\Framework\TestCase;


class MetadataTest extends TestCase
{
    private $metadata;

    public function setUp(): void
    {
        $this->metadata = new Metadata();
    }

    /**
     * Test the addLabelValue method.
     */
    public function testAddLabelValue()
    {
        $label = "Author";
        $value = "Anne Author";
        $this->metadata->addLabelValue($label, $value);

        $this->assertEquals(array(Identifier::LABEL => $label, Identifier::VALUE => $value), $this->metadata->getData()[0]);
    }

    /**
     * Test the addLabelMultiValue method.
     */
    public function testAddLabelMultiValue()
    {
        $label = "Published";
        $values = array(
            array("value" => "Paris, circa 1400", "language" => "en"),
            array("value" => "Paris, environ 14eme siecle", "language" => "fr")
        );

        $this->metadata->addLabelMultiValue($label, $values);

        $newvalues =  array(
            array(Identifier::ATVALUE => "Paris, circa 1400",  Identifier::LANGUAGE => "en"),
            array(Identifier::ATVALUE  => "Paris, environ 14eme siecle", Identifier::LANGUAGE => "fr")
        );

        $this->assertEquals(array(Identifier::LABEL => $label, Identifier::VALUE => $newvalues), $this->metadata->getData()[0]);
    }

    /**
     * Test the addMultiLabelMultiValue method.
     */
    public function testAddMultiLabelMultiValue()
    {
        $labels = array(
            array("value" => "Title", "language" => "en"),
            array("value" => "作品名稱", "language" => "zh")
        );

        $values = array(
            array("value" => "Kongzi ji yu", "language" => "en"),
            array("value" => "孔子集語", "language" => "zh")
        );

        $this->metadata->addMultiLabelMultiValue($labels, $values);

        $newlabels = array(
            array(Identifier::ATVALUE => "Title", Identifier::LANGUAGE => "en"),
            array(Identifier::ATVALUE => "作品名稱", Identifier::LANGUAGE => "zh"),
        );

        $newvalues = array(
            array(Identifier::ATVALUE => "Kongzi ji yu", Identifier::LANG => "en"),
            array(Identifier::ATVALUE => "孔子集語", Identifier::LANG => "zh")
        );

        $this->assertEquals(array(Identifier::LABEL => $newlabels, Identifier::VALUE => $newvalues), $this->metadata->getData()[0]);
    }

    /**
     * Test the toArray using each on of the three methods for adding data.
     */
    public function testToArrayAddLabelValue()
    {
        $label1 = "Author";
        $value1 = "Anne Author";
        $this->metadata->addLabelValue($label1, $value1);

        $label2 = "Published";
        $values2 = array(
            array("value" => "Paris, circa 1400", "language" => "en"),
            array("value" => "Paris, environ 14eme siecle", "language" => "fr")
        );

        $this->metadata->addLabelMultiValue($label2, $values2);

        $labels3 = array(
            array("value" => "Title", "language" => "en"),
            array("value" => "作品名稱", "language" => "zh")
          );

         $values3 = array(
            array("value" => "Kongzi ji yu", "language" => "en"),
            array("value" => "孔子集語", "language" => "zh")
         );

        $this->metadata->addMultiLabelMultiValue($labels3, $values3);

        $data = $this->metadata->toArray();

        $this->assertEquals($label1, $data[0]['label']);
        $this->assertEquals($value1, $data[0]['value']);

        $newvalues2 =  array(
            array(Identifier::ATVALUE => "Paris, circa 1400",  Identifier::LANGUAGE => "en"),
            array(Identifier::ATVALUE  => "Paris, environ 14eme siecle", Identifier::LANGUAGE => "fr")
        );
        $this->assertEquals($label2, $data[1]['label']);
        $this->assertEquals($newvalues2, $data[1]['value']);

        $newlabels3 = array(
            array(Identifier::ATVALUE => "Title", Identifier::LANGUAGE => "en"),
            array(Identifier::ATVALUE => "作品名稱", Identifier::LANGUAGE => "zh"),
        );

        $newvalues3 = array(
            array(Identifier::ATVALUE => "Kongzi ji yu", Identifier::LANG => "en"),
            array(Identifier::ATVALUE => "孔子集語", Identifier::LANG => "zh")
        );

        $this->assertEquals($newlabels3, $data[2]['label']);
        $this->assertEquals($newvalues3, $data[2]['value']);

    }

}