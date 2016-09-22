<?php

namespace IIIF\Utils;

class Validator {

    public static function itemExists($item, $message)
    {
        if (empty($item)) {
            throw new \Exception($message);
        }

        return true;
    }

    public static function inArray($item, $array, $message)
    {
      if (!in_array($item, $array)) {
        throw new \Exception($message);
      }

      return true;
    }

    public static function validateURL($url, $message)
    {
      if (!filter_var($url, FILTER_VALIDATE_URL) !== false) {
        throw new \Exception($message);
      }

      return true;
    }

    public static function greaterThanZero($num, $message)
    {
        if (!is_int($num) || !($num > 0)) {
          throw new \Exception($message);
        }

        return true;
    }

    public static function greaterThanEqualZero($num, $message)
    {
        if (!is_int($num) || !($num >= 0)) {
          throw new \Exception($message);
        }

        return true;
    }

    /**
     * Test to make sure the methods of a class are not empty
     *
     * @param Class $item
     * @param array $methods
     * @param string $message
     * @throws \Exception
     */
    public static function shouldContainItems($item, $methods, $message)
    {
        foreach($methods as $method) {
            if (empty($item->$method())) {
              throw new \Exception($message);
            }
        }

    }

    /**
     *  Make sure the embedded object does not contain extra items
     * @param Object $item
     * @param string $classname
     * @param array $exclusions
     * @param string $message
     * @throws \Exception
     */
    public static function shouldNotContainItems($item, $classname, $exclusions, $message)
    {
        $class =  new \ReflectionClass($classname);
        foreach ($class->getMethods() as $method) {
            $name = $method->name;
            if (substr( $name, 0, 3 ) == "get" && !in_array($name, $exclusions)) {
                if (!empty($item->$name())) {
                    throw new \Exception($message);
                }
            }
        }
    }
  }