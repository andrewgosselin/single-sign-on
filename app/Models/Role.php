<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;
use App\Models\Tenant;
use App\Models\Utilities\Guid;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";
    protected $primaryKey = "guid";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        "guid",
        "tenant_guid",
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

    public function application() {
        return $this->belongsTo(Application::class);
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
