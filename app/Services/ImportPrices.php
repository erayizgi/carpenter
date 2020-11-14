<?php


namespace App\Services;


use App\Price;
use Illuminate\Support\Facades\DB;

class ImportPrices
{
    protected $lines;
    protected $depth;

    public function boot($path, $depth)
    {
        $this->depth = $depth;
        try{
            DB::beginTransaction();
            Price::where('depth',$this->depth)->delete();
            $this->convertCSVToArray($path)->import();
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function convertCSVToArray($path)
    {
        $file = fopen($path, 'r');
        do {
            $lines[] = fgetcsv($file, 0, ',');
        } while (!feof($file));
        fclose($file);

        $this->lines = $lines;
        return $this;
    }

    public function import()
    {
        $data = $this->lines;
        $length = array_shift($data);
        array_shift($length);
        for ($i = 0; $i < count($data) - 1; $i++) {
            $width = array_shift($data[$i]);
            foreach ($data[$i] as $l => $price) {
                Price::create([
                    'depth' => $this->depth,
                    'width' => $width,
                    'length' => $length[$l],
                    'price' => $price
                ]);
            }
        }
    }

}
