{{--Form Inputs--}}
@if($locale == 'en')
    <x-text :name="'name'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>
    <div style="margin-left: 15%; margin-right: 15%;" class="table-responsive">

        <div class="col-lg-9">
            <div class="pl-3" id="accordion">
                @foreach(getPermissions() as $key => $per)
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-link" data-toggle="collapse"
                                        data-target="#collapseOne_{{$key}}"
                                        aria-expanded="false" aria-controls="collapseOne">
                                    {{$per}}
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne_{{$key}}" class="collapse " aria-labelledby="headingOne"
                             data-parent="#accordion">
                            <div class="card-body">

                                @foreach(config('permission.permissions') as $key => $permission)
                                    @if( \Illuminate\Support\Str::contains($permission, \Illuminate\Support\Str::lower ($per )) )
                                        <div class="d-flex">
                                            <label class="checkbox checkbox-lg checkbox-single">
                                                <input class="text-center" type="checkbox"
                                                       name="permissions[]"
                                                       value="{{ $permission }}"
                                                    {{ isset($entity) && $entity->hasPermissionTo($permission) ? 'checked' : ''}}
                                                />
                                                <span></span>
                                            </label>
                                            <div class="d-flex m-3 text-center">
                                                {{ $permission }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                        @endforeach
                    </div>
            </div>
        </div>
@endif
{{--End Form Inputs--}}
