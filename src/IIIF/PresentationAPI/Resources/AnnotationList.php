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
*/

namespace IIIF\PresentationAPI\Resources;

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Parameters\Paging;
use IIIF\PresentationAPI\Resources\ResourceAbstract;
use IIIF\Utils\ArrayCreator;
use IIIF\Utils\Validator;

/**
 * Implementation of an AnnotationList resource:
 * http://iiif.io/api/presentation/2.1/#annotation-list
 */
class AnnotationList extends ResourceAbstract {

    private $next;
    private $prev;
    private $startIndex;

    private $annotations = array();

    public $type = "sc:AnnotationList";

    /**
     * Add an annotation.
     *
     * @param \IIIF\PresentationAPI\Resources\Annotation $annotation
     */
    public function addAnnotation(Annotation $annotation)
    {
      array_push($this->annotations, $annotation);
    }

    /**
     * Get all annotations.
     *
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * Set the next property.
     *
     * @param string $next
     */
    public function setNext($next)
    {
        $this->next = $next;
    }

    /**
     * Get the next property.
     *
     * @return string
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Set the prev property.
     *
     * @param string $prev
     */
    public function setPrev($prev)
    {
        $this->prev = $prev;
    }

    /**
     * Get the prev property.
     *
     * @return string
     */
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * Set the startIndex.
     *
     * @param int $startIndex
     */
    public function setStartIndex($startIndex)
    {
        Validator::greaterThanEqualZero($startIndex, "The startIndex must be greater than zero");
        $this->startIndex = $startIndex;
    }

    /**
     * Get the startIndex.
     *
     * @return int
     */
    public function getStartIndex()
    {
        return $this->startIndex;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceAbstract::toArray()
     * @return array
     */
    public function toArray()
    {
      if ($this->getOnlyID()) {
          $id = $this->getID();
          Validator::itemExists($id, "The id must be present in an Annotation List");
          return $id;
      }

        $item = array();

        /** Technical Properties **/
        if ($this->isTopLevel()) {
          ArrayCreator::addRequired($item, Identifier::CONTEXT, $this->getContexts(), "The context must be present in an Annotation List");
        }
        ArrayCreator::addRequired($item, Identifier::ID, $this->getID(), "The id must be present in an Annotation List");
        ArrayCreator::addRequired($item, Identifier::TYPE, $this->getType(), "The type must be present in an Annotation List");
        ArrayCreator::addIfExists($item, Identifier::VIEWINGHINT, $this->getViewingHints());

        /** Descriptive Properties **/
        ArrayCreator::addIfExists($item, Identifier::LABEL, $this->getLabels());
        ArrayCreator::addIfExists($item, Identifier::METADATA, $this->getMetadata());
        ArrayCreator::addIfExists($item, Identifier::DESCRIPTION, $this->getDescriptions());
        ArrayCreator::addIfExists($item, Identifier::THUMBNAIL, $this->getThumbnails());

        /** Rights and Licensing Properties **/
        ArrayCreator::addIfExists($item, Identifier::ATTRIBUTION, $this->getAttributions());
        ArrayCreator::addIfExists($item, Identifier::LICENSE, $this->getLicenses());
        ArrayCreator::addIfExists($item, Identifier::LOGO, $this->getLogos());

        /** Linking Properties **/
        ArrayCreator::addIfExists($item, Identifier::RELATED, $this->getRelated());
        ArrayCreator::addIfExists($item, Identifier::RENDERING, $this->getRendering());
        ArrayCreator::addIfExists($item, Identifier::SERVICE, $this->getServices());
        ArrayCreator::addIfExists($item, Identifier::SEEALSO, $this->getSeeAlso());
        ArrayCreator::addIfExists($item, Identifier::WITHIN, $this->getWithin());

        /** Paging Properties **/
        ArrayCreator::addIfExists($item, Paging::NEXT, $this->getNext());
        ArrayCreator::addIfExists($item, Paging::PREVIOUS, $this->getPrev());
        ArrayCreator::addIfExists($item, Paging::STARTINDEX, $this->getStartIndex());

        /** Resource Types **/
        ArrayCreator::addIfExists($item, Identifier::RESOURCES, $this->getAnnotations());

        return $item;
    }

}
