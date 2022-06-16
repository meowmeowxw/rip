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
        return json_encode(DB::select("SELECT product_id, p.name, SUM(ordered_quantity) as sold
                FROM sub_orders
                JOIN products p on sub_orders.product_id = p.id
                GROUP BY product_id, p.name
                ORDER BY sold DESC"));
        /*
        print_r($most_selled_beer);
        for ($i = 0; $i < count($most_selled_beer); $i++){
            foreach ($most_selled_beer[$i] as $k => $v) {
                echo $k." ".$v."<br>";
            }
        }
        */
    }

    public function customersWhoPurchasedMore()
    {
        return json_encode(DB::select(<<<'EOF'
                    SELECT id, u.email, SUM(sold) as purchased_beer
                    FROM (SELECT c.id, sub_orders.product_id, SUM(sub_orders.ordered_quantity) as sold
                          FROM sub_orders
                                   JOIN seller_orders so on sub_orders.seller_order_id = so.seller_id
                                   JOIN orders o on so.order_id = o.id
                                   JOIN customers c on o.customer_id = c.id
                          GROUP BY c.id, sub_orders.product_id) sum_product_id_for_customer
                    JOIN (
                        SELECT u.email, u.userable_id
                        FROM users u
                        WHERE u.userable_type = 'App\\Models\\Customer'
                    ) as u on u.userable_id = id
                    GROUP BY id, u.email
                    ORDER BY purchased_beer DESC
                EOF));
        //print_r($customers_list);
        /*
        for ($i = 0; $i < count($customers_list); $i++) {
            echo "<br>";
            //echo $customers_list[$i];
            foreach ($customers_list[$i] as $k => $v) {
              echo $k." ".$v." ";
            }
        }
        */
    }

    public function sellerWhoSoldMore()
    {
        return json_encode(DB::Select(<<<'EOF'
                    SELECT id, company, SUM(beer_sold) as total_beer_sold
                    FROM (
                          SELECT s.id, s.company, SUM(ordered_quantity) as beer_sold
                          FROM sub_orders
                                   JOIN seller_orders so on sub_orders.seller_order_id = so.id
                                   JOIN sellers s on so.seller_id = s.id
                          GROUP BY product_id, s.id) beer_sold_by_seller
                    GROUP BY id
                    ORDER BY total_beer_sold DESC
                    EOF));
        //print_r($sellers_list);
        //return json_encode()
    }

    public function customersWhoReceivedMoreOrders()
    {
        $x = json_encode(DB::select(<<<'EOF'
                    SELECT c.id, u.email, COUNT(s2.name) as num_order_delivered
                    FROM customers c
                    JOIN orders o on c.id = o.customer_id
                    JOIN seller_orders so on o.id = so.order_id
                    JOIN sellers s on so.seller_id = s.id
                    JOIN status s2 on so.status_id = s2.id
                    JOIN (
                       SELECT u.email, u.userable_id
                       FROM users u
                       WHERE u.userable_type = 'App\\Models\\Customer'
                    ) as u on u.userable_id = c.id
                    WHERE s2.id = (
                       SELECT id
                       FROM status
                       where name = 'delivered'
                       LIMIT 1
                    )
                    GROUP BY c.id, u.email
                    ORDER BY num_order_delivered DESC
                    EOF));
        return $x;
        // print_r($x);
    }
}
?>
