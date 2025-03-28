<?php

namespace Database\Seeders\Update;

use App\Models\Admin\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages      = Language::get()->pluck("code")->toArray();
        if(count($languages) > 0) {
            $files          = File::files(base_path('lang'));
            $json_files      = array_filter($files, function ($file) {
                return $file->getExtension() === 'json' && $file->getBasename() != "predefined_keys.json";
            });
            $file_names      = array_map(function ($file) {
                return pathinfo($file->getFilename(), PATHINFO_FILENAME);
            }, $json_files);
            $diff_items = array_diff($file_names, $languages);
            foreach($diff_items as $item){
                $file_link = base_path('lang/' . $item . ".json");
                if(file_exists($file_link)) {
                    File::delete($file_link);
                }
            }
        }

        $languages = array(
            array('name' => 'Hindi','code' => 'hi','status' => '0','dir' => 'ltr','last_edit_by' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'French','code' => 'fr','status' => '0','dir' => 'ltr','last_edit_by' => '1','created_at' => now(),'updated_at' => now())
          );

        Language::insert($languages);
    }
}
