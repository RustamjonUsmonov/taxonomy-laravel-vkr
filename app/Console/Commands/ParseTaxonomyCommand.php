<?php

namespace App\Console\Commands;

use App\Models\TaxonomyElement;
use App\Models\TaxonomyNotification;
use App\Models\TaxonomyObject;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ParseTaxonomyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taxonomy:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notificationQuery = TaxonomyNotification::query();
        if ($notificationQuery->count() > 0) {
            $bar = $this->output->createProgressBar($notificationQuery->count());
            $notificationQuery->with('taxonomy')->chunk(50, function ($notifications) use ($bar) {

                foreach ($notifications as $notification) {
                    try {
                        $object = TaxonomyObject::create(['name' => Str::random(12)]);
                        $json = $notification->taxonomy->dictionaries;
                        $data = json_decode($json, JSON_UNESCAPED_UNICODE);
                        $counter = TaxonomyElement::orderBy('id', 'desc')->first()->id + 1;
                        $store = [];
                        $elements = [];
                        $pivotData = [];
                        foreach ($data as $key => $value) {
                            for ($i = 0; $i < count($value); $i++) {
                                if ($i == 0 && !in_array($key, array_keys($elements))) {
                                    $store[] = ['id' => $counter, 'element' => $key, 'taxonomy_object_id' => $object->id, 'created_at' => now()];
                                    $elements[$key] = $counter;
                                    $counter++;
                                }
                                if (!in_array($element = $value[$i][0], array_keys($elements))) {
                                    $store[] = ['id' => $counter, 'element' => $element, 'taxonomy_object_id' => $object->id, 'created_at' => now()];
                                    $elements[$element] = $counter;
                                    $counter++;
                                }

                                $pivotData[] = [
                                    'similarity' => $value[$i][1],
                                    'word_1_id' => $elements[$key],
                                    'word_2_id' => $elements[$element]
                                ];
                            }
                            DB::table('taxonomies_element')->insert($store);
                            DB::table('taxonomies_relations')->insert($pivotData);
                            $store = [];
                            $pivotData = [];
                        }
                        $notification->delete();
                    } catch (Exception $exception) {
                        echo $exception->getMessage();
                    }
                    $bar->advance();
                }
            });

            $bar->finish();
        }

        return CommandAlias::SUCCESS;
    }
}
