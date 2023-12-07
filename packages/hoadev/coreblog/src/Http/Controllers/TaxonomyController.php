<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Taxonomy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxonomyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $taxonomies = '';

        return Inertia::render('CoreBlog/Admin/Taxonomy/Index', [
            'taxonomys' => $taxonomies
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Taxonomy $taxonomy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Taxonomy $taxonomy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Taxonomy $taxonomy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Taxonomy $taxonomy)
    {
        //
    }
}
