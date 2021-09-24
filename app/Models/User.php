<?php

namespace App\Models;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
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

    public function getAllUsers (): Collection
    {
        return DB::table('users')->get();
    }

    public function getManagerUsers (): Collection
    {
        return DB::table('users')
            ->where('role', '!=', 'admin')
            ->get();
    }

    public function getUser($userID): Collection
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
                'role' => $roleID,
            ]);
    }

    public function searchUserByName($userName): Collection
    {
        return DB::table('users')
            ->where('name', '=', $userName)
            ->get();
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
            'role' => 'admin'
        ]);

        DB::table('users')->insert([
            'role' => 'manager'
        ]);

        DB::table('users')->insert([
            'role' => 'user'
        ]);
    }
};
