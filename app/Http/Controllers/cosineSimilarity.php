<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cosineSimilarity extends Controller
{
    public $vec1;
    public $vec2;
    public function __construct($vec1, $vec2)
    {
        $this->vec1 = $vec1;
        $this->vec2 = $vec2;
    }
    function index()
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        /* for ($i = 0; $i < count($this->vec1); $i++) {
            $dotProduct += $this->vec1[$i] * $this->vec2[$i];
            $magnitude1 += $this->vec1[$i] * $this->vec1[$i];
            $magnitude2 += $this->vec2[$i] * $this->vec2[$i];
        } */
        foreach ($this->vec1 as $i => $value) {
            $dotProduct += $this->vec1[$i] * $this->vec2[$i];
            $magnitude1 += $this->vec1[$i] * $this->vec1[$i];
            $magnitude2 += $this->vec2[$i] * $this->vec2[$i];
        }
        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        } else {
            $result = $dotProduct / ($magnitude1 * $magnitude2);
            return $result;
        }
    }
}
