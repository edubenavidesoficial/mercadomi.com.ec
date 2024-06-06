<?php

namespace Database\Seeders;


use App\Enums\Status;
use App\Models\Language;
use Illuminate\Database\Seeder;


class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $englishLanguageArray = [
            'name'   => 'English',
            'code'   => 'en',
            'status' => Status::ACTIVE
        ];

        $banglaLanguageArray = [
            'name'   => 'Bangla',
            'code'   => 'bn',
            'status' => Status::ACTIVE
        ];

        $arabicLanguageArray = [
            'name'   => 'Arabic',
            'code'   => 'ar',
            'status' => Status::ACTIVE
        ];

        $englishLanguage = Language::create($englishLanguageArray);
        if (file_exists(public_path('/images/seeder/language/english.png'))) {
            $englishLanguage->addMedia(public_path('/images/seeder/language/english.png'))->preservingOriginal()->toMediaCollection('language');
        }

        $banglaLanguage = Language::create($banglaLanguageArray);
        if (file_exists(public_path('/images/seeder/language/bangla.png'))) {
            $banglaLanguage->addMedia(public_path('/images/seeder/language/bangla.png'))->preservingOriginal()->toMediaCollection('language');
        }

        $banglaLanguage = Language::create($arabicLanguageArray);
        if (file_exists(public_path('/images/seeder/language/arabic.png'))) {
            $banglaLanguage->addMedia(public_path('/images/seeder/language/arabic.png'))->preservingOriginal()->toMediaCollection('language');
        }
    }
}
