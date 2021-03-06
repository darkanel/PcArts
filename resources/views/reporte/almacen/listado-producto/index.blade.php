@extends ('layouts.admin')
@section('name', "Reportes de Almacén Listado de Productos")
@section('content')
	<div class="row">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
			@include('reporte.almacen.listado-producto.search')
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pull-right">
			<a href="{{ url('pdf/reportearticuloprecio') }}"><button class="btn btn-primary"><i class="fa fa-print"></i> Imprimir Reporte</button></a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th width="5%">Codigo</th>
						<th width="35%">Nombre</th>
						<th width="10%">Categoría</th>
						<th width="5%">Stock</th>
						<th width="10%">Costo</th>
						<th width="10%">Precio Venta</th>
					</thead>
					@foreach ($articulos as $art)
						<tr>
							<td align="center">{{ str_pad($art->idarticulo, 3, "0", STR_PAD_LEFT) }}</td>
							<td>{{ $art->nombre }}</td>
							<td align="center">{{ $art->categoria }}</td>
							<td align="center">{{ $art->stock }}</td>
							<td align="right">{{ number_format($art->precio_compra, 2, ',', '.') }}</td>
							<td align="right">{{ number_format($art->precio_venta, 2, ',', '.') }}</td>
						</tr>
					@endforeach
					<tr>
						<td></td>
						<td></td>
						<td align="center"><strong>TOTAL:</strong></td>
						<td align="center"><strong>{{ $sum_stock }}</strong></td>
						<td align="right"><strong>------</strong></td>
						<td align="right"><strong>------</strong></td>
					</tr>
				</table>
			</div>
			{{ $articulos->appends(Request::all())->render() }}
		</div>
	</div>
@endsection