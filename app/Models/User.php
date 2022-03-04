<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Utilities\Guid;
use App\Models\Tenant;
use App\Models\Role;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'current_tenant'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public static function boot()
    {
        parent::boot();
        // self::creating(function ($model) {
        //     $model->guid = Guid::generate();
        // });
        self::retrieved(function($model) {
            $model->with('tenants');
        });
    }

    public function getAuthorizedAttribute() {
        return false;
    }
    
    public function getNameAttribute() {
        return ucfirst($this->first_name) . " " . ucfirst($this->last_name);
    }

    public function getTenantAttribute()
    {   
        if(($this->current_tenant == "" || $this->current_tenant == null) && $this->tenants->count() > 0) {
            $tenant = $this->tenants->first();
            $this->current_tenant = $tenant->guid;
            $this->save();
            return $tenant;
        }
        
        $tenant = $this->tenants->where('guid', '=', $this->current_tenant);
        if($tenant->count() > 0) {
            return $tenant->first();
        } else {
            if(config('application.general.multiTenant')) {
                abort(404, "This SSO is in multitenant mode and you are not assigned to a tenant. Contact an adminstrator.");
            } else {
                return \App\Models\Tenant::getBaseTenant();
            }
        }
    } 

    public function tenants() {
        return $this->belongsToMany(Tenant::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }
    
}
