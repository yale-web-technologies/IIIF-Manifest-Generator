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
 *  @category IIIF
 *  @package  Utils
 *  @author   Harry Shyket <harry.shyket@yale.edu>
 *  @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 *
*/

namespace IIIF\Utils;

class ArrayCreator {

    /**
     * Add an item to the array.
     * @param array $array
     * @param string $key
     * @param string $value
     */
    public static function add(&$array, $key, $value, $flatten = TRUE)
    {
      if ($flatten && is_array($value) && count($value) == 1) {
          $value = $value[0];
      }

      $array[$key] = self::checkToArray($value);
    }

    /**
     * The item must exist and be added to the array.
     * @param array $array
     * @param string $key
     * @param string $value
     * @param string $message
     * @param bool $flatten
     * @throws \Exception
     */
    public static function addRequired(&$array, $key, $value, $message, $flatten = TRUE)
    {
      if (empty($value)) {
          throw new \Exception($message);
      }
      else {
        self::add($array, $key, $value, $flatten);
      }
    }

    /**
     * Add the item if there are 1 or more elements in the array value.
     * @param array $array
     * @param string $key
     * @param string|int|array $value
     */
    public static function addIfExists(&$array, $key, $value, $flatten = TRUE)
    {
      if (!empty($value)) {
          self::add($array, $key, $value, $flatten);
       }

    }

    /**
     * Check the array to see if subclasses need to have arrays generated.
     * @param array $value
     */
    private function checkToArray(&$value)
    {
        if (is_array($value)) {
          foreach($value as &$class) {
            if (method_exists($class, "toArray")) {
              $class = $class->toArray();
            }
          }
        }
        else {
         if (method_exists($value, "toArray")) {
           $value = $value->toArray();
         }
        }

        return $value;
    }

}