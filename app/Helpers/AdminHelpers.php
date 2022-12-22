<?php

use App\Models\{Admin, Banner, Category, Attribute, City, Coupon, Delivery, Order, Product, Setting, Slider, Tag};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

function localImage($file, $default = '')
{
    if (!empty($file)) {
        return Str::of(Storage::disk('local')->url($file))->replace('storage', 'uploads');
    }

    return $default;
}
function sliders(){
    return Slider::query()->with(['sliderable','translations'])->get();
}
function storageImage($file, $default = '')
{
    if (Str::contains($file, 'picsum.photos'))
        return $file;
    if (!empty($file)) {
        return str_replace('\\', '/', Storage::disk('public')->url($file));
    }

    return $default;
}

function secToMin($seconds)
{
    return $seconds / 60;
}

function newStd($array = []): stdClass
{
    $std = new \stdClass();
    foreach ($array as $key => $value) {
        $std->$key = $value;
    }
    return $std;
}

function getCities(){
    return City::all();
}
function getRoles()
{
    return Role::all();
}

function getVendors()
{
    return Admin::where('status', 1)->role('vendor')->get();
}
function getCreators()
{
    return Admin::where('status', 1)->role(['data','admin'])->get();
}
function calculatePriceDiscount($price, $value ,$type){
    if($type == Product::DISCOUNT_TYPE_PERCENTAGE){
      return $price - getPercentageValue($price,$value) ;
    }else{
       return  getDecrementValue($value,$price) ;
    }
}
function getSymbolCurrencyType($type): string
{
    if (Product::CURRENCY_TYPE_LB == $type){
        return "LL";
    }else
        return "$";
}
function getNameTag($tags): string
{
    $name ='';
    if (count($tags) ==  1){
        return $tags[0]->name;
    }
    foreach ($tags as $tag){
        $name .= $tag->name .' ' ;
    }
    return $name;
}

function getStatusVariables(): array
{
    $active = newStd(['name' => __('admin.active'), 'value' => 1]);
    $inactive = newStd(['name' => __('admin.inactive'), 'value' => 0]);
    return [$active, $inactive];
}
function getPercentageValue($item,$percentage){
    return $item *($percentage/100);
}
function getIncrementValue($value ,$item){
    return $item + $value;
}
function getDecrementValue($value ,$item){
    return $item - $value;
}

// TODO OPTIMIZE BULK ACTIONS
function actionPrice($items,$request,$colName){
    $items->map(function ($item,$key) use ($request,$colName){
        return $item->update([
            $colName=> $request->get('discount_type') == Product::DISCOUNT_TYPE_FIXED ?
                ($request->get('operations') == Product::INCREMENT ?
                    $item->$colName + $request->get('value') :
                    $item->$colName - $request->get('value')
                ) :
                ($request->get('operations') == Product::INCREMENT ?
                    $item->$colName + getPercentageValue($item->$colName ,$request->get('value')) :
                    $item->$colName - getPercentageValue($item->$colName ,$request->get('value'))
                )
        ]);
    });
}

function actionDiscount($items,$request,$colType,$colValue){
    $items->map(function ($item,$key) use ($request,$colValue,$colType){
        return $item->update([
            $colType=>$request->get('discount_type'),
            $colValue=>$request->get('value')
        ]);
    });
}


function getApproval(): array
{
    $approval = newStd(['name' => __('admin.approval'), 'value' => 1]);
    $unapproval = newStd(['name' => __('admin.UnApproval'), 'value' => 0]);
    return [$approval, $unapproval];
}
function getDisplayCategory(){
    return Category::with(['translations','parentCategory'])->whereNull('parent_category')->where('display','=',1)->get();
}

function getCurrencyType(): array
{
    $usd = newStd(['name' => __('admin.usd'), 'value' => 1]);
    $ll = newStd(['name' => __('admin.lb'), 'value' => 0]);
    return [$ll, $usd];
}

