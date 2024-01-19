<?php

namespace Hoadev\CoreForm\Http\Controllers;

use App\Http\Controllers\Controller;
use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreForm\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->query('search');

        $current_status = $request->query('current_status');

        switch($current_status) {
            case 'trashed':
                $forms = Form::with(['postMetas'])
                    ->where('type', 'contact_form')
                    ->onlyTrashed()
                    ->latest()
                    ->paginate(10);
                break;

            case null:
                $forms = Form::with(['postMetas'])
                    ->where('type', 'contact_form')
                    ->latest()
                    ->paginate(10);
                break;

            default:
                $forms = Form::with(['postMetas'])
                    ->where('type', 'contact_form')
                    ->where('status', $current_status)
                    ->latest()
                    ->paginate(10);
                $forms->appends(['current_status' => $current_status]);
                break;
        }

        if($search !== null) {
            $forms->appends(['search' => $search]);
        }

        return Inertia::render('CoreForm/Admin/Form/Index', [
            'forms' => $forms,
            'current_status' => $current_status
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
            'contact_email' => 'required|string',
            'contact_phone' => 'required|string',
        ]);

        $post = Post::create([
            'title' => 'Đăng ký đại lý từ: '.$validated['contact_email'],
            'name' => $this->create_slug($validated['contact_email']),
            'type' => 'contact_form',
            'status' => 'pending'
        ]);

        $status = '';

        if ($post) {
            $post->postMetas()->createMany([
                [
                    'key' => 'contact_email',
                    'value' => $validated['contact_email'],
                ],
                [
                    'key' => 'contact_phone',
                    'value' => $validated['contact_phone'],
                ]
            ]);

            $status = 'success';

        }

        return view('coreform::guest.receipt', [
            'status' => $status
        ]);

    }

    protected function create_slug($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {


        return Inertia::render('CoreForm/Admin/Form/Edit', [
            'form' => $form->load('postMetas'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'post_metas' => 'array',
            'post_metas.*.id' => 'nullable|integer',

            'post_metas.*.key' => 'required|string',
            'post_metas.*.value' => 'nullable|string',
            'post_metas.*.autoload' => 'nullable|string',
        ]);

        $form->update($validated);

        //dung foreach
        foreach($validated['post_metas'] as $meta) {
            $form->postMetas()->updateOrCreate(
                [
                    'key' => $meta['key']
                ],
                [
                    'value' => $meta['value']
                ]
            );
        }

        session()->flash('message', 'Update successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $form->delete();

        Cache::tags(['posts'])->flush();

        return redirect()->route('admin.forms.index');
    }

    public function restore($id)
    {

        if($form = Form::withTrashed()->find($id)) {
            $form->restore();
            Cache::tags(['posts'])->flush();
        }

        return redirect()->route('admin.forms.index', ['current_status' => 'trashed']);
    }
}
