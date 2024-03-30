<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PredictController extends Controller
{
    public $arrayNormalized, $arrSimilarity, $arr_avg, $K;
    public function __construct($arrayNormalized, $arr_avg, $arrSimilarity, $K)
    {
        $this->arrayNormalized = $arrayNormalized;
        $this->arrSimilarity = $arrSimilarity;
        $this->arr_avg = $arr_avg;
        $this->K = $K;
    }
    public function index()
    {
        $ArrayPredict = $this->arrayNormalized;
        foreach ($this->arrayNormalized[key($this->arrayNormalized)] as $key => $value)
        {
            foreach ($this->arrayNormalized as $key2 => $value2)
            {
                if ($this->arrayNormalized[$key2][$key] == 0)
                {
                    $ArrayPredict[$key2][$key] = round($ArrayPredict[$key2][$key] + $this->findLargestNumbers($this->arrayNormalized, $this->K, $key, $key2, $this->arrSimilarity) + $this->arr_avg[$key2], 2);
                }
                else
                {
                    $ArrayPredict[$key2][$key] = round($ArrayPredict[$key2][$key] + $this->arr_avg[$key2], $this->K);

                }

            }

        }
        return $ArrayPredict;
    }

    function findLargestNumbers($array, $k, $keyI, $keyU, $array2)
    {

        $sumN = 0;
        $sumS = 0;
        for ($i = 0; $i < $k; $i++)
        {
            $N = null;
            $keys = array_keys($array2);
            $temp = $keys[$i];
            $max = $array2[$keyU][$temp];
            $j = 0;
            while ($max == 1)
            {
                $temp = $keys[++$j];
                $max = $array2[$keyU][$temp];
            }
            foreach ($array2 as $key2 => $value2)
            {
                if ($array2[$keyU][$key2] > $max && $array2[$keyU][$key2] != 1 && $key2 != $keyU && $array[$key2][$keyI] != 0)
                {
                    $max = $array2[$keyU][$key2];
                    $N = $key2;
                }
            }

            if ($N)
            {
                $S = $array[$N][$keyI];
                $max = $array2[$keyU][$N];
                $array2[$keyU][$N] = 1;
            }
            else
            {
                $S = $array[$temp][$keyI];
                $array2[$keyU][$temp] = 1;
            }

            $sumN += ($max * $S);
            $sumS += abs($max);

        }

        return $sumN / $sumS;

    }
}
