<?php

use App\Models\Phone;
use App\Models\PhoneShop;
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
                $skuId = $phoneData['sku_id'];
                unset($phoneData['disponibil_in_magazin']);
                unset($phoneData['sku_id']);

                $existingPhone = Phone::query();
                foreach ($phoneData as $tableKey => $tableValue) {
                    $existingPhone->where($tableKey, $tableValue);
                }
                $existingPhone = $existingPhone->first();
                if (!$existingPhone) {
                    $existingPhone = Phone::query()
                        ->create($phoneData);
                }


                PhoneShop::query()->updateOrCreate([
                    'phone_id' => $existingPhone->id,
                    'shop_id' => $shop->id,
                ]);

            }

        }

        echo "Loaded phones \n";
    }
}
