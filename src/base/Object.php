<?php

namespace bitaps\base;

use phpDocumentor\Reflection\DocBlock;

class Object
{
    /**
     * Object constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $reflection = new \ReflectionClass($this);

        foreach ($config as $attribute => $value) {
            $this->{$attribute} = $value;

            $property = $reflection->getProperty($attribute);

            if (!($doc = new DocBlock($property->getDocComment()))) {
                continue;
            }

            if (!($tag = $doc->getTagsByName('var'))) {
                continue;
            }

            $type = $tag->getType();

            if (strpos($type, '[]') !== false) {
                $class = str_replace('[]', '', $tag->getType());
                if (!class_exists($class)) {
                    continue;
                }

                $this->{$attribute} = [];
                foreach ($value as $item) {
                    $this->{$attribute}[] = new $class($item);
                }
            } else {
                if (class_exists($type)) {
                    $this->{$attribute} = new $type($value);
                }
            }
        }
    }
}