<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Indicate Table name
    protected $table = 'posts';
    // Primary key
    public $primaryKey = 'id';
    //Timestamps
    public $itemstamps = true;
}
