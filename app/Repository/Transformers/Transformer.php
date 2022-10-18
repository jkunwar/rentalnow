<?php

namespace App\Repository\Transformers;

abstract class Transformer
{
    /*
     * Transforms a collection
     * @param $lessons
     * @return array
     */
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}
