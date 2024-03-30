<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NormalizedController extends Controller
{
    public $array_init;
    public function __construct($array)
    {
        $this->array_init = $array;
    }
    public function index(): array
    {
        $normalizedMatrix = $this->array_init;
        $arraySum = [];

        try {

            foreach ($this->array_init as $row => $value) {
                $filteredArray = array_filter($value, function ($temp) {
                    return $temp != -1;
                });
                $sum = array_sum($filteredArray);

                $count = count($value) - array_count_values($value)[-1];

                if ($count != -1) {
                    $average = round($sum / $count, 2);
                } else {
                    $average = 0;
                }

                $arraySum[$row] = $average;
            }
            foreach ($this->array_init as $rowKey => $row) {
                foreach ($row as $colKey => $colValue) {
                    if ($normalizedMatrix[$rowKey][$colKey] != -1) {
                        $normalizedMatrix[$rowKey][$colKey] -= $arraySum[$rowKey];
                    } else {
                        $normalizedMatrix[$rowKey][$colKey] = 0;
                    }
                }
            }
            return [
                "Nor" => $normalizedMatrix,
                "AVG" => $arraySum
            ];
        } catch (Exception $e) {
            return ["Mảng không đúng định dạng"];
        }
    }


}
