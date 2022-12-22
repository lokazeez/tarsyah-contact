<?php

namespace App\Models;

use App\Http\Traits\FcmNotifiable;
use App\Http\Traits\Notifiable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use FcmNotifiable;

    protected $guarded = ['id','created_at','updated_at'];
    public $translatedAttributes = ['title', 'message'];
    public $visibleAttributes = [
        'user' => 'relation',
    ];
    public $mediaAttributes = [
      'image' => 'image'
    ];

    protected $hidden = ['translations'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
