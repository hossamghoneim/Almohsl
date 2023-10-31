<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShadowModel extends Model
{
    use HasFactory, SoftDeletes;
    public string $classBaseName = __CLASS__;
    public array $shadowTranslationFields = [];
    public $shadowForeignKey;

    public function shadowTranslations()
    {
        return $this->hasMany($this->classBaseName . "Translation", $this->shadowForeignKey);
    }
    public function setTranslationsIntoShadowTable($translations)
    {
        $model = app($this->classBaseName . "Translation");


        foreach ($translations as $lang => $translation)
        {
            $translations[$lang]['lang'] = $lang;
            $translations[$lang][ $this->shadowForeignKey ] = $this->id;
        }
        $model::upsert( array_values( $translations ) , ['lang' , $this->shadowForeignKey ] , $this->shadowTranslationFields );
    }

    public function getTranslationsAttribute() : array
    {
        $languages         = getAllLanguages();
        $defaultLangCode   = getDefaultLanguageCode();
        $modelTranslations = $this->shadowTranslations;
        $translations      = [];
        foreach ($languages as $language) {
            $translation = [];
            /** check if there are translations for given language **/
            if ($modelTranslations->where('lang', $language['code'])->count() > 0) {
                $translation = $modelTranslations->where('lang', $language['code'])->first()->only($this->shadowTranslationFields);
            }
            elseif ($modelTranslations->where('lang', $defaultLangCode)->count() > 0){   /** check translations by default lang **/
                $translation = $modelTranslations->where('lang',$defaultLangCode)->first()->only($this->shadowTranslationFields);
            }
            elseif( $modelTranslations->first() ) { /** get translations by first lang found **/
                $translation = $modelTranslations->first()->only($this->shadowTranslationFields);
            }
            $translations[$language['code']] = $translation;
        }
        return $translations;
    }
}