function getDiscountTypes(): array
{
    $usd = newStd(['name' => __('admin.fixed'), 'value' => 1]);
    $ll = newStd(['name' => __('admin.percentage'), 'value' => 0]);
    return [$ll, $usd];
}

function getOperations(): array
{
    $plus = newStd(['name' => __('admin.plus'), 'value' => 1]);
    $minus = newStd(['name' => __('admin.minus'), 'value' => 0]);
    return [$plus, $minus];
}
function getDeliveryTimeValues():array
{
    $estimations[] = newStd(['name' => '3-5 Days', 'value' => '3-5', 'checked' => 1]);
    $estimations[] =newStd(['name' => '5-10 Days', 'value' => '5-10']);
    return $estimations;
}

function getTags(){
    return Tag::query()->where('display','=',1)->with('translations')->take(8)->sorted()->get();
}

function getTagsForm(){
    return Tag::query()->sorted()->get();
}

function getOrderStatusClass($status): string
{
    switch ($status) {
        case Order::STATUS_PENDING:
            return 'warning';
        case Order::STATUS_DELIVERED:
            return 'success';
        case Order::STATUS_ONGOING:
            return 'info';
        case Order::STATUS_CANCELLED:
            return 'danger';
        default:
            return '';
    }
}


function getStatusOrder($status)
{
    switch ($status) {
        case Order::STATUS_PENDING:
            return __('order.pending');
        case Order::STATUS_DELIVERED:
            return __('order.delivered');
        case Order::STATUS_ONGOING:
            return __('order.ongoing');
        case Order::STATUS_CANCELLED:
            return __('order.cancelled');
        default:
            return __('admin.empty');
    }
}

function getOptionVariant($variant): string
{
    $display = '';
    if($variant){
        foreach ($variant->values as $value){
            $display .= $value->optionValue->name . '-';
        }
    }else{
        $display = 'NON';
    }
    return $display;
}

function getShipmentPrice(){
    return \App\Models\Shipment::find(1)->price;
}

function renderAttributeInput(Attribute $attribute, $oldValue = null)
{
    $name = 'attributes[' . $attribute->id . ']';
    $title = $attribute->name;
    $decimal = true;

    switch ($attribute->type) {
        case 'text':
            return view('admin.components.text-attribute', compact('title', 'name', 'oldValue'));
        case 'color':
            return view('admin.components.color-attribute', compact('title', 'name', 'oldValue'));
        case 'checkbox':
            return view('admin.components.switch-form-attribute', compact('title', 'name', 'oldValue'));
        case 'number':
            return view('admin.components.number-attribute', compact('title', 'name', 'oldValue', 'decimal'));
        default:
            return '';

    }
}

function getStatusOrderVariables(): array
{
    $pending = newStd(['name' => __('order.pending'), 'value' => Order::STATUS_PENDING]);
    $delivered = newStd(['name' => __('order.delivered'), 'value' => Order::STATUS_DELIVERED]);
    $ongoing = newStd(['name' => __('order.ongoing'), 'value' => Order::STATUS_ONGOING]);
    $cancelled = newStd(['name' => __('order.cancelled'), 'value' => Order::STATUS_CANCELLED]);

    return [$pending, $delivered, $ongoing, $cancelled];
}

function getStatusDeliveryVariables(): array
{
    $pending = newStd(['name' => __('order.pending'), 'value' => Delivery::STATUS_PENDING]);
    $delivered = newStd(['name' => __('order.delivered'), 'value' => Delivery::STATUS_DELIVERED]);
    $ongoing = newStd(['name' => __('order.ongoing'), 'value' => Delivery::STATUS_ONGOING]);
    $cancelled = newStd(['name' => __('order.cancelled'), 'value' => Delivery::STATUS_CANCELLED]);

    return [$pending, $delivered, $ongoing, $cancelled];
}

function getBannerModelTypes(): array
{
    $vendor = newStd(['name' => __('admin.vendor'), 'value' => 'App\Models\Admin']);
    $category = newStd(['name' => __('admin.category'), 'value' => 'App\Models\Category']);
    $product = newStd(['name' => __('admin.product'), 'value' => 'App\Models\Product']);
    return [$vendor, $category, $product];
}

