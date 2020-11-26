<?php

use App\Project;
use App\ProjectType;
use App\Role;
use App\Skill;
use App\User;
use Illuminate\Database\Seeder;



class DefaultSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'role_id' => 1
        ]);

        foreach (User::getRoles() as $role => $id){
            Role::create([
                'title' => $role
            ]);
        }

        foreach (Project::getType() as $type => $id){
            ProjectType::create([
               'title' => $type
            ]);
        }

        foreach (Skill::getDefaultSkills() as $skill => $id){
            Skill::create([
                'title' => $skill
            ]);
        }

    }
}