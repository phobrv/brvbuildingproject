@extends('phobrv::adminlte3.layout')

@section('header')
<ul>
	<li>
		<a href="{{route('buildproject.create')}}"  class="btn btn-primary float-left">
			<i class="far fa-edit"></i> @lang('Create new')
		</a>
	</li>
	<li>
		{{ Form::open(array('route'=>'buildproject.updateUserSelectGroup','method'=>'post')) }}
		<table class="form" width="100%" border="0" cellspacing="1" cellpadding="1">
			<tbody>
				<tr>
					<td style="text-align:center; padding-right: 10px;">
						<div class="form-group">
							{{ Form::select('select',$data['arrayGroup'],(isset($data['select']) ? $data['select'] : '0'),array('id'=>'choose','class'=>'form-control')) }}
						</div>
					</td>
					<td>
						<div class="form-group">
							<button id="btnSubmitFilter" class="btn btn-primary ">@lang('Filter')</button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		{{Form::close()}}
	</li>
</ul>
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>{{__('Date')}}</th>
					<th>{{__('Title')}}</th>
					<th>{{__('Author')}}</th>
					<th>{{__('Status')}}</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@if($data['posts'])
				@foreach($data['posts'] as $r)
				<tr>
					<td align="center">{{$loop->index+1}}</td>
					<td align="center">{{date('d/m/Y',strtotime($r->created_at))}}</td>
					<td width="40%">
						<a href="{{route('level1',['slug'=>$r->slug])}}">
							{{$r->title}}
						</a>
					</td>

					<td>{{$r->user->name ?? ''}}</td>
					<td align="center">
						@if($r->status == 1)
						<a href="#" onclick="changeStatus('{{$r->id}}', this)">
							<i class="fa fa-check-circle" ></i>
						</a>
						@else
						<a href="#" style="color:red" onclick="changeStatus('{{$r->id}}', this)">
							<i class="fa fa-minus-circle"></i>
						</a>
						@endif
					</td>
					<td style="width: 50px;"  align="center">
						<a href="{{route('buildproject.edit',['buildproject'=>$r->id])}}">
							<i class="far fa-edit" title="S???a"></i>
						</a>

					</td>
					<td style="width: 50px;"  align="center">
						<a style="color: red" href="#" onclick="destroy('destroy{{$r->id}}')"><i class="fa fa-times" title="S???a"></i></a>
						<form id="destroy{{$r->id}}" action="{{ route('buildproject.destroy',['buildproject'=>$r->id]) }}" method="post" style="display: none;">
							@method('delete')
							@csrf
						</form>
					</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('styles')
<style type="text/css">

</style>
@endsection

@section('scripts')
<script type="text/javascript">
	function destroy(form){
		var anwser =  confirm("B???n mu???n x??a project n??y?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
	function changeStatus(id, obj){
		var result = confirm("B???n c?? mu???n thay ?????i tr???ng th??i c???a project n??y?");
		if (result == true) {
			$.ajax({
				headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				url: '{{URL::route("buildproject.changeStatus")}}',
				type: 'POST',
				data: {id: id},
				success: function(output){
					console.log(output);
					if (output == 1){
						$(obj).css('color','blue');
						$(obj).html('');
						$(obj).append('<i class="fa fa-check-circle"></i>');
					} else{
						$(obj).css('color','red');
						$(obj).html('');
						$(obj).append('<i class="fa fa-minus-circle"></i>');
					}
				}
			});
		}
	}
</script>
@endsection