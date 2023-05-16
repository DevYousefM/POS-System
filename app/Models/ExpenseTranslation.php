<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ["reason"];
}
