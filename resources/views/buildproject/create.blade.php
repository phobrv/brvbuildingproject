@extends('phobrv::adminlte3.layout')

@section('header')
<a href="{{route('buildproject.index')}}"  class="btn btn-default float-left">
	<i class="fa fa-backward"></i> @lang('Back')
</a>

@endsection

@section('content')

<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_1" data-toggle="tab">Main</a></li>
		<li><a href="#tab_2" data-toggle="tab">Page Head</a></li>
		<li><a href="#tab_3" data-toggle="tab">Tổng thể</a></li>
		<li><a href="#tab_4" data-toggle="tab">Vị trí dự án</a></li>
		<li><a href="#tab_5" data-toggle="tab">Mặt bằng</a></li>
		<li><a href="#tab_6" data-toggle="tab">Tiện ích</a></li>
		<li><a href="#tab_7" data-toggle="tab">Tiến độ</a></li>
		<li><a href="#tab_8" data-toggle="tab">Thư viện ảnh & Video</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1">
			@include('phobrv::buildproject.main')
		</div>
		@isset($data['post'])
		<div class="tab-pane" id="tab_2">
			@include('phobrv::buildproject.pageHead')
		</div>
		<div class="tab-pane" id="tab_3">
			@include('phobrv::buildproject.overall')
		</div>
		<div class="tab-pane" id="tab_4">
			@include('phobrv::buildproject.local')
		</div>
		<div class="tab-pane" id="tab_5">
			@include('phobrv::buildproject.area')
		</div>
		<div class="tab-pane" id="tab_6">
			@include('phobrv::buildproject.utility')
		</div>
		<div class="tab-pane" id="tab_7">
			@include('phobrv::buildproject.progress')
		</div>
		<div class="tab-pane" id="tab_8">
			@include('phobrv::buildproject.media')
		</div>
		@endif
	</div>
</div>
@endsection

@section('styles')
<style type="text/css">
	#listTagShow .btn-flat{
		margin-top: 3px;
		margin-bottom: 5px;
	}
	#listTagShow .show{
		position: relative;
		padding-right: 15px;
		float: left;
	}
	#listTagShow .show i{
		position: absolute;
		z-index: 1;
		top: -5px;
		right: 3px;
		color: red;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
	window.onload = function() {
		CKEDITOR.replace('overall_description', options);
	};
	$('.MenuForm').submit(function(e){
		e.preventDefault();

		var data = {};
		var getData = $(this).serializeArray();
		for(var i=0;i<getData.length;i++){
			if(getData[i]['name']!='_token')
				data[getData[i]['name']] = getData[i]['value'];
		}
		var editors = $(this).find('textarea');
		for(var j=0;j<editors.length;j++)
		{
			var name = editors[j].name;
			if(CKEDITOR.instances[name])
				data[name] = CKEDITOR.instances[name].getData();
		}


		$.ajax({
			headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: '{{URL::route("menu.updateMetaAPI")}}',
			type: 'POST',
			data: {data: data},
			success: function(output){
				alertOutput(output['msg'],output['message'])
			}
		});
	})
</script>
@endsection