function getSizeType(): array
{
    $small = newStd(['name' => __('admin.small'), 'value' =>Banner::SMALL_IMAGE ]);
    $big = newStd(['name' => __('admin.big'), 'value' => Banner::BIG_IMAGE]);
    return [$big, $small];
}

function getTypeSlider(): array
{
    $category = newStd(['name' => __('admin.category'), 'value' => Slider::CATEGORY]);
    $tag = newStd(['name' => __('admin.tag'), 'value' => Slider::TAG]);
    return [$tag, $category];
}

function getTypesVariables(): array
{
    $text = newStd(['name' => __('admin.text'), 'value' => 'text']);
    $number = newStd(['name' => __('admin.number'), 'value' => 'number']);
    $checkbox = newStd(['name' => __('admin.checkbox'), 'value' => 'checkbox']);
    $color = newStd(['name' => __('admin.color'), 'value' => 'color']);
    $select = newStd(['name' => __('admin.select'), 'value' => 'select']);
    return [$text, $number, $checkbox, $color, $select];
}

function getCurrentLanguageSymbol()
{
    return Session::get('lang');
}

function getCategories($id = null)
{
    if ($id != null)
        return Category::all()->except($id);
    return Category::all();
}
function getChildCategory($id){
    return Category::query()->where('parent_category','=',$id)->get();
}

function getParentsCategories($id = null)
{
    if ($id != null)
        return Category::with(['translations','parentCategory'=>function($q){
            $q->active()->sorted();
        },'parentCategory.translations'])->whereNull('parent_category')->get()->except($id);
    return Category::with(['translations','parentCategory'=>function($q){
        $q->sorted();
    },'parentCategory.translations'])->whereNull('parent_category')->active()->sorted()->get();
}
//function getCategorySortedByCountSub(){
//    return Category::query()->with(['translations','parentCategory'=>function($q){
//        $q->with('translations')->active()->sorted();
//    }])->whereNull('parent_category')->withCount('parentCategory')->active()->sorted()->orderByDesc('parent_category_count')->get();
//}

function getSubCategories()
{
    $categories = Category::query()->whereNotNull('parent_category');
    return $categories->get();
}

function getAllTags(){
    return \App\Models\Tag::all();
}
function getDayDeliver($duration){
   return explode('-',$duration);
}
function getDurationDate($duration){
    $days = getDayDeliver($duration);
      return Carbon::now()->addDays($days[0])->format('M d') .' - '. Carbon::now()->addDays($days[1])->format('M d') ;
}
//function getBanners(): Builder
//{
//    return Banner::query()->latest();
//}
function lastTowBanners()
{
    return Banner::query()->with(['applicable','translations'])->sorted()->take(2)->get();
}
function getBannerApplicableName($appliesTo): string
{
    switch ($appliesTo) {
        case 'AppliesToVendors':
            return 'admin';
        case 'AppliesToCategory':
            return 'category';
        case 'AppliesToProducts':
            return 'product';
        default:
            return '';
    }
}

function setting($key, $type): string
{
    if ($type == 'rich_text_box')
        $type = 'richTextBox';
    $setting = Setting::where('key', $key);
    if ($setting)
        return $setting->with($type)->get()->first()->{$type}->value;
    else
        return '';
}

function getActiveProducts()
{
    return Product::query()->where('status', 1)->get();
}

function getPercentagePrice($value, $newValue)
{
    if ($value != $newValue)
        return round((($newValue - $value) / $value) * 100);

    return false;
}

function getCurrentLanguage()
{
    if (Session::get('lang') == 'en')
        return __('admin.english');
    elseif(Session::get('lang') == 'ar')
        return __('admin.arabic');
    else
        return __('admin.change_lang');
}

function getOppositeLanguage()
{
    if (Session::get('lang') == 'ar')
        return 'English';
    elseif(Session::get('lang') == 'en')
        return 'عربي';
    else
        return __('admin.change_lang');
}

