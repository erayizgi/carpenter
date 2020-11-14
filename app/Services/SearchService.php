<?php


namespace App\Services;


use App\Price;
use Symfony\Component\HttpFoundation\Response;

class SearchService
{
    protected $depth;
    protected $width;
    protected $length;

    public function __construct($depth, $width, $length)
    {
        $this->depth = $depth;
        $this->width = $width;
        $this->length = $length;
    }

    public function search()
    {
        $exactMatch = Price::where([
            'width' => $this->width,
            'length' => $this->length,
            'depth' => $this->depth
        ])->first();
        if ($exactMatch) {
            return $exactMatch;
        }
        $filteredByDepth = Price::where('depth', $this->depth)->get()->toArray();
        $nearestLength = $this->binarySearch($filteredByDepth, 'length', $this->length);
        $nearestWidth = $this->binarySearch($filteredByDepth, 'width', $this->width);
        $nearestPlank = Price::where([
            'depth' => $this->depth,
            'length' => $nearestLength,
            'width' => $nearestWidth
        ])->first();
        return $nearestPlank;
    }

    protected function binarySearch($data, $key, $term)
    {
        if (count($data) <= 2) {
            // If the carpenter needs a plank which is not exactly matching (e.g for 60mm 810 width and 910 length), carpenter
            // would always use a bigger plank (e.g for 60mm 900 width and 1000 length).
            if ($data[0][$key] >= $term) {
                return $data[0][$key];
            }
            return $data[1][$key];
        }
        $middleIndex = floor((count($data) - 1) / 2);

        if ($term === $data[$middleIndex][$key]) {
            return $data[$middleIndex];
        }
        if ($term < $data[$middleIndex][$key]) {
            $sliced_array = array_slice($data, 0, $middleIndex + 1);
            return $this->binarySearch($sliced_array, $key, $term);
        } else {
            $sliced_array = array_slice($data, $middleIndex + 1, count($data) - 1);
            return $this->binarySearch($sliced_array, $key, $term);
        }
    }
}
