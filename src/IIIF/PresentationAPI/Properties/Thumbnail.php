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

use IIIF\PresentationAPI\Parameters\Identifier;
use IIIF\PresentationAPI\Properties\MimeAbstract;
use IIIF\Utils\ArrayCreator;

/**
 * Implementation of thumbnail descriptive property
 * http://iiif.io/api/presentation/2.1/#thumbnail
 *
 */
class Thumbnail extends MimeAbstract {

    private $type;
    private $width;
    private $height;

  /**
   * Set the type.
   *
   * @param string $type
   */
  public function setType($type)
  {
    $this->type = $type;
  }

  /**
   * Get the type.
   *
   * @return string
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * Set the width.
   *
   * @param int $width
   */
  public function setWidth($width)
  {
    $this->width = $width;
  }

  /**
   * Get the width.
   *
   * @return int
   */
  public function getWidth()
  {
    return $this->width;
  }

  /**
   * Set the height.
   *
   * @param int $height
   */
  public function setHeight($height)
  {
    $this->height = $height;
  }

  /**
   * Get the height.
   *
   * @return int
   */
  public function getHeight()
  {
    return $this->height;
  }

  public function toArray() {
    $item = parent::toArray();

    ArrayCreator::addIfExists($item, Identifier::TYPE, $this->getType());
    ArrayCreator::addIfExists($item, Identifier::HEIGHT, $this->getHeight());
    ArrayCreator::addIfExists($item, Identifier::WIDTH, $this->getWidth());

    return $item;
  }

}