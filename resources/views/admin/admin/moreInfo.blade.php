
<x-checkbox :name="'moreInformation'" :choices="[ newStd(['name' => 'checked', 'value' => '1']) ]"></x-checkbox>
    <div id="moreInfo">
        <x-text :name="'phone_number'" :locale="''" :oldValue="$entity ?? null"></x-text>

        <x-text :name="'whatsapp'" :locale="''" :oldValue="$entity ?? null"></x-text>

        <x-text :name="'website_url'" :locale="''" :oldValue="$entity ?? null"></x-text>

        <x-text :name="'facebook'" :locale="''" :oldValue="$entity ?? null"></x-text>

        <x-text :name="'instagram'" :locale="''" :oldValue="$entity ?? null" ></x-text>

        <x-text_area :name="'about'" :locale="$locale" :oldValue="$entity ?? null" ></x-text_area>

        <x-image :name="'avatar'" :locale="''" :oldValue="$entity ?? null"></x-image>

        <x-image :name="'cover_image'" :locale="''" :oldValue="$entity ?? null"></x-image>
    </div>
