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

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Parameters\ViewingDirection;
use IIIF\PresentationAPI\Resources\Annotation;
use IIIF\PresentationAPI\Resources\AnnotationList;
use IIIF\PresentationAPI\Resources\Manifest;
use IIIF\PresentationAPI\Resources\Sequence;
use PHPUnit\Framework\TestCase;

class ManifestTest extends TestCase
{
    private $manifest;

    public function setUp()
    {
        $this->manifest = new Manifest();
    }

    /**
     * Test the sequences
     */
    public function testSequence()
    {
        $this->manifest->addSequence($this->createMock(Sequence::class));

        $this->assertInstanceOf(Sequence::class, $this->manifest->getSequences()[0]);
    }

    /**
     * Test the structures
     */
    public function testStructure()
    {
        $this->manifest->addSequence($this->createMock(Sequence::class));

        $this->assertInstanceOf(Sequence::class, $this->manifest->getSequences()[0]);
    }

    /**
     * Test to make sure that an there are no issues with the sequence validation in a Manifest
     */
    public function testValidateSequence()
    {
        $sequence = $this->createMock(Sequence::class);
        $sequence->method('getID')->willReturn('http://www.example.org');
        $sequence->method('getType')->willReturn('sc:Sequence');
        $sequence->method('getLabels')->willReturn(array('My Sequence'));
        $sequence->method('getDefaultContext')->willReturn('http://iiif.io/api/presentation/2/context.json');

        $this->manifest->validateSequence($sequence);
    }

    /**
     * Test an invalid sequence
     */
    public function testValidateSequenceInvalidItemAdded()
    {
        $this->expectException(\Exception::class);

        $sequence = $this->createMock(Sequence::class);
        $sequence->method('getID')->willReturn('http://www.example.org');
        $sequence->method('getType')->willReturn('sc:Sequence');
        $sequence->method('getLabels')->willReturn(array('My Sequence'));
        $sequence->method('getDefaultContext')->willReturn('http://iiif.io/api/presentation/2/context.json');
        $sequence->method('getViewingDirection')->willReturn(ViewingDirection::LEFT_TO_RIGHT);

        $this->manifest->validateSequence($sequence);
    }

    /**
     * Test an invalid sequence
     */
    public function testValidateSequenceMissingLabel()
    {
        $this->expectException(\Exception::class);

        $sequence = $this->createMock(Sequence::class);
        $sequence->method('getID')->willReturn('http://www.example.org');
        $sequence->method('getType')->willReturn('sc:Sequence');
        $sequence->method('getDefaultContext')->willReturn('http://iiif.io/api/presentation/2/context.json');

        $this->manifest->validateSequence($sequence);
    }

    /**
     * Test an invalid sequence
     */
    public function testValidateAnnotationList()
    {
        $annotationList = $this->createMock(AnnotationList::class);
        $annotationList->method('getID')->willReturn('http://www.example.org');
        $annotationList->method('getType')->willReturn('sc:AnnotationList');
        $annotationList->method('getLabels')->willReturn(array('My Annotation List'));
        $annotationList->method('getDefaultContext')->willReturn('http://iiif.io/api/presentation/2/context.json');

        $this->manifest->validateAnnotationList($annotationList);
    }

    /**
     * Test an invalid sequence
     */
    public function testValidateAnnotationListInvalidItem()
    {
        $this->expectException(\Exception::class);

        $annotationList = $this->createMock(AnnotationList::class);
        $annotationList->method('getID')->willReturn('http://www.example.org');
        $annotationList->method('getType')->willReturn('sc:AnnotationList');
        $annotationList->method('getLabels')->willReturn(array('My Annotation List'));
        $annotationList->method('getDefaultContext')->willReturn('http://iiif.io/api/presentation/2/context.json');
        $annotationList->method('getNext')->willReturn('http://www.example.org/next');

        $this->manifest->validateAnnotationList($annotationList);
    }

    /**
     * Test the toArray method
     */
    public function testToArray()
    {

        $id = "http://example.org/iiif/book1/manifest";
        $label = "Book 1";
        $viewingDirection = ViewingDirection::RIGHT_TO_LEFT;
        $description = "A longer description of this example book. It should give some real information.";

        $this->manifest->setID($id);
        $this->manifest->addLabel($label);
        $this->manifest->setViewingDirection($viewingDirection);
        $this->manifest->addDescription($description);

        $array = $this->manifest->toArray();

        $this->assertEquals($id, $array[Identifier::ID]);
        $this->assertEquals($this->manifest->type, $array[Identifier::TYPE]);
        $this->assertEquals($label, $array[Identifier::LABEL]);
        $this->assertEquals($viewingDirection, $array[Identifier::VIEWINGDIRECTION]);
        $this->assertEquals($description, $array[Identifier::DESCRIPTION]);

    }
}
