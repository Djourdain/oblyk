<?php

namespace App\Http\Controllers\Chart\Crosses;

use App\Cross;
use App\CrossMode;
use App\CrossStatus;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class routeChartsController extends Controller
{

    //GRAPHIQUE DES TYPES DE GRIMPE
    function grades(){

        $user = User::where('id', Auth::id())->with('settings')->first();
        $crosses = Cross::getCrossWithFilter($user);

        $gradeArray = [
            1  => 0,3  => 0,5  => 0,
            7  => 0,9  => 0,11 => 0,
            13 => 0,15 => 0,17 => 0,
            19 => 0,21 => 0,23 => 0,
            25 => 0,27 => 0,29 => 0,
            31 => 0,33 => 0,35 => 0,
            37 => 0,39 => 0,41 => 0,
            43 => 0,45 => 0,47 => 0,
            49 => 0,51 => 0,53 => 0,
        ];

        foreach ($crosses as $cross){
            foreach ($cross->crossSections as $crossSection) {
                if($crossSection->routeSection->grade_val % 2 == 0) $crossSection->routeSection->grade_val--;
                $gradeArray[$crossSection->routeSection->grade_val]++;
            }
        }

        $data = [
            'type'=>'bar',
            'data'=> [
                'labels' => [
                    "1a", "1b", "1c",
                    "2a", "2b", "2c",
                    "3a", "3b", "3c",
                    "4a", "4b", "4c",
                    "5a", "5b", "5c",
                    "6a", "6b", "6c",
                    "7a", "7b", "7c",
                    "8a", "8b", "8c",
                    "9a", "9b", "9c",
                ],
                'datasets' => [
                    [
                        'label' => '',
                        'data' => [
                            $gradeArray[1], $gradeArray[3], $gradeArray[5],
                            $gradeArray[7], $gradeArray[9], $gradeArray[11],
                            $gradeArray[13], $gradeArray[15], $gradeArray[17],
                            $gradeArray[19], $gradeArray[21], $gradeArray[23],
                            $gradeArray[25], $gradeArray[27], $gradeArray[29],
                            $gradeArray[31], $gradeArray[33], $gradeArray[35],
                            $gradeArray[37], $gradeArray[39], $gradeArray[41],
                            $gradeArray[43], $gradeArray[45], $gradeArray[47],
                            $gradeArray[49], $gradeArray[51], $gradeArray[53],
                        ],
                        'backgroundColor' => [
                            'rgb(255,85,220)', 'rgb(238,51,201)', 'rgb(221,17,180)',
                            'rgb(134,205,222)','rgb(103,191,213)', 'rgb(71,178,204)',
                            'rgb(255,221,84)', 'rgb(249,208,51)', 'rgb(243,195,17)',
                            'rgb(255,127,42)', 'rgb(238,110,25)', 'rgb(221,93,8)',
                            'rgb(170,212,0)', 'rgb(143,178,0)', 'rgb(115,144,0)',
                            'rgb(0,85,212)', 'rgb(0,64,161)', 'rgb(0,44,110)',
                            'rgb(171,55,200)', 'rgb(144,46,168)', 'rgb(117,37,136)',
                            'rgb(255,42,42)', 'rgb(221,25,25)', 'rgb(187,8,8)',
                            'rgb(128,128,128)', 'rgb(77,77,77)', 'rgb(25,25,25)',
                        ]
                    ]
                ]
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                                'suggestedMin'=> 0,
                                'stepSize' => 1
                            ],
                            'display' => false
                        ]
                    ]
                ],
                'legend' => [
                    'display' => false
                ]
            ]
        ];

        return response()->json(json_encode($data));
    }



    //GRAPHIQUE DES TYPES DE GRIMPE
    function climbs(){

        $user = User::where('id', Auth::id())->with('settings')->first();
        $crosses = Cross::getCrossWithFilter($user);

        $climbArray = [
            1  => 0,2  => 0,3  => 0,
            4  => 0,5  => 0,6 => 0,
            7 => 0, 8 => 0, 9 => 0,
        ];

        foreach ($crosses as $cross){
            $climbArray[$cross->route->climb_id]++;
        }

        $data = [
            'type'=>'doughnut',
            'data'=> [
                'labels' => [
                    trans('elements/climbs.climb_2'), trans('elements/climbs.climb_3'), trans('elements/climbs.climb_4'), trans('elements/climbs.climb_5'), trans('elements/climbs.climb_6'), trans('elements/climbs.climb_7'), trans('elements/climbs.climb_8')
                ],
                'datasets' => [
                    [
                        'data' => [
                            $climbArray[2], $climbArray[3], $climbArray[4], $climbArray[5], $climbArray[6], $climbArray[7], $climbArray[8]
                        ],
                        'backgroundColor' => [
                            'rgb(255,204,0)', 'rgb(55,113,200)', 'rgb(255,85,85)','rgb(233,43,43)','rgb(212,0,0)','rgb(135,205,222)','rgb(55,200,113)',
                        ]
                    ]
                ]
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'legend' => [
                    'display' => true,
                    'position'=>'right'
                ]
            ]
        ];

        return response()->json(json_encode($data));
    }


    //GRAPHIQUE DES MODES D'ENCHAINEMENT
    function statuses(){

        $user = User::where('id', Auth::id())->with('settings')->first();
        $crosses = Cross::getCrossWithFilter($user);

        $statusesData = [];
        $statusesLabel = [];
        $statuses = CrossStatus::all();

        // Liste des labels (le -1 et pour que l'index commence à 0)
        foreach ($statuses as $status){
            $statusesLabel[$status->id - 1] = trans('elements/statuses.status_' . $status->id);
            $statusesData[$status->id - 1] = 0;
        }

        // Croix par element
        foreach ($crosses as $cross) $statusesData[$cross->status_id - 1]++;

        $data = [
            'type'=>'radar',
            'data'=> [
                'labels' => $statusesLabel,
                'datasets' => [
                    [
                        'label' => '',
                        'data' => $statusesData,
                        'borderColor' => '#FF5722'
                    ]
                ]
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'scales' => [
                    'display' => false,
                ],
                'legend' => [
                    'display' => false
                ]
            ]
        ];

        return response()->json(json_encode($data));
    }

    //GRAPHIQUE DES MODES DE GRIMPE
    function modes(){

        $user = User::where('id', Auth::id())->with('settings')->first();
        $crosses = Cross::getCrossWithFilter($user);

        $modesData = [];
        $modesLabel = [];
        $modes = CrossMode::all();

        // Liste des labels (le -1 et pour que l'index commence à 0)
        foreach ($modes as $modes){
            $modesLabel[$modes->id - 1] = trans('elements/modes.mode_' . $modes->id);
            $modesData[$modes->id - 1] = 0;
        }

        // Croix par element
        foreach ($crosses as $cross) $modesData[$cross->mode_id - 1]++;

        $data = [
            'type'=>'bar',
            'data'=> [
                'labels' => $modesLabel,
                'datasets' => [
                    [
                        'label' => '',
                        'data' => $modesData,
                        'borderColor' => '#2196F3',
                        'backgroundColor' => '#2196F3'
                    ]
                ]
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'scales' => [
                    'display' => false,
                    'yAxes' => [
                        [
                            'ticks' => [
                                'suggestedMin'=> 0,
                                'stepSize' => 1
                            ],
                            'display' => false
                        ]
                    ]
                ],
                'legend' => [
                    'display' => false
                ]
            ]
        ];

        return response()->json(json_encode($data));
    }
}
