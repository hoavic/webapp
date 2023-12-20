<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Classes\Image;
use Hoadev\CoreBlog\Models\Media;
use Hoadev\CoreBlog\Traits\Media\HasResponsive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\ImageManager;

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
        $currentPage = request()->get('page',1);
        $medias = Cache::remember('medias_type:'.$media_type.'_search:'.$search.'_page:'.$currentPage, 3600, function() use ($media_type, $search){
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

        $medias = Cache::remember('medias_type:'.$media_type.'_search:'.$search.'_page:'.$currentPage, 3600, function() use ($media_type, $search){
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
        session()->flash('message', 'success');
        return redirect()->route('admin.medias.index');
    }

    public function storeImage(Request $request) {

        $validated = $request->validate([
            'media_type' => 'required|string',
            'name' => 'required|unique:media,name',
            'media' => 'required|file|mimes:jpg,png,webp,gif|max:2048',
        ]);

        $image = new Image();
        $image->loadFile($request->file('media'));
        $responsive = $image->setResponsive();

/*         $year = date('Y');
        $month = date('m');
        $parent_dir = 'images/'.$year.'/'.$month; */

/*         $image = $request->file('media');
        $imageName = $image->getClientOriginalName();
        $mime_type = $image->getClientmimeType();
        $extension = $image->getClientOriginalExtension();//Getting extension
        $imageData = $image->move('uploads/media/', $imageName);//This will store in customize folder
        $imageSize = $imageData->getSize();
        $dataDemen = getimagesize($imageData);
        $width = $dataDemen[0];
        $height = $dataDemen[1]; */

/*         $this->storeResponsive($image, $parent_dir, $imageName); */

/*         dd(storage_path('app/'.$path)); */

        $media = Media::create([
            'model_type' => 'Hoadev\CoreBlog\Models\Post',
            'model_id' => 0,
            'collection_name' => 'images',
            'name' => $validated['name'],
            'file_name' => $image->imageName,
            'mime_type' => $image->mime_type,
            'disk' => 'images',
            'size' => $image->size,
            'manipulations' => '',
            'custom_properties' => [
                'path' => $image->getPath(),
                'url' => $image->getUrl(),
                'width' => $image->width,
                'height' => $image->height,
            ],
            'generated_conversions' => '',
            'responsive_images' => $responsive,
        ]);

        /* $media->setResponsive(); */


/*         $fullPath = storage_path().'/app/'.$parent_dir.'/thumbnail_'.$imageName;

        return $this->scaleJpeg($image, $parent_dir, $imageName); */

        return $media;
    }



/*     public function scaleToJpeg($manager, $image, $parent_dir, $width, $height, $sizeName) {
        $manager->read($image->getRealPath())
            ->scale($width, $height)
            ->toJpeg()
            ->save(storage_path('app').'/'.$parent_dir.'/'.$this->addSizeToFileName($image->getClientOriginalName(), $sizeName));
    } */


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
        //
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
