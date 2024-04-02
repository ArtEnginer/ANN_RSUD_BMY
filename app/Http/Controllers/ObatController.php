<?php

namespace App\Http\Controllers;

use App\Models\Obat as Model;
use Illuminate\Http\Request;

class ObatController extends BaseApi
{
    protected $modelName = Model::class;
}
