<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER `StockIngresar` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW 
                BEGIN
                    UPDATE articulo SET stock = stock + new.cantidad
                    WHERE articulo.idarticulo = new.idarticulo;
                END 
        ');

        DB::unprepared('
            CREATE TRIGGER `StockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW 
                BEGIN
                    UPDATE articulo SET stock = stock - new.cantidad
                    WHERE articulo.idarticulo = new.idarticulo;
                END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `StockIngresar`');
        DB::unprepared('DROP TRIGGER `StockVenta`');
    }
}
