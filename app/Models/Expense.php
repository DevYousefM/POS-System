<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ["reason"];

    protected $fillable = ["value"];
}
