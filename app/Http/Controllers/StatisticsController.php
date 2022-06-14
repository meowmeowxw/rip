<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function mostSelledBeers()
    {
        //$tables = DB::select('SHOW TABLES');
        //$tables = DB::select('SHOW TABLES');
        //foreach($tables as $table)
        //{
        //    foreach ($table as $key => $value)
        //        echo $value.", ";
        //}

        /*
        $most_selled_beer = DB::table(['sub_orders'])
            ->select('product_id', DB::raw('SUM(ordered_quantity) as selled'))
            ->groupBy('product_id')
            ->orderBy('selled')
            ->get();
        */
        $most_selled_beer = json_decode(json_encode(DB::select("SELECT product_id, SUM(ordered_quantity) as sold
                FROM sub_orders
                GROUP BY product_id
                ORDER BY sold DESC")), true);
        print_r($most_selled_beer);
        for ($i = 0; $i < count($most_selled_beer); $i++){
            foreach ($most_selled_beer[$i] as $k => $v) {
                echo $k." ".$v."<br>";
            }
        }


        //foreach ($most_selled_beer as $k => $v) {
        //    echo $k." ".$v;
        //}
        /*
        return $most_selled_beer;
        */
    }

    public function customerWhoPurcasedMore()
    {

    }
}
?>
