<?php

use App\Models\Shop;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->loadShops();
    }

    private function loadShops()
    {
        $path = storage_path('csvs/StoresList-sample.csv');

        $data = Excel::load($path)->get();


        if ($data->count()) {

            foreach ($data as $key => $value) {
                Shop::query()
                    ->create($value->toArray());
            }

        }
    }
}
