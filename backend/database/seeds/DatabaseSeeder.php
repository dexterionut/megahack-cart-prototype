<?php

use App\Models\Phone;
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
        $this->loadPhones();
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
        echo "Loaded shops \n";
    }

    private function loadPhones()
    {
        $path = storage_path('csvs/StoresPhonesStock-sample.csv');

        $data = Excel::load($path)->get();


        if ($data->count()) {
            foreach ($data as $key => $value) {
                if ($value->disponibil_in_magazin == 'Magazin Vodafone - Giurgiu') {
                    $shopName = 'Magazin Vodafone - Bucuresti Giurgiului';
                } else {
                    $shopName = $value->disponibil_in_magazin;
                }
                $shop = Shop::query()
                    ->where('dealer_name', $shopName)
                    ->first();
                $phoneData = $value->toArray();
                unset($phoneData['disponibil_in_magazin']);
                if ($shop) {
                    $phoneData['shop_id'] = $shop->id;
                }
                Phone::query()
                    ->create($phoneData);
            }

        }

        echo "Loaded phones \n";
    }
}
