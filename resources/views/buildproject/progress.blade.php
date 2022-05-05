<div class="card">
	<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
		<div class="card-body">
			<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
			@csrf
			@include('phobrv::input.inputText',['label'=>'Title','key'=>'progress_title','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Des','key'=>'progress_des','type'=>'meta'])
			@include('phobrv::input.inputSelect',['label'=>'Album','key'=>'progress_term','type'=>'meta','array'=>$arrayAlbum])
		</div>
		<div class="card-footer">
			{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
		</div>
	</form>
</div>



