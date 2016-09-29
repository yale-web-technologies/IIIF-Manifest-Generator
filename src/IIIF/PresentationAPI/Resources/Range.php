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
 *  @category IIIF\PresentationAPI
 *  @package  Resources
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 *
*/

namespace IIIF\PresentationAPI\Resources;

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Resources\ResourceAbstract;
use IIIF\Utils\ArrayCreator;
use IIIF\Utils\Validator;

/**
 * Implementation of a Range resource:
 * http://iiif.io/api/presentation/2.1/#range
 */
class Range extends ResourceAbstract {

    private $onlymemberdata = false;
    private $startCanvas;
    private $contentLayer;

    private $ranges = array();
    private $canvases = array();
    private $members = array();

    public $type = "sc:Range";

    /**
     * {@inheritDoc}
     *
     * @see \IIIF\PresentationAPI\Resources\ResourceAbstract::setID()
     */
    public function setID($id)
    {
      Validator::validateURL($id, "The ID for a Range must be a valid URL");
      parent::setID($id);
    }

    /**
     * Set the startCanvas.
     *
     * @param string
     */
    public function setStartCanvas($startCanvas)
    {
      $this->startCanvas = $startCanvas;
    }

    /**
     * Get the startCanvas.
     *
     * @return string
     */
    public function getStartCanvas()
    {
      return $this->startCanvas;
    }

    /**
     * Add a range.
     *
     * @param \IIIF\PresentationAPI\Resources\Range $range
     */
    public function addRange(Range $range)
    {
        array_push($this->ranges, $range);
    }

    /**
     * Get all the ranges.
     *
     * @return array
     */
    public function getRanges()
    {
      return $this->ranges;
    }

    /**
     * Add a canvas.
     *
     * @param \IIIF\PresentationAPI\Resources\Canvas $canvas
     */
    public function addCanvas(Canvas $canvas)
    {
        array_push($this->canvases, $canvas);
    }

    /**
     * Get all the canvases.
     *
     * @return array
     */
    public function getCanvases()
    {
      return $this->canvases;
    }

    /**
     * Add a range or a canvas. This is used where ordering is important.
     *
     * @param \IIIF\PresentationAPI\Resources\Range|\IIIF\PresentationAPI\Resources\Canvas $member
     */
    public function addMember($member)
    {
        // Verify that the member being added is either a Range or Canvas type.
        if (!$member instanceof Range && !$member instanceof Canvas) {
          throw new \Exception("A Member of a Range must either be a Range or Canvas");
        }
        else {
          $member->returnOnlyMemberData();
          array_push($this->members, $member);
        }
    }

    /**
     * Get the members.
     *
     * @return array
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set the contentLayer.
     *
     * @param string $contentLayer
     */
    public function setContentLayer($contentLayer)
    {
        $this->contentLayer = $contentLayer;
    }

    /**
     * Get the contentLayer.
     *
     * @return string
     */
    public function getContentLayer()
    {
        return $this->contentLayer;
    }

    /**
     * Make sure the member is valid.
     *
     * @param \IIIF\PresentationAPI\Resources\Range|\IIIF\PresentationAPI\Resources\Canvas $member
     */
    public function validateMember ($member)
    {
        $methods = array(
            'getID',
            'getType',
            'getLabels'
        );
        Validator::shouldContainItems($member, $methods, 'A member within a Range must contain the ID, Type and Label');
    }

    public function toArray()
    {
        if ($this->getOnlyID()) {
            $id = $this->getID();
            Validator::itemExists($id, "The id must be present in a Range");
            return $id;
        }

        $item = array();

        if ($this->getOnlyMemberData()) {
          ArrayCreator::addRequired($item, Identifier::ID, $this->getID(), "The id must be present in the Canvas");
          ArrayCreator::addRequired($item, Identifier::TYPE, $this->getType(), "The type must be present in the Canvas");
          ArrayCreator::addRequired($item, Identifier::LABEL, $this->getLabels(), "The label must be present in the Canvas");
          ArrayCreator::addIfExists($item, Identifier::CONTENTLAYER, $this->getContentLayer());

          return $item;
        }

        /** Technical Properties **/
        if ($this->isTopLevel()) {
            ArrayCreator::addRequired($item, Identifier::CONTEXT, $this->getContext(), "The context must be present in the Range");
        }
        ArrayCreator::addRequired($item, Identifier::ID, $this->getID(), "The id must be present in the Range");
        ArrayCreator::addRequired($item, Identifier::TYPE, $this->getType(), "The type must be present in the Range");
        ArrayCreator::addIfExists($item, Identifier::VIEWINGHINT, $this->getViewingHints());
        ArrayCreator::addIfExists($item, Identifier::VIEWINGDIRECTION, $this->getViewingDirection());


        /** Descriptive Properties **/
        ArrayCreator::addRequired($item, Identifier::LABEL, $this->getLabels(), "The label must be present in the Range");
        ArrayCreator::addIfExists($item, Identifier::METADATA, $this->getMetadata());
        ArrayCreator::addIfExists($item, Identifier::DESCRIPTION, $this->getDescriptions());
        ArrayCreator::addIfExists($item, Identifier::THUMBNAIL, $this->getThumbnails());

        /** Rights and Licensing Properties **/
        ArrayCreator::addIfExists($item, Identifier::LICENSE, $this->getLicenses());
        ArrayCreator::addIfExists($item, Identifier::ATTRIBUTION, $this->getAttributions());
        ArrayCreator::addIfExists($item, Identifier::LOGO, $this->getLogos());

        /**  Linking Properties **/
        ArrayCreator::addIfExists($item, Identifier::RELATED, $this->getRelated());
        ArrayCreator::addIfExists($item, Identifier::RENDERING, $this->getRendering());
        ArrayCreator::addIfExists($item, Identifier::SERVICE, $this->getServices());
        ArrayCreator::addIfExists($item, Identifier::SEEALSO, $this->getSeeAlso());
        ArrayCreator::addIfExists($item, Identifier::WITHIN, $this->getWithin());
        ArrayCreator::addIfExists($item, Identifier::CONTENTLAYER, $this->getContentLayer());
        ArrayCreator::addIfExists($item, Identifier::STARTCANVAS, $this->getStartCanvas());

        /** Resource Types **/
        ArrayCreator::addIfExists($item, Identifier::CANVASES, $this->getCanvases(), false);
        ArrayCreator::addIfExists($item, Identifier::RANGES, $this->getRanges(), false);
        ArrayCreator::addIfExists($item, Identifier::MEMBERS, $this->getMembers(), false);

        return $item;
    }

}
