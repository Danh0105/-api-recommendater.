<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PredictController extends Controller
{
    public $arrayNormalized, $arrSimilarity, $arr_avg;
    public function __construct($arrayNormalized, $arr_avg, $arrSimilarity)
    {
        $this->arrayNormalized = $arrayNormalized;
        $this->arrSimilarity = $arrSimilarity;
        $this->arr_avg = $arr_avg;
    }
    public function index()
    {
        $ArrayPredict = $this->arrayNormalized;
        foreach ($this->arrayNormalized[key($this->arrayNormalized)] as $key => $value) {
            foreach ($this->arrayNormalized as $key2 => $value2) {
                if ($this->arrayNormalized[$key2][$key] == 0) {
                    $ArrayPredict[$key2][$key] = round($ArrayPredict[$key2][$key] + $this->findLargestNumbers($this->arrayNormalized, 2, $key, $key2, $this->arrSimilarity) + $this->arr_avg[$key2], 2);
                } else {
                    $ArrayPredict[$key2][$key] = round($ArrayPredict[$key2][$key] + $this->arr_avg[$key2], 2);

                }

            }

        }

        return $ArrayPredict;
    }

    function findLargestNumbers($array, $k, $keyN, $keyN2, $array2)
    {
        $sumN = 0;
        $sumS = 0;

        if ($k > count($array))
            return response("K phải nhỏ hơn hoặc bằng ", count($array));
        for ($i = 0; $i < $k; $i++) {
            $N = null;
            $keys = array_keys($array);
            $temp = $keys[$i];
            $max = $array[$temp][$keyN];
            if ($max == 0) {
                $keys = array_keys($array);
                $temp = $keys[$i + 1];
                $max = $array[$temp][$keyN];
            }
            foreach ($array as $key2 => $value2) {
                if ($array[$key2][$keyN] > $max && $array[$key2][$keyN] != 0) {
                    $max = $array[$key2][$keyN];
                    $array[$key2][$keyN] = 0;
                    $N = $key2;
                }
            }
            if (!$N)
                $array[$temp][$keyN] = 0;
            $S = ($N) ? $array2[$keyN2][$N] : $array2[$keyN2][$temp];
            $sumN += ($max * $S);
            $sumS += abs($S);
        }
        return $sumN / $sumS;
    }
}