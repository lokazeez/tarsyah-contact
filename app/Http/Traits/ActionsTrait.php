<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait ActionsTrait {


    function getcheckItem($id): string
    {
        return '<label class="checkbox checkbox-single"><input type="checkbox" value="'.$id.'">&nbsp;<span></span></label>';
    }

    function getImageUrl($imageUrl, $id): string
    {
        return '<div class="d-flex align-items-center">
                        <div class="symbol symbol-50 flex-shrink-0 mr-2">
                            <a class="fancybox" href="'.$imageUrl.'">
                                <div class="symbol-label" style="background-image: url('.$imageUrl.')"></div>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 ml-3 font-size-lg">'.$id.'</a>
                        </div>
                </div>';
    }
    function getItemFirstMediaUrl($imageUrl, $id): string
    {
        return '<div class="d-flex align-items-center">
                        <div class="symbol symbol-50 flex-shrink-0 mr-2">
                            <a class="fancybox" href="'.$imageUrl.'">
                                <div class="symbol-label" style="background-image: url('.$imageUrl.')"></div>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 ml-3 font-size-lg">'.$id.'</a>
                        </div>
                </div>';
    }
    function getImageUrlSeekers($imageUrl, $id): string
    {
        return '
                    <div class="d-flex align-items-center">
                        <div>
                        <form method="POST">
                        <input type="checkbox" name="action[]" value="'. $id .'" class="text-dark-75 bulk-action font-weight-bolder text-hover-primary mb-1 ml-3 font-size-lg">
                        </form>
                     </div>
                        <div class="symbol symbol-50 flex-shrink-0 ml-2">
                            <a class="fancybox" href="' . $imageUrl . '">
                                <div class="symbol-label" style="background-image: url(' . $imageUrl . ')"></div>
                            </a>
                        </div>

                </div>';
    }

    function getItemActions($item, $resource): string
    {
        $actions = '<div class="dropdown dropdown-inline">
                            <a href="'.route("admin.".plural($resource).".show", [$resource."" => $item]).'" class="btn btn-sm btn-clean btn-icon" title="Show">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <span class="svg-icon"><!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                </span>
                            </a>
                        </div>';
        if (Auth::user()->can('delete '.plural($resource)))
            $actions .= '<a href="javascript:void(0);" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-2 deleteRow" data-toggle="tooltip" title="'. __("admin.delete") .'">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="Stockholm-icons-/-General-/-Trash" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" id="round" fill="#000000" fill-rule="nonzero"></path>
                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" id="Shape" fill="#000000" opacity="0.3"></path>
                                    </g>
                                </svg>
                                </span>
                                    <form method="post" action="'.route("admin.".plural($resource).".destroy", [$resource."" => $item]).'">'
                                       . method_field('Delete').
                                        '<br>'.
                                        csrf_field().
                                    '</form>
                                </a>';
        return $actions;
    }
}
