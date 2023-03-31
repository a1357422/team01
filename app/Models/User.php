<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    const ROLE_SUPERADMIN = 'superadmin'; //系統後台管理員
    const ROLE_ADMIN = 'admin'; //宿舍行政
    const ROLE_HOUSEMASTER = 'housemaster'; //宿舍輔導員
    const ROLE_CHIEF = 'chief'; //總樓長
    const ROLE_FLOORHEAD = 'floorhead'; //樓長
    const ROLE_USER = 'user'; //住宿生

    protected $fillable = [
        'sid',
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeName($query)
    {
        $query->join('students','users.sid','=','students.id')->select('*');
    }

    public function scopeAllRoles($query)
    {
        $query->select('role')->groupBy('role');
    }

    public function scopeRole($query, $role)
    {
        $query->where('role', '=', $role);
    }

    public function student(){
        return $this->belongsTo("App\Models\Student","sid","id");
    }

}
