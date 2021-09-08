<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function run()
    {
        DB::table('roles')->insert([
            'role_id' => 1,
            'role_name' => 'Admin',
            'role_slug' => 'admin',
        ]);

        DB::table('roles')->insert([
            'role_id' => 2,
            'role_name' => 'User',
            'role_slug' => 'user',
        ]);

        DB::table('roles')->insert([
            'role_id' => 3,
            'role_name' => 'Manager',
            'role_slug' => 'manager',
        ]);
    }
}
