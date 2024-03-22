<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimilarityController extends Controller
{
    public $array_init;
    public function __construct(array $array)
    {
        $this->array_init = $array;
    }
    public function index(): array
    {
        $arraySimilarity = [];
        foreach ($this->array_init as $key1 => $row1) {
            foreach ($this->array_init as $key2 => $row2) {
                $cosin = new cosineSimilarity($row1, $row2);
                $result = $cosin->index();
                $arraySimilarity[$key1][$key2] = $result;
            }

        }
        return $arraySimilarity;
    }
}