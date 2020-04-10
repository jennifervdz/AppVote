@extends("crudbooster::admin_template")
@section("content")
	<div class="panel-body">

		<div style="width: 1000px; height: 500px;">
			{!! Mapper::render() !!}
		</div>
	</div>		

@endsection