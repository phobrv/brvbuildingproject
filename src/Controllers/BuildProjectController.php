<?php

namespace Phobrv\BrvBuildingProject\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\BrvCore\Repositories\PostRepository;
use Phobrv\BrvCore\Repositories\TermRepository;
use Phobrv\BrvCore\Repositories\UserRepository;
use Phobrv\BrvCore\Services\PostServices;
use Phobrv\BrvCore\Services\UnitServices;
use Phobrv\BrvCore\Services\VString;

class BuildProjectController extends Controller
{
    protected $userRepository;
    protected $postRepository;
    protected $termRepository;
    protected $unitService;
    protected $type;
    protected $taxonomy;
    protected $vstring;
    protected $postService;

    public function __construct(
        VString $vstring,
        PostServices $postService,
        UserRepository $userRepository,
        PostRepository $postRepository,
        TermRepository $termRepository,
        UnitServices $unitService) {
        $this->vstring = $vstring;
        $this->postService = $postService;
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->termRepository = $termRepository;
        $this->unitService = $unitService;
        $this->type = config('option.post_type.buildproject');
        $this->taxonomy = config('term.taxonomy.buildprojectgroup');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        //Breadcrumb
        $data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
            [
                ['text' => 'Projects', 'href' => ''],
            ]
        );

        try {
            $data['select'] = $this->userRepository->getMetaValueByKey($user, 'project_select');
            if ($data['select']) {
                $data['posts'] = $this->termRepository->getPostsByTermID($data['select']);
            } else {
                $data['posts'] = $this->postRepository->orderBy('created_at', 'desc')->with('user')->all()->where('type', $this->type);
            }
            $data['arrayGroup'] = $this->termRepository->getArrayTerms($this->taxonomy);
            return view('phobrv::buildproject.index')->with('data', $data);
        } catch (Exception $e) {
            return back()->with('alert_danger', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Breadcrumb
        $data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
            [
                ['text' => 'Projects', 'href' => ''],
                ['text' => 'Create Project', 'href' => ''],
            ]
        );

        try {
            $data['arrayGroup'] = $this->termRepository->getTermsOrderByParent($this->taxonomy);
            $data['arrayGroupID'] = array();
            return view('phobrv::buildproject.create')->with('data', $data);
        } catch (Exception $e) {
            return back()->with('alert_danger', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['slug' => $this->vstring->standardKeyword($request->title)]);
        $data = $request->all();

        $request->validate(
            [
                'slug' => 'required|unique:posts',
            ],
            [
                'slug.unique' => 'Title đã tồn tại',
                'slug.required' => 'Title không được phép để rỗng',
            ]
        );

        $data['user_id'] = Auth::id();

        $data['type'] = $this->type;

        $post = $this->postRepository->create($data);

        $this->handleMeta($post, $request);

        $msg = __('Create post success!');
        if ($request->typeSubmit == 'save') {
            return redirect()->route('buildproject.index')->with('alert_success', $msg);
        } else {
            return redirect()->route('buildproject.edit', ['buildproject' => $post->id])->with('alert_success', $msg);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Breadcrumb
        $data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
            [
                ['text' => 'Projects', 'href' => ''],
                ['text' => 'Edit Project', 'href' => ''],
            ]
        );

        try {
            $data['arrayGroup'] = $this->termRepository->getTermsOrderByParent($this->taxonomy);
            $data['post'] = $this->postRepository->find($id);
            $data['arrayGroupID'] = $this->termRepository->getArrayTermID($data['post']->terms, $this->taxonomy);
            $data['meta'] = $this->postService->getMeta($data['post']->postMetas);
            return view('phobrv::buildproject.create')->with('data', $data);
        } catch (Exception $e) {
            return back()->with('alert_danger', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->merge(['slug' => $this->vstring->standardKeyword($request->title)]);
        $request->validate(
            [
                'slug' => 'required|unique:posts,slug,' . $id,
            ],
            [
                'slug.unique' => 'Title đã tồn tại',
                'slug.required' => 'Title không được phép để rỗng',
            ]
        );

        $data = $request->all();

        $post = $this->postRepository->update($data, $id);

        $this->handleMeta($post, $request);

        $msg = __('Update project success!');
        if ($request->typeSubmit == 'save') {
            return redirect()->route('buildproject.index')->with('alert_success', $msg);
        } else {
            return redirect()->route('buildproject.edit', ['buildproject' => $post->id])->with('alert_success', $msg);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepository->destroy($id);
        $msg = __("Delete post success!");
        return redirect()->route('buildproject.index')->with('alert_success', $msg);
    }

    public function updateUserSelectGroup(Request $request)
    {
        $user = Auth::user();
        $this->userRepository->insertMeta($user, array('project_select' => $request->select));
        return redirect()->route('buildproject.index');
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;

        $p = $this->postRepository->findWhere(['id' => $id])->first();

        $status = ($p->status == 1) ? 0 : 1;

        $this->postRepository->update(['status' => $status], $p->id);

        return $status;

    }

    public function setGroupSelect($id)
    {
        $user = Auth::user();
        $this->userRepository->insertMeta($user, array('project_select' => $id));
        return redirect()->route('buildproject.index');
    }

    public function handleMeta($post, $request)
    {
        $arrayMeta = [];
        $arrayMeta['project_type'] = isset($request->project_type) ? $request->project_type : '';
        $arrayMeta['address'] = isset($request->address) ? $request->address : '';
        $arrayMeta['thumb_horizontal'] = isset($request->thumb_horizontal) ? $request->thumb_horizontal : '';
        $arrayMeta['thumb_vertical'] = isset($request->thumb_vertical) ? $request->thumb_vertical : '';

        $this->postRepository->insertMeta($post, $arrayMeta);
        $this->postRepository->handleSeoMeta($post, $request);
        $this->postService->renderSiteMap();
        $post->terms()->sync($request->group);
        // $this->postRepository->syncTerm($post, $request->group);
    }
}
