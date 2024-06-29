<?php

namespace Geekpack\Api\Models;

use Illuminate\Database\Eloquent\Model;

class ApiRoute extends Model
{
    protected $fillable = ['type', 'route', 'controller', 'class', 'name', 'middleware', 'function'];
}
