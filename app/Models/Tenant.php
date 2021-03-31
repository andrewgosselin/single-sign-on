<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utilities\Guid;
use App\Models\User;
use App\Models\Role;

class Tenant extends Model
{
    use HasFactory;

    protected $table = "tenants";
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

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function applications() {
        return $this->belongsToMany(Application::class);
    }

    public function roles() {
        return $this->hasMany(Role::class);
    }
    
    public function createUser($values) {
        $user = User::create($values);
        $user->tenants()->attach($this->guid);
        $user->save();
        return $user;
    }

    public function createRole($application_guid, $values) {
        $values["application_guid"] = $application_guid;
        $values["tenant_guid"] = $this->guid;
        $role = Role::create($values);
        return $role;
    }


}