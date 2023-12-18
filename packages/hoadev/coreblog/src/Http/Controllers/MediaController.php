<?php

namespace Hoadev\CoreBlog\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Media;
use Hoadev\CoreBlog\Traits\Media\HasResponsive;
use Illuminate\Http\Request;
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

        $medias = Media::where('mime_type', 'like', $media_type.'%')
                        ->paginate(20);

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
    public function store(Request $request): string
    {
/*         dd($request->file('media')->getClientOriginalName()); */
        $media_type = $request->file('media_type', 'image');

        switch($media_type) {
            case 'image':

                return $this->storeImage($request);

                break;
            default:
                return null;
                break;
        }

        return redirect()->route('admin.medias.index');
    }

    public function storeImage(Request $request) {

        $validated = $request->validate([
            'media_type' => 'required|string',
            'name' => 'required|unique:media,name',
            'media' => 'required|file|mimes:jpg,png,webp,gif|max:2048',
        ]);

/*         $year = date('Y');
        $month = date('m');
        $parent_dir = 'images/'.$year.'/'.$month; */

        $image = $request->file('media');
        $imageName = $image->getClientOriginalName();
        $mime_type = $image->getClientmimeType();
        $extension = $image->getClientOriginalExtension();//Getting extension
        $imageData = $image->move('uploads/media/', $imageName);//This will store in customize folder
/*         dd($imageData->getPathname()); */
        $imageSize = $imageData->getSize();
        $dataDemen = getimagesize($imageData);
        $width = $dataDemen[0];
        $height = $dataDemen[1];

/*         $this->storeResponsive($image, $parent_dir, $imageName); */

/*         dd(storage_path('app/'.$path)); */

        $media = Media::create([
            'model_type' => 'Hoadev\CoreBlog\Models\Post',
            'model_id' => 0,
            'collection_name' => 'images',
            'name' => $validated['name'],
            'file_name' => $imageName,
            'mime_type' => $mime_type,
            'disk' => 'images',
            'size' => $imageSize,
            'manipulations' => '',
            'custom_properties' => [
                'path' => $imageData->getPathname(),
                'url' => str_replace('\\', '/', $imageData->getPathname()),
                'width' => $width,
                'height' => $height,
            ],
            'generated_conversions' => '',
            'responsive_images' => '',
        ]);

        /* $media->setResponsive(); */


/*         $fullPath = storage_path().'/app/'.$parent_dir.'/thumbnail_'.$imageName;

        return $this->scaleJpeg($image, $parent_dir, $imageName); */

        return $imageData->getPathname();
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
