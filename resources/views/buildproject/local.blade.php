<div class="card">
	<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
		<div class="card-body">
			
			<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
			@csrf
			@include('phobrv::input.inputText',['label'=>'Title','key'=>'local_title','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Des','key'=>'local_des','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Google Emble','key'=>'local_google','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Number','key'=>'local_number','type'=>'meta'])
			@isset($data['meta']['local_number'])
			@for($i=0;$i<$data['meta']['local_number'];$i++)
			@php
			$meta = 'local'.$i.'_meta'; 
			@endphp
			@include('phobrv::input.inputText',['label'=>'Meta '.($i+1),'key'=>$meta,'type'=>'meta'])
			@endfor
			@endif
		</div>
		<div class="card-footer">
			{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
		</div>
	</form>
</div>


