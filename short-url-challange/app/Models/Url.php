<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $table = 'urls';

    public static function generateShortCode()
    {
        return substr(md5(uniqid(rand(), true)), 0, 6);
    }
}
