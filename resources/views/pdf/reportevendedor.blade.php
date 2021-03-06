@extends ('pdf.reporte')

@section('title', "Listado de Vendedor")

@section('content')
	<h2>Listado de Vendedor</h2>
	<table width="100%">
		<tr style="background-color: #dddddd;">
			<th width="5%">Id</th>
			<th width="50%">Nombre</th>
			<th width="13%">Numero Doc.</th>
			<th width="13%">Telefono</th>
			<th width="13%">Tipo Persona</th>
		</tr>		
		@foreach ($personas as $per)
			<tr>												
				<td style="text-align: center;">{{ str_pad($per->idpersona, 3, "0", STR_PAD_LEFT) }}</td>
				<td>{{ $per->nombre }}</td>
				<td>{{ $per->tipo_documento.' - '.$per->num_documento }}</td>
				<td>{{ $per->telefono }}</td>
				<td style="text-align: center;">{{ $per->tipo_persona }}</td>							
			</tr>						
		@endforeach				
	</table>
@endsection