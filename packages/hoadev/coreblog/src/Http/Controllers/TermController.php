<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreBlog\Models\Term;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $taxonomy = $request->query('taxonomy', 'category');

        $taxonomies = Taxonomy::where('taxonomy', $taxonomy)->with(['term', 'term.termMetas'])->paginate(10);

        $taxonomies->appends(['taxonomy' => $taxonomy]);

        if($request->query('search') !== null) {
            $taxonomies->appends(['search' => $request->query('search')]);
        }

        return Inertia::render('CoreBlog/Admin/Term/Index', [
            'taxonomy' => $taxonomy,
            'taxonomies' => $taxonomies
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
        $validated = $request->validate([
            'term.name' => 'required|string',
            'term.slug' => 'nullable|string|unique:terms,slug',
            'term.group' => 'required|integer',
            'taxonomy.taxonomy' => 'required|string',
            'taxonomy.desxription' => 'nullable|string',
            'taxonomy.parent_id' => 'required|integer',
            'taxonomy.count' => 'required|integer',
        ]);

/*         dd($validated); */

        $term = Term::create($validated['term']);

        if ($term) {
            $term->taxonomy()->create($validated['taxonomy']);
        }

        return to_route('terms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term)
    {
        $term = $term->load(['termMetas', 'taxonomy']);

        $taxonomies = Taxonomy::where('taxonomy', $term->taxonomy->taxonomy)->with('term')->get();

        return Inertia::render('CoreBlog/Admin/Term/Edit', [
            'term' => $term,
            'taxonomies' => $taxonomies
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Term $term)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'slug' => 'nullable|string|unique:terms,slug,'.$term->id,
            'group' => 'required|integer',
            'taxonomy' => 'array',
            'taxonomy.taxonomy' => 'required|string',
            'taxonomy.desxription' => 'nullable|string',
            'taxonomy.parent_id' => 'required|integer',
            'taxonomy.count' => 'required|integer',
        ]);

/*         dd($validated); */

        $term->update($validated);

        $term->taxonomy()->update($validated['taxonomy']);

        return to_route('terms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Term $term)
    {
        //
    }
}
