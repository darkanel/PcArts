<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table='tb_detalle_venta';

    protected $primaryKey='iddetalle_venta';

    public $timestamps=false;

    protected $fillable =[
    	'idventa',
        'idarticulo',
        'cantidad',
        'precio_venta',
        'descuento'
    ];

    protected $guarded =[
    	
    ];
}
