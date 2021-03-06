<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use SisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use SisVentas\Venta;
use SisVentas\DetalleVenta;
use SisVentas\Articulo;
use SisVentas\Http\Requests\NotaDebitoFormRequest;

use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class CuentasporcobrarController extends Controller
{
    public function index(Request $request)
    {
        $noces=DB::table('tb_nota_credito')->where('estado','Activo')->get();
        $vendedores=DB::table('tb_persona')->where('tipo_persona','Vendedor')->get();
        $vende = $request->get('searchVendedor');

        $fact=trim($request->get('searchText'));
        $ventas=DB::table('tb_venta as v')
            ->join('tb_persona as p','p.idpersona','v.idcliente')
            ->join('tb_persona as p2','p2.idpersona','v.idvendedor')
            ->join('tb_detalle_venta as dv','v.idventa','dv.idventa')
            ->select('v.idventa','v.fecha_hora','v.fecha_entrega','v.fecha_pagada','p.nombre','v.idvendedor','p2.nombre as vendedor','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.estado','v.total_venta')
            ->where(function($query) use ($fact,$vende){
                if($fact){
                    if ($fact != "") {
                        return $query->where('v.serie_comprobante',$fact);
                    }
                }
                if ($vende) {
                    if ($vende != "") {
                         return $query->where('v.idvendedor',$vende);
                    }
                }
            })
            ->where('v.estado','Pendiente')
            ->groupBy('v.idventa','v.fecha_hora','v.fecha_entrega','v.fecha_pagada','p.nombre','v.idvendedor','p2.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.estado','v.total_venta')
            ->orderBy('idventa','desc')
            ->paginate(20);
        return view('cobranza.cuenta-por-cobrar.index',["ventas"=>$ventas,"searchText"=>$fact,"vendedores"=>$vendedores,"noces"=>$noces]);
    }


    public function create()
    {

    }

    public function store(NotaDebitoFormRequest $request)
    {

    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {

        $pagar = $request->get('up_pagar');
        $entrega = $request->get('up_entregar');
        if ($pagar == 1) {
            $venta=Venta::findOrFail($id);

            $venta->estado='Pagada';
                $mytime = Carbon::now('America/Caracas');
            $venta->fecha_pagada=$mytime->toDateTimestring();

                if( $venta->fecha_pagada > $venta->fecha_entrega)
                {
                    $StarDate = strtotime($venta->fecha_entrega);
                    $EndDate = strtotime($venta->fecha_pagada);
                    $cont = 0;
                    for($StarDate;$StarDate<=$EndDate;$StarDate=strtotime('+1 day ' . date('Y-m-d',$StarDate)))
                    {
                        if((strcmp(date('D',$StarDate),'Sun')!=0) and (strcmp(date('D',$StarDate),'Sat')!=0))
                        {
                            $cont = $cont + 1;
                        }
                    }
                   $cont;
                }
                elseif( $venta->fecha_pagada = $venta->fecha_entrega )
                {
                    $cont =  1;
                }

            $venta->detalle=$request->get('detalle');
            $venta->dias_pago=$cont;
            //dd($venta, $cont);
            $venta->save();

            flash('Factura Pagada')->success();

        }
        elseif ($entrega == 1) {
            $venta=Venta::findOrFail($id);
                $mytime = Carbon::now('America/Caracas');
            $venta->fecha_entrega=$mytime->toDateTimestring();
            $venta->detalle=$request->get('detalle');
            $venta->save();

            flash('Factura Entregada')->success();
        }
        return Redirect::to('cobranza/cuenta-por-cobrar');
    }
} /* FIN CuentasporcobrarController */
