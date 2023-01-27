<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Traits\ActionsTrait;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class ContactController extends Controller
{
    use ActionsTrait;
    private $ContactRepository;
    public $resource = 'contact';

    public function __construct(ContactRepository $ContactRepository)
    {
        appendGeneralPermissions($this);
        $this->ContactRepository = $ContactRepository;
        view()->share('item', $this->resource);
        view()->share('class', Contact::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
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
     * @param ContactRequest $request
     * @return RedirectResponse
     */
    public function store(ContactRequest $request): RedirectResponse
    {

        $this->ContactRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new'))
            return redirect()->route('admin.categories.create');

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $Contact
     * @return \Illuminate\Contracts\View\View|View
     */
    public function show(Contact $contact)
    {
        return view('admin.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $Contact
     * @return Application|Factory|View
     */
    public function edit(Contact $Contact)
    {
        return view('admin.crud.edit-new', compact('Contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactRequest $request
     * @param Contact $Contact
     * @return RedirectResponse
     */
    public function update(ContactRequest $request, Contact $Contact): RedirectResponse
    {
        $this->ContactRepository->update($request, $Contact);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new'))
            return redirect()->back();

        return redirect()->route('admin.categories.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Contact $Contact
     * @return RedirectResponse
     */
    public function destroy(Request $request, Contact $contact): RedirectResponse
    {
        $contact->delete();
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));
        return redirect()->back();
    }

    public function getContacts(Request $request, ContactRepository $contactRepository): JsonResponse
    {
        $contacts = $contactRepository->getContactsDataTable($request);

        $data = [];

        foreach ($contacts as $contact){
            $imageUrl = $contact->getFirstMediaUrl('images') ? $contact->getFirstMediaUrl('images') : asset('assets/media/svg/icons/General/User.svg');
            $data[] = [
                'id' => $contact->id,
                'image' => $this->getItemFirstMediaUrl($imageUrl,$contact->id),
                'name' => $contact->name,
                'email' => $contact->email,
                'phone_number' => $contact->phone_number,
                'id_number' => $contact->id_number,
                'items' => $contact->items,
                'message' => $contact->message,
                'created_at' => Date::parse($contact->created_at)->format('Y-m-d'),
                'actions' => $this->getItemActions($contact, $this->resource)
            ];
        }

        return response()->json(
            [
                "meta"=> [
                    "page"=> $contacts->currentPage(),
                    "pages"=> $contacts->lastPage(),
                    "perpage"=> $contacts->perPage(),
                    "total"=> $contacts->total() ,
                    "sort"=> $request->get('sort')['sort'] ?? 0,
                    "field"=> $request->get('sort')['field'] ?? ''
                ],
                "data"=> $data,
            ]
        );
    }
}
