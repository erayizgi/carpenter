<?php

namespace App\Http\Controllers;

use App\Services\ImportPrices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    protected $importService;
    public function __construct()
    {
        $this->importService = new ImportPrices();
    }

    public function import(Request $request)
    {
        if(!$this->importService->boot(Storage::disk('local')->path('60mm.csv'),60)){
            return response()->json(['message'=>'An error occured while importing the 60mm.csv'],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $message[] = '60mm.csv has been imported,';
        if(!$this->importService->boot(Storage::disk('local')->path('40mm.csv'),40)){
            return response()->json(['message'=>'An error occured while importing the 40mm.csv'],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $message[] = '40mm.csv has been imported';
        return response()->json(['message'=> $message], Response::HTTP_OK);
    }
}
