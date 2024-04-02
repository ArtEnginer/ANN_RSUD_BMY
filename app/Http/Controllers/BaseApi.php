<?php

namespace App\Http\Controllers;

use App\Models\Obat as Model;
use Illuminate\Http\Request;

class BaseApi extends Controller
{
    protected $modelName;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->modelName::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->modelName::create($request->all());
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->modelName::findorFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = $this->modelName::findorFail($id);
        $data->update($request->all());
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $data)
    {
        $data = $this->modelName::findorFail($data);
        $data->delete();
        return $data;
    }
}
