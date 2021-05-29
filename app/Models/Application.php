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
        "name",
        "auth_client_id"
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $guid = Guid::generate();
            $model->guid = $guid;
            $auth_client = \App\Models\Utilities\OAuthClient::create(0, "Test", "http://127.0.0.1:8080/callback");
            $model->auth_client_id = $auth_client->id;
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

    public function getClientAttribute() {
        $clientRepo = new \Laravel\Passport\ClientRepository();
        $client = $clientRepo->find($this->auth_client_id);
        return $client;
    }
}
