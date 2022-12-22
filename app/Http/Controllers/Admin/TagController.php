<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $tagRepository;
    public $resource = 'tag';

    public function __construct(TagRepository $tagRepository)
    {
        appendGeneralPermissions($this);
        $this->tagRepository = $tagRepository;
        view()->share('item', $this->resource);
        view()->share('class', Tag::class);
    }

    public function tagAutoComplete(Request $request): JsonResponse
    {

        $tags= Tag::query();
        if ($request->has('search')){
            $search = $request->get('search');
            $tokens = convertToSeparatedTokens($search);
            $tags->whereHas('tag_translations',function ($q) use($tokens){
                $q->whereRaw("MATCH(name,description) AGAINST(? IN BOOLEAN MODE)", $tokens);
            });
        }

        $models =  $tags
            ->take(5)
            ->get()->map(function ($result){
                return array(
                    'id' => $result->id,
                    'text' => $result->name ,
                );
            });
        return response()->json([
            'results' => $models
        ]);
    }

    public function index(Request $request)
    {
        $tags = $this->tagRepository
            ->getTags($request)
            ->paginate(10);
        return view('admin.crud.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.crud.edit-new');
    }


    public function store(TagRequest $request): RedirectResponse
    {
        $this->tagRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new'))
            return redirect()->route('admin.tags.create');

        return redirect()->route('admin.tags.index');
    }

    public function show(Tag $tag)
    {
        return view('admin.crud.show', compact('tag'));
    }


    public function edit(Tag $tag)
    {
        return view('admin.crud.edit-new', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag): RedirectResponse
    {
//        dd($request->all());
        $this->tagRepository->update($request, $tag);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new'))
            return redirect()->back();

        return redirect()->route('admin.tags.index');

    }


    public function destroy(Request $request, Tag $tag): RedirectResponse
    {
        $this->tagRepository->delete($tag);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));
        return redirect()->route('admin.tags.index');
    }
}
