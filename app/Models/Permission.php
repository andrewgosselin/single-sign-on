<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;
use App\Models\Utilities\Guid;

class Permission extends Model
{
    use HasFactory;

    protected $table = "permissions";
    protected $primaryKey = "guid";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        "guid",
        "application_guid",
        "name"
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $guid = Guid::generate();
            $model->guid = $guid;
        });
    }

    public function getSlugAttribute() {
        return $this->name;
    }

    public function application() {
        return $this->belongsTo(Application::class);
    }
}
