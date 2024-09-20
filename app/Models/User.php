<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'app_user';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    /**
     * Overide laravel password field name
     */
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public static function update_token($id, $token)
    {
        return DB::table('app_user')
            ->where('user_id', $id)
            ->update(['device_token' => $token]);
    }

    public static function get_token($id)
    {
        return DB::table('app_user')
            ->select("device_token")
            ->where('user_id', $id)
            ->pluck("device_token")
            ->all();
    }

    public static function get_mobile_no($id)
    {
        return DB::table('app_user')
            ->select("no_telp")
            ->where('user_id', $id)
            ->first();
    }

    public static function get_pic_name($id)
    {
        return DB::table('app_user')
            ->select("user_full_name")
            ->where('user_id', $id)
            ->first();
    }

    public static function get_all_token()
    {
        return DB::table('app_user')
            ->select("device_token")
            ->pluck("device_token")
            ->all();
    }
}
