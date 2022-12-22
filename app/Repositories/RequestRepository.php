<?php

namespace App\Repositories;

use App\Models\VendorRequest;
use Illuminate\Http\Request;

class RequestRepository
{

    public function storeVendorDetails(Request $request): VendorRequest
    {

        if($request->has('user'))
        {
            $user = VendorRequest::query()->whereUserId(auth('user')->id())->first();
            if($user){
                $user->delete();
                $userRequest = new VendorRequest();
                $userRequest->user_id = auth('user')->id();
            }else{
                $userRequest = new VendorRequest();
                $userRequest->user_id = auth('user')->id();
            }
            $user->note = $request->note;
            $user->company_name = $request->company_name;
        } else {
            $userRequest = new VendorRequest($request->all());
        }
        $userRequest->save();

        return $userRequest;
    }

    public function getVendorRequest()
    {
       $request =  VendorRequest::with('user');
        return  $request->orderByDesc('created_at');
    }

}
