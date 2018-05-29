<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Route;
use App\Crag;
use App\Sector;

class FixLowerGrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oblyk:fix_lower_grade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just to rewrite lower boundary of route ranges in the DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(DB::table("gap_grades")->get() as $gg) {
            $min_grade_val = $gg->min_grade_val;
            if ($min_grade_val == 0) {
                switch($gg->spreadable_type) {
                    case "App\Crag": 
                        $min_grade_val = Sector::find($gg->spreadable_id)->routeSections->where('grade_val', '>', 0)->min('grade_val');
                        break;
                    case "App\Sector": 
                        $min_grade_val = Crag::find($gg->spreadable_id)->routeSections->where('grade_val', '>', 0)->min('grade_val');
                        break;
                }

                if ($min_grade_val > 0) {
                    $min_grade_text = Route::valToGrad($min_grade_val);

                    $gg->update([
                        'min_grade_val' => $min_grade_val,
                        'min_grade_text' => $min_grade_text
                    ]);
                    //$this->info($min_grade_text);
                }

            }
        }
    }
}