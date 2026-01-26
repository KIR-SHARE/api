<?php

namespace Database\Seeders\local;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ItemsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert(
            [
                [
                    'name' => '商品小',
                    'price' => 1000,
                    'content' => '小さい商品です',
                    'created_at' => Carbon::now(),
                    'created_by' => 1,
                    'updated_at' => Carbon::now(),
                    'updated_by' => 1,
                ],
                [
                    'name' => '商品中',
                    'price' => 4000,
                    'content' => '通常の大きさの商品です',
                    'created_at' => Carbon::now(),
                    'created_by' => 1,
                    'updated_at' => Carbon::now(),
                    'updated_by' => 1,
                ],
                [
                    'name' => '商品大',
                    'price' => 9000,
                    'content' => '大きめの商品です',
                    'created_at' => Carbon::now(),
                    'created_by' => 1,
                    'updated_at' => Carbon::now(),
                    'updated_by' => 1,
                ],
            ]
        );

        $sampleImagePath = database_path('seeders/local/fixtures/item_images/sample.png');
        $extension = File::extension($sampleImagePath);

        DB::table('items')->get()->each(function ($item) use ($sampleImagePath, $extension) {
            $path = sprintf(
                'items/%d/images/%s',
                $item->id,
                uniqid() . '.' . $extension
            );

            Storage::disk('public')->put($path, File::get($sampleImagePath));

            DB::table('items')
                ->where('id', $item->id)
                ->update(['image' => $path]);
        });
    }
}
