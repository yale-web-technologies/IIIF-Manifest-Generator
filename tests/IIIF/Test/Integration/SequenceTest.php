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
use IIIF\PresentationAPI\Parameters\ViewingDirection;
use IIIF\PresentationAPI\Parameters\ViewingHint;
use IIIF\PresentationAPI\Resources\Canvas;
use IIIF\PresentationAPI\Resources\Sequence;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Sequence Resource
 *
 */
class SequenceTest extends TestCase
{

    private $generator;

    public function setUp(): void
    {
        $this->generator = new Generator();
    }

    /**
     * Testing the following json:
     * http://iiif.io/api/presentation/2.1/#sequence
     */
    public function testCreateLayer1()
    {
        $sequence = new Sequence(true);

        $sequence->setID("http://example.org/iiif/book1/sequence/normal");
        $sequence->addLabel("Current Page Order");
        $sequence->setViewingDirection(ViewingDirection::LEFT_TO_RIGHT);
        $sequence->addViewingHint(ViewingHint::PAGED);
        $sequence->setStartCanvas("http://example.org/iiif/book1/canvas/p2");

        $canvas1 = new Canvas();
        $sequence->addCanvas($canvas1);
        $canvas1->setID("http://example.org/iiif/book1/canvas/p1");
        $canvas1->addLabel("p. 1");
        $canvas1->setHeight(1000);
        $canvas1->setWidth(500);

        $canvas2 = new Canvas();
        $sequence->addCanvas($canvas2);
        $canvas2->setID("http://example.org/iiif/book1/canvas/p2");
        $canvas2->addLabel("p. 2");
        $canvas2->setHeight(1000);
        $canvas2->setWidth(500);

        $canvas3 = new Canvas();
        $sequence->addCanvas($canvas3);
        $canvas3->setID("http://example.org/iiif/book1/canvas/p3");
        $canvas3->addLabel("p. 3");
        $canvas3->setHeight(1000);
        $canvas3->setWidth(500);

        $this->assertJsonStringEqualsJsonFile(dirname(__FILE__).'/files/sequence.json',$this->generator->generate($sequence));
    }

}
