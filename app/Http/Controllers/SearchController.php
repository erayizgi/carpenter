<?php

namespace App\Http\Controllers;

use App\Price;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try{
            $this->validate($request, [
                'width' => 'required|integer',
                'depth' => 'required|integer',
                'length' => 'required|integer'
            ]);
        }catch (ValidationException $validationException){

        }
        $searchService = new SearchService($request->depth, $request->width, $request->length);
        $nearestPlank = $searchService->search();
        return response()->json(['message' => 'Nearest match', "data" => $nearestPlank], Response::HTTP_OK);
    }

    public function searchResults(Request $request)
    {
        try{
            $this->validate($request, [
                'width' => 'required|integer',
                'depth' => 'required|integer',
                'length' => 'required|integer'
            ]);
        }catch (ValidationException $validationException){
            return response()->json($validationException->errors(), Response::HTTP_BAD_REQUEST);
        }
        $searchService = new SearchService($request->depth, $request->width, $request->length);
        $nearestPlank = $searchService->search();

        return view('search',$nearestPlank);

    }

}
