<?php

namespace App\Repositories;

use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactRepository
{
    public function getContactsDataTable(Request $request): LengthAwarePaginator
    {

        $contacts = Contact::query();

        if ($request->has('query')){

            if (isset($request->get('query')['from_date']) != null)
                $contacts->where('created_at' ,'>=', $request->get('query')['from_date']);

            if (isset($request->get('query')['to_date']) != null)
                $contacts->where('created_at' ,'<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());


            if (isset($request->get('query')['search']) != null){
                $tokens = convertToSeparatedTokens($request->get('query')['search']);
                $contacts->whereRaw("MATCH(name, email,subject,phone_number) AGAINST(? IN BOOLEAN MODE)", $tokens);
            }
        }

        if ($request->has('sort')) {
            $field = $request->get('sort')['field'];
            if (!in_array($field, app(Contact::class)->getFillable())) $field = 'id';
            $contacts = $contacts->orderBy($field, $request->get('sort')['sort'] ?? 'asc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        } else
            $contacts = $contacts->orderBy('id', 'desc')
                ->paginate($request->get('pagination')['perpage'],['*'], 'page',$request->get('pagination')['page']);

        return $contacts;
    }
}
