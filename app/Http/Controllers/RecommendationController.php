<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class RecommendationController extends Controller
{
    public function Similaritymatrix(Request $request)
    {

        /* $array = [
                "u0" => [
                "i0" => "5",
                "i1" => "4",
                "i2" => "-1",
                "i3" => "2",
                "i4" => "2",
                ],
                "u1" => [
                "i0" => "5",
                "i1" => "-1",
                "i2" => "4",
                "i3" => "2",
                "i4" => "0",
                ],
                "u2" => [
                "i0" => "2",
                "i1" => "-1",
                "i2" => "1",
                "i3" => "3",
                "i4" => "4",
                ],
                "u3" => [
                "i0" => "0",
                "i1" => "0",
                "i2" => "-1",
                "i3" => "4",
                "i4" => "-1",
                ],
                "u4" => [
                "i0" => "1",
                "i1" => "-1",
                "i2" => "-1",
                "i3" => "4",
                "i4" => "-1",
                ],
                "u5" => [
                "i0" => "-1",
                "i1" => "2",
                "i2" => "1",
                "i3" => "-1",
                "i4" => "-1",
                ],
                "u6" => [
                "i0" => "-1",
                "i1" => "-1",
                "i2" => "1",
                "i3" => "4",
                "i4" => "5",
                ],
            ]; */
        try{
            if ($request->has('K') && $request['K'] >= (count($request["matrix"]) - 1))
        {
            return response()->json(["mess" => "K must not be greater than or equal to. " . (count($request["matrix"]) - 1), "status" => 500]);
        }
        $normalized = new NormalizedController($request["matrix"]);
        $arrayNormalized = $normalized->index();
        //Similarity matrix
        $Simalarity = new SimilarityController($arrayNormalized['Nor']);
        $arrSimilarity = $Simalarity->index();
        //Predict
        $predict = new PredictController($arrayNormalized['Nor'], $arrayNormalized['AVG'], $arrSimilarity, $request['K']);
        $result = $predict->index();
        return response()->json($result);
        } catch (Exception $e)
        {
                        return response()->json(["mess" => "K must not be greater than or equal to. "]);

        }
    }
}

