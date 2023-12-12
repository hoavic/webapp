<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Taxonomy;
use Hoadev\CoreBlog\Models\Term;
use Illuminate\Database\Eloquent\Builder;
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

        $search = $request->query('search');

        $taxonomies = Taxonomy::with(['term', 'ancestors.term'])
                        ->where('taxonomy', $taxonomy)
                        ->whereHas('term', function (Builder $query) use($search) {
                            $query->where('name', 'like', '%'.$search.'%');
                        })
                        ->defaultOrder()
                        ->paginate(10);

        $taxonomies->appends(['taxonomy' => $taxonomy]);

        if($search !== null) {
            $taxonomies->appends(['search' => $search]);
        }

        return Inertia::render('CoreBlog/Admin/Term/Index', [
            'taxonomy' => $taxonomy,
            'search' => $search,
            'taxonomies' => $taxonomies,
            'allTaxonomies' => Taxonomy::with(['term', 'ancestors'])->where('taxonomy', $taxonomy)->defaultOrder()->get()
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
            'taxonomy.description' => 'nullable|string',
            'taxonomy.parent_id' => 'nullable|integer',
            'taxonomy.count' => 'required|integer',
        ]);

/*         dd($validated); */

        $term = Term::create($validated['term']);

        if ($term) {
            $term->taxonomy()->create($validated['taxonomy']);
        }

        /* return to_route('terms.index', ['taxonomy='.$validated['taxonomy']['taxonomy']]); */
        return redirect()->route('admin.terms.index', ['taxonomy='.$validated['taxonomy']['taxonomy']])->with('message', 'Add '.$term->name.' Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($taxonomy, $slug)
    {

        Inertia::setRootView('layouts.guest');

        $term = Term::where('slug', $slug)->first();

        if($term) {
            return Inertia::render('CoreBlog/Admin/Term/Show', [
                'taxonomy' => $taxonomy,
                'term' => $term->load(['termMetas', 'taxonomy']),
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term)
    {
        $term = $term->load(['termMetas', 'taxonomy']);

        $taxonomies = Taxonomy::where('taxonomy', $term->taxonomy->taxonomy)->with('term')->get();

        return Inertia::render('CoreBlog/Admin/Term/Edit', [
            'taxonomy' => $term->taxonomy->taxonomy,
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
            'taxonomy.id' => 'required|integer',
            'taxonomy.taxonomy' => 'required|string',
            'taxonomy.description' => 'nullable|string',
            'taxonomy.parent_id' => 'nullable|integer',
            'taxonomy.count' => 'required|integer',
        ]);

/*         dd($validated); */

        $term->update($validated);

        $term->taxonomy()->update($validated['taxonomy']);

        // đáng lẽ không cần, nhưng nestedset cần
        $taxonomy = Taxonomy::find($validated['taxonomy']['id']);
        if($validated['taxonomy']['parent_id'] === null) {
            $taxonomy->makeRoot()->save();
        } else {
            $parent = Taxonomy::find($validated['taxonomy']['parent_id']);
            $parent->prependNode($taxonomy);
        }


        /* return to_route('terms.index', ['taxonomy='.$validated['taxonomy']['taxonomy']]); */
        return redirect()->route('admin.terms.index', ['taxonomy='.$validated['taxonomy']['taxonomy']])->with('message', 'Update '.$term->name.' Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Term $term)
    {
        $taxonomy = $term->taxonomy;
        if($term->delete()) {$taxonomy->delete();}

        /* return to_route('terms.index', ['taxonomy='.$request->query('taxonomy', 'category')])->with('success', 'your message,here'); */
        return redirect()->route('admin.terms.index', ['taxonomy='.$request->query('taxonomy', 'category')])->with('message', 'Delete '.$term->name.' Successfully!');
    }
}
