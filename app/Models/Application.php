<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utilities\Guid;
use App\Models\Permission;
use App\Models\Role;

class Application extends Model
{
    use HasFactory;

    protected $table = "applications";
    protected $primaryKey = "guid";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        "guid",
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

    public function tenants() {
        return $this->belongsToMany(Tenant::class);
    }

    public function permissions() {
        return $this->hasMany(Permission::class);
    }

    public function createPermission($values) {
        $values["application_guid"] = $this->guid;
        $permission = Permission::create($values);
        return $permission;
    }

    public function roles() {
        return $this->hasMany(Role::class);
    }
}
