<?php

// use Illuminate\Foundation\Inspiring;
// use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
    // $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote'); 

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\ScopedPath;
use App\Models\User;

Artisan::command('seed:demo', function () {
    Admin::create([
        'name' => 'Admin',
        'email' => 'admin@pfg.com',
        'password' => Hash::make('demo123'),
        'is_super_admin' => true
    ]);

    $pfg = ScopedPath::create([
        'path_identifier' => 'pfg',
        'name' => 'PFG Financial Group',
        'is_active' => true
    ]);

    $example = ScopedPath::create([
        'path_identifier' => 'example',
        'name' => 'example Corporation',
        'is_active' => true
    ]);

    $mypath = ScopedPath::create([
        'path_identifier' => 'mypath',
        'name' => 'myCorporation',
        'is_active' => true
    ]);

    User::create([
        'name' => 'John Smith',
        'email' => 'john@pfg.com',
        'password' => Hash::make('demo123'),
        'scoped_path_id' => $pfg->id
    ]);

    User::create([
        'name' => 'Mike Wilson',
        'email' => 'mike@example.com',
        'password' => Hash::make('demo123'),
        'scoped_path_id' => $example->id
    ]);

    User::create([
        'name' => 'John Doe',
        'email' => 'john@anything.com',
        'password' => Hash::make('demo123'),
        'scoped_path_id' => $mypath->id
    ]);

    $this->info('Demo data seeded successfully!');
});
