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

use IIIF\PresentationAPI\Links\Related;
use IIIF\PresentationAPI\Links\Rendering;
use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Metadata\Metadata;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Parameters\ViewingHint;
use IIIF\PresentationAPI\Properties\Logo;
use IIIF\PresentationAPI\Properties\Thumbnail;
use IIIF\PresentationAPI\Resources\ResourceInterface;
use IIIF\Utils\Validator;

/**
 * Abstract implementation of a resource
 */
abstract class ResourceAbstract implements ResourceInterface {

    private $id;
    private $onlyid         = false;
    private $istoplevel     = false;
    private $onlymemberdata = false;

    protected $type;
    protected $defaultcontext = "http://iiif.io/api/presentation/2/context.json";
    protected $viewingdirection;
    protected $navdate;

    protected $contexts       = array();
    protected $labels         = array();
    protected $viewinghints   = array();
    protected $descriptions   = array();
    protected $attributions   = array();
    protected $licenses       = array();
    protected $thumbnails     = array();
    protected $logos          = array();
    protected $metadata       = array();
    protected $seealso        = array();
    protected $services       = array();
    protected $related        = array();
    protected $rendering      = array();
    protected $within         = array();


    /**
     * Sets whether the item is a top level item.
     * @param boolean $top
     */
    function __construct($top = false) {
        $this->istoplevel = (bool)$top;

        if ($this->istoplevel) {
          $this->addContext($this->getDefaultContext());
        }
    }

    /**
     * Set just the id to return instead of the class object.
     */
    public function returnOnlyID()
    {
        $this->onlyid = true;
    }

    /**
     * Check whether to only return the ID instead of the object.
     *
     * @return boolean
     */
    public function getOnlyID()
    {
        return $this->onlyid;
    }

    /**
     * Usage when a resource only needs @id, @type and label.
     */
    public function returnOnlyMemberData()
    {
        $this->onlymemberdata = true;
    }

    /**
     * Return whether only certain data fields are needed.
     *
     * @return boolean
     */
    public function getOnlyMemberData()
    {
        return $this->onlymemberdata;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::isTopLevel()
     * @return bool;
     */
    public function isTopLevel()
    {
        return $this->istoplevel;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addContext()
     * @param string
     */
    public function addContext($context)
    {
      array_push($this->contexts, $context);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getContext()
     * @return array
     */
    public function getContexts()
    {
        if (count($this->contexts) == 1) {
          return $this->contexts[0];
        }
        return $this->contexts;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getDefaultContext()
     * @return string
     */
    public function getDefaultContext()
    {
        return $this->defaultcontext;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::setID()
     * @param string
     */
    public function setID($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getID()
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getType()
     * @return string
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addLabel()
     * @param string
     * @param string
     */
    public function addLabel($label, $language = NULL)
    {
      if (!empty($language)) {
        $label = array(Identifier::ATVALUE => $label, Identifier::LANGUAGE => $language);
      }

      array_push($this->labels, $label);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getLabelss()
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addViewingHints()
     * @param string
     */
    public function addViewingHint($viewinghint)
    {
        // Make sure that the viewing hint is an allowed value
        $allviewinghints = new \ReflectionClass('\IIIF\PresentationAPI\Parameters\ViewingHint');
        if (Validator::inArray($viewinghint, $allviewinghints->getConstants(), "Illegal viewingHint selected")) {
          array_push($this->viewinghints, $viewinghint);
        }
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getViewingHints()
     * @return array
     */
    public function getViewingHints()
    {
        return $this->viewinghints;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addDescription()
     * @param string
     * @param string
     */
    public function addDescription($description, $language = NULL)
    {
        if (!empty($language)) {
          $description = array(Identifier::ATVALUE => $description, Identifier::LANGUAGE => $language);
        }

        array_push($this->descriptions, $description);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getDescriptions()
     * @return string
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addAttribution()
     * @param string
     * @param string
     */
    public function addAttribution($attribution, $language = NULL)
    {
        if (!empty($language)) {
            $attribution = array(Identifier::ATVALUE => $attribution, Identifier::LANGUAGE => $language);
        }

        array_push($this->attributions, $attribution);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getAttributions()
     * @return array
     */
    public function getAttributions()
    {
        return $this->attributions;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addLicense()
     * @param string
     */
    public function addLicense($license)
    {
        // Make sure it is a valid URL
        if (Validator::validateURL($license, "The license must be a valid URL")) {
          array_push($this->licenses, $license);
        }
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getLicenses()
     * @return array
     */
    public function getLicenses()
    {
        return $this->licenses;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addThumbnail()
     * @param \IIIF\PresentationAPI\Properties\Thumbnail
     */
    public function addThumbnail(Thumbnail $thumbnail)
    {
        array_push($this->thumbnails, $thumbnail);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getThumbnails()
     * @return array
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addLogo()
     * @param \IIIF\PresentationAPI\Properties\Logo
     */
    public function addLogo(Logo $logo)
    {
        array_push($this->logos, $logo);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getLogos()
     * @return array
     */
    public function getLogos()
    {
        return $this->logos;
    }

    /**
     * Set the metadata
     * @param \IIIF\PresentationAPI\Metadata\Metadata $metadata
     */
    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Get the metadata
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addSeeAlso()
     * @param  \IIIF\PresentationAPI\Links\SeeAlso $seealso
     */
    public function addSeeAlso($seealso)
    {
        array_push($this->seealso, $seealso);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getAttributions()
     * @return array
     */
    public function getSeeAlso()
    {
        return $this->seealso;
    }

    /**
    * Set the navDate.
    * @param Date $navdate
    */
    public function setNavDate($navdate)
    {
        date_default_timezone_set("UTC");
        $time = strtotime($navdate);

        if ($time) {
          $this->navdate = date("Y-d-m\TH:i:s\Z", strtotime($navdate));
        }
        else {
          $this->navdate = "00:00:00";
        }
    }

    /**
    * Get the navDate
    */
    public function getNavDate()
    {
        return $this->navdate;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addService()
     * @param \IIIF\PresentationAPI\Links\Service
     */
    public function addService(Service $service)
    {
        array_push($this->services, $service);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getAttributions()
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addRelated()
     */
    public function addRelated(Related $related)
    {
        array_push($this->related, $related);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getRelated()
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addRendering()
     */
    public function addRendering(Rendering $rendering)
    {
        array_push($this->rendering, $rendering);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getRendering()
     */
    public function getRendering()
    {
        return $this->rendering;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::addWithin()
     */
    public function addWithin($within)
    {
        array_push($this->within, $within);
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::getWithin()
     */
    public function getWithin()
    {
        return $this->within;
    }

    /**
     * Set the viewing direction.
     *
     * @param string $viewingdirection
     */
    public function setViewingDirection($viewingdirection)
    {
        // Make sure that the viewing hint is an allowed value
        $allviewingdirections = new \ReflectionClass('\IIIF\PresentationAPI\Parameters\ViewingDirection');
        if (Validator::inArray($viewingdirection, $allviewingdirections->getConstants(), "Illegal viewingDirection selected")) {
            $this->viewingdirection =  $viewingdirection;
        }
    }

    /**
     * Get the viewng direction.
     *
     * @return string
     */
    public function getViewingDirection()
    {
        return $this->viewingdirection;
    }

    /**
     * Create an array from the class elements.
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Resources\ResourceInterface::toArray()
     */
    abstract public function toArray();

}
