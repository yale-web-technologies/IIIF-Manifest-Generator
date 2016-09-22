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
 *  @package  Links
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
*/

namespace IIIF\PresentationAPI\Links;

/**
 * Implemenation for SeeAlso property
 * http://iiif.io/api/presentation/2.1/#linking-properties
 *
 */
use IIIF\PresentationAPI\Links\LinkAbstract;
use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\Utils\ArrayCreator;

/**
 * Implemenation for SeeAlso property
 * http://iiif.io/api/presentation/2.1/#linking-properties
 *
 */
class SeeAlso extends LinkAbstract {

  /**
   * {@inheritDoc}
   *
   * @see \IIIF\PresentationAPI\Links\LinkAbstract::toArray()
   */
  public function toArray()
  {
      $item = array();

      $format = $this->getFormat();
      $profile = $this->getProfile();

      // If the profile and format are emtpy, return just and ID
      if (!empty($format) || !empty($profile)) {
        ArrayCreator::addRequired($item, Identifier::ID, $this->getID(), "The id must be present in the thumbnail");
        ArrayCreator::addIfExists($item, Identifier::FORMAT, $this->getFormat());
        ArrayCreator::addIfExists($item, Identifier::PROFILE, $this->getProfile());
        return $item;
      }
      else {
        return $this->getID();
      }
  }

}