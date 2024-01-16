<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use App\Http\Controllers\Controller;
use App\Models\Project;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $types = Type::all();
        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        //
        $form_data = $request->validated();
        $form_data['slug'] = Str::slug($form_data['name'], '-');
        $type = Type::create($form_data);
        return to_route('admin.types.show', compact('type'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
        return view('admin.types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        //
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        //
        $form_data = $request->validated();
        if ($type->name != $form_data['name']) {
            $form_data['slug'] = Str::slug($form_data['name']);
        }
        $type->update($form_data);
        return to_route('admin.types.show', compact('type'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        //
        $type->delete();
        return to_route('admin.types.index')->with('message', "The type : $type->name, has been removed");
    }
}
