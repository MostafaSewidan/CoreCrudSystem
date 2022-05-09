<?php

namespace Modules\Core\Traits;

use Spatie\Translatable\HasTranslations as BaseHasTranslations;
trait HasTranslations
{
    use BaseHasTranslations;

    protected $concatCols = [];

    /**
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, \App::getLocale());
        }

        return $attributes;
    }

    public function getConcatCols(){
        return $this->concatCols;
    }
}