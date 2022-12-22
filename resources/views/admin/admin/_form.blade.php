{{--Form Inputs--}}
@if($locale == 'en')

    <x-text :name="'name'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>
    <x-text :name="'username'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-text>
    <x-email :name="'email'" :locale="''" :oldValue="$entity ?? null" :required="true"></x-email>
    <x-password :name="'password'" :locale="''" :required="true"></x-password>

    @can('edit roles')
        <x-select :name="'role'" :locale="''" displayName="name" :multiple="false"
                  :options="\Spatie\Permission\Models\Role::get()"
                  :oldValue="isset($entity) ? $entity->roles()->first()->id : null"></x-select>
    @endcan
    <x-radio :name="'status'" :choices="getStatusVariables()" :oldValue="$entity ?? null"></x-radio>

    @include('admin.admin.moreInfo')

@endif



{{--End Form Inputs--}}
