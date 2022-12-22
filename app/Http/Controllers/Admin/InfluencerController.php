<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\InfluencerRequest;
use App\Http\Traits\ActionsTrait;
use App\Models\Influencer;
use App\Providers\RouteServiceProvider;
use App\Repositories\AdminRepository;
use App\Repositories\InfluencerRepository;
use App\Repositories\RequestRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class InfluencerController extends Controller
{
    private $influencerRepository;
    public $resource = 'influencer';
    use ActionsTrait;

    public function __construct(InfluencerRepository $influencerRepository)
    {
        appendGeneralPermissions($this);
        $this->influencerRepository = $influencerRepository;
        view()->share('item', $this->resource);
        view()->share('class', Influencer::class);
    }

    /**
     * Display a listing of the resource.
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.crud.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.crud.edit-new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InfluencerRequest $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->influencerRepository->add($request);

        $request->session()->flash('success', 'influencer created successfully');

        if ($request->has('add-new'))
            return redirect()->route('admin.influencers.create');

        return redirect()->route('admin.influencers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Influencer $influencer
     * @return Factory|\Illuminate\Contracts\View\View
     */
    public function show(Influencer $influencer)
    {
        return view('admin.crud.show', compact('influencer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Influencer $influencer
     * @return Application|Factory|View
     */
    public function edit(Influencer $influencer)
    {
        return view('admin.crud.edit-new', compact('influencer',));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InfluencerRequest $request
     * @param Influencer $influencer
     * @return RedirectResponse
     */
    public function update(InfluencerRequest $request, Influencer $influencer): RedirectResponse
    {
        $this->influencerRepository->update($request, $influencer);

        $request->session()->flash('success', 'influencer updated successfully');

        if ($request->has('add-new'))
            return redirect()->back();

        return redirect()->route('admin.influencers.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Influencer $influencer
     * @return RedirectResponse
     */
    public function destroy(Request $request, Influencer $influencer): RedirectResponse
    {
        $this->influencerRepository->delete($influencer);
        $request->session()->flash('success', 'influencer deleted successfully');
        return redirect()->route('admin.influencers.index');
    }

    public function influencerAutoComplete(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $models = $this->influencerRepository->influencersAutoComplete($search);
        return response()->json([
            'results' => $models
        ]);
    }

    public function getInfluencers(Request $request, InfluencerRepository $influencerRepository): JsonResponse
    {
        $influencers = $influencerRepository->getInfluencersDataTable($request);

        $data = [];

        foreach ($influencers as $influencer){
            $imageUrl = $influencer->avatar ? storageImage($influencer->avatar) : asset('assets/media/svg/icons/General/Influencer.svg');
            array_push($data, [
                'id' => $influencer->id,
                'image' => $this->getImageUrl($imageUrl, $influencer->id),
                'name' => $influencer->name,
                'email' => $influencer->email,
                'created_at' => Date::parse($influencer->created_at)->format('Y-m-d'),
                'status' => $influencer->status,
                'actions' => $this->getItemActions($influencer, $this->resource)
            ]);
        }

        return response()->json(
            [
                "meta"=> [
                    "page"=> $influencers->currentPage(),
                    "pages"=> $influencers->lastPage(),
                    "perpage"=> $influencers->perPage(),
                    "total"=> $influencers->total() ,
                    "sort"=> $request->get('sort')['sort'] ?? 0,
                    "field"=> $request->get('sort')['field'] ?? ''
                ],
                "data"=> $data,
            ]
        );
    }



    public function setStatus(Request $request, $id): string
    {
        $className = modelName($request->get('type') ?? 'influencer');
        $item = $className::find($id);
        $item->status = $request->get('status');
        $item->save();

        return "Edit Status Successfully";
    }

}
