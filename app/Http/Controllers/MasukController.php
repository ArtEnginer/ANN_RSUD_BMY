<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk as Model;
use Illuminate\Http\Request;

class MasukController extends BaseApi
{
    protected $modelName = Model::class;

    public function index()
    {
        return $this->modelName::all()->load("obat");
    }
}
