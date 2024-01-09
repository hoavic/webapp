<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Classes\Image;
use Hoadev\CoreBlog\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $media_type = $request->query('media_type', 'image');

        $search = $request->query('search');
/*
        $medias = Media::where('mime_type', 'like', $media_type.'%')
                        ->where('file_name', 'like', '%'.$search.'%')
                        ->paginate(20); */
        $currentPage = $request->query('page', 1);
        $medias = Cache::tags(['medias'])->remember('medias_type:'.$media_type.'_search:'.$search.'_page:'.$currentPage, 3600, function() use ($media_type, $search){
            return Media::where('mime_type', 'like', $media_type.'%')
                            ->where('file_name', 'like', '%'.$search.'%')
                            ->latest()
                            ->paginate(20);
        });

        $medias->appends(['media_type' => $media_type]);

        if($search !== null) {
            $medias->appends(['search' => $search]);
        }

        return Inertia::render('CoreBlog/Admin/Media/Index', [
            'media_type' => $media_type,
            'search' => $search,
            'medias' => $medias,
            'available_media_types' => array('image', 'video', 'document', 'other')
        ]);
    }

    public function popup(Request $request)
    {
        Inertia::setRootView('layouts.popup');
        $media_type = $request->query('media_type', 'image');

/*         $search = $request->query('search');
        $currentPage = request()->get('page',1); */


        return Inertia::render('CoreBlog/Admin/Media/Popup', [
            'media_type' => $media_type,
/*             'search' => $search, */
/*             'medias' => Inertia::lazy(fn () => $this->paginateLoad($media_type, $search, $currentPage)), */
            'available_media_types' => array('image', 'video', 'document', 'other')
        ]);
    }

    public function popupData(Request $request) {

        $media_type = $request->query('media_type', 'image');

        $search = $request->query('search');
        $currentPage = $request->query('page', 1);

        $medias = Cache::tags(['medias'])->remember('medias_popup_type:'.$media_type.'_search:'.$search.'_page:'.$currentPage, 3600, function() use ($media_type, $search){
            return Media::where('mime_type', 'like', $media_type.'%')
                            ->where('file_name', 'like', '%'.$search.'%')
                            ->latest()
                            ->paginate(20);
        });

/*         $medias = Media::where('mime_type', 'like', $media_type.'%')
                            ->where('file_name', 'like', '%'.$search.'%')
                            ->latest()
                            ->paginate(20); */

        if($search !== null) {
            $medias->appends(['search' => $search]);
        }

        $medias->appends(['media_type' => $media_type]);

        return $medias;

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
/*         dd($request->file('media')->getClientOriginalName()); */
        $media_type = $request->file('media_type', 'image');

        switch($media_type) {
            case 'image':

                $this->storeImage($request);
                break;

            default:
                return null;
                break;
        }
        Cache::tags(['medias'])->flush();
        session()->flash('message', 'success');

        /* return redirect()->route('admin.medias.index'); */
    }

    public function storeImage(Request $request) {

        $validated = $request->validate([
            'media_type' => 'required|string',
            'file_names.*' => 'required|string|unique:media,file_name',
            'medias'    => 'array',
            'media.*' => 'required|file|mimes:jpg,png,webp,gif|max:2048',
            'optimized_for_blog' => 'required|boolean',
            'optimized_for_product' => 'required|boolean',
            'optimized_for_template' => 'required|boolean',
        ]);

        foreach($request->file('medias') as $media) {
            $this->handleImageUpload($media, $validated['optimized_for_blog'], $validated['optimized_for_product'], $validated['optimized_for_template']);
        }
    }

    public function handleImageUpload($media, $optimized_for_blog = true, $optimized_for_product = false, $optimized_for_template = false) {
        $image = new Image();
        $image->loadFile($media, 'uploads/media/', true); // convert to webp
        $responsive = $image->setResponsive($optimized_for_blog, $optimized_for_product, $optimized_for_template);

        $media = Media::create([
            'model_type' => 'Hoadev\CoreBlog\Models\Post',
            'model_id' => 0,
            'collection_name' => 'images',
            'name' => $image->name, //name
            'file_name' => $image->imageName,
            'mime_type' => $image->mime_type,
            /* 'mime_type' => 'image/webp', */
            'disk' => 'images',
            'size' => $image->size,
            'manipulations' => '',
            'custom_properties' => [
                'path' => $image->getPath(),
                'url' => $image->getUrl(),
                'originUrl' => $image->getOriginUrl(),
                'width' => $image->width,
                'height' => $image->height,
            ],
            'generated_conversions' => '',
            'responsive_images' => $responsive,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        return Inertia::render('CoreBlog/Admin/Media/Edit', [
            'media' => $media,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
    }
}
