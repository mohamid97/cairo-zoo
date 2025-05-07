<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin\Shimpment;
use App\Models\Admin\SocialMedia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {



//        $this->call(AchivementSeeder::class);
       // $this->call(SliderSeeder::class);
//        $this->call(CategorySeeder::class);
//        $this->call(CmsSeeder::class);
//        $this->call(ClientsSeeder::class);
//        $this->call(ServicesSeeder::class);
//        $this->call(SescriptionSeeder::class);
//        $this->call(ProjectsSeeder::class);

//        $this->call(MissionVissionSeeder::class);
//        $this->call(ShimpmentSeeder::class);
//        $this->call(GovsSeeder::class);
//        $this->call(CitySeeder::class);


        $this->call([
            UserSeeder::class,
            SocialMediaSeeder::class,
            SettingSeeder::class,
            LangSeeder::class,
            ContactusSeeder::class,
            AboutSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);




    }
}
