<?php

namespace App\Models;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function meal(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Meal::class);
    }

    public function getAllUsers (): \Illuminate\Support\Collection
    {
        return DB::table('users')->get();
    }

    public function getManagerUsers (): \Illuminate\Support\Collection
    {
        return DB::table('users')
            ->where('role_id', '!=', '1')
            ->get();
    }
    public function getUser($userID): \Illuminate\Support\Collection
    {
      return  DB::table('users')
            ->where('id', '=', $userID)
            ->get();
    }

    public function editUser ($userID, $username, $email, $password): int
    {
        return DB::table('users')
            ->where('id', '=', $userID)
            ->update([
                'username' => $username,
                'email' => $email,
                'password' =>bcrypt($password),
                'id' => $userID,
            ]);
    }
    public function adminEditUser ($userID, $name, $username, $email, $password): int
    {
        return DB::table('users')
            ->where('id', '=', $userID)
            ->update([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' =>bcrypt($password),
                'id' => $userID,
            ]);
    }

    public function editUserAccess ($userID, $roleID): int
    {
        return DB::table('users')
            ->where('id', '=', $userID)
            ->update([
                'role_id' => $roleID,
            ]);
    }

    public function deleteUser($userID): int
    {
        return DB::table('users')
            ->where('id', '=', $userID)
            ->delete();
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1'
        ]);

        DB::table('users')->insert([
            'role_id' => '2'
        ]);

        DB::table('users')->insert([
            'role_id' => '3'
        ]);
    }
};
