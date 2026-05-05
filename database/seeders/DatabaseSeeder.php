<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;
use App\Models\CreatorFile;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    DB::table('users')->truncate();
    DB::table('roles')->truncate();
    DB::table('creator_files')->truncate();

    $admin   = Role::create(['name' => 'admin',   'description' => 'Full access']);
    $creator = Role::create(['name' => 'creator', 'description' => 'Upload and manage own files']);
    $viewer  = Role::create(['name' => 'viewer',  'description' => 'Browse and download free files']);
    $premium = Role::create(['name' => 'premium', 'description' => 'Download all including premium']);

    User::create(['name' => 'Admin',   'email' => 'admin@test.com',   'password' => Hash::make('admin123'),   'role_id' => $admin->id]);
    User::create(['name' => 'Creator', 'email' => 'creator@test.com', 'password' => Hash::make('creator123'), 'role_id' => $creator->id]);
    User::create(['name' => 'Viewer',  'email' => 'viewer@test.com',  'password' => Hash::make('viewer123'),  'role_id' => $viewer->id]);
    User::create(['name' => 'Premium', 'email' => 'premium@test.com', 'password' => Hash::make('premium123'), 'role_id' => $premium->id]);

    CreatorFile::create(['name' => 'Cinematic LUT', 'original_filename' => 'cinematic.cube', 'file_path' => 'creator_files/cinematic.cube', 'file_type' => 'lut', 'software' => 'DaVinci Resolve', 'description' => 'Hollywood color grade']);
    CreatorFile::create(['name' => 'Golden Hour Preset', 'original_filename' => 'golden.xmp', 'file_path' => 'creator_files/golden.xmp', 'file_type' => 'preset', 'software' => 'Lightroom', 'description' => 'Warm golden preset']);
}
}