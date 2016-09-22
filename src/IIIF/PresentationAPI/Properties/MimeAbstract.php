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
 *  @package  Properties
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/
namespace IIIF\PresentationAPI\Properties;

use IIIF\PresentationAPI\Links\Service;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Properties\PropertyAbstract;
use IIIF\Utils\ArrayCreator;

/**
 * Implementation for descriptive property resources
 *
 */
abstract class MimeAbstract extends PropertyAbstract {

    private $usedefaultservicecontext;
    private $service;

    private $defaultservicecontext = "http://iiif.io/api/image/2/context.json";

    /**
     * Check to see if the default service is needed to be added
     * @param bool $usedefaultservicecontext
     */
    function __construct($usedefaultservicecontext = true)
    {
      $this->usedefaultservicecontext = $usedefaultservicecontext;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Properties\PropertyInterface::setService()
     * @param \IIIF\PresentationAPI\Links\Service
     */
    public function setService(Service $service)
    {
        if ($this->usedefaultservicecontext) {
            $service->setContext($this->defaultservicecontext);
        }

        $this->service = $service;
    }

    /**
     * {@inheritDoc}
     * @see \IIIF\PresentationAPI\Properties\PropertyInterface::getService()
     * @return array|string
     */
    public function getService()
    {
        return $this->service;
    }

    public function toArray()
    {
        $item = array();
        ArrayCreator::addRequired($item, Identifier::ID, $this->getID(), "The id must be present in the thumbnail");
        ArrayCreator::addIfExists($item, Identifier::SERVICE, $this->getService());
        return $item;
    }
}