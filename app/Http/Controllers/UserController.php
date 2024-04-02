<?php

namespace App\Http\Controllers;

use App\Models\User as Model;
use Illuminate\Http\Request;

class UserController extends BaseApi
{
    protected $modelName = Model::class;
}
