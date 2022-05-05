<div class="card">
	<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
		<div class="card-body">

			<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
			@csrf
			<label>Thư viện ảnh</label>
			@include('phobrv::input.inputText',['label'=>'Title','key'=>'image_title','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Des','key'=>'image_des','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Number','key'=>'image_number','type'=>'meta'])
			@isset($data['meta']['image_number'])
			@for($i=0;$i<$data['meta']['image_number'];$i++)
			@php
			$album = 'img'.$i.'_term'; 
			@endphp
			@include('phobrv::input.inputSelect',['label'=>'Album '.($i+1),'key'=>$album,'type'=>'meta','array'=>$arrayAlbum])
			@endfor
			@endif
			<label>Video</label>
			@include('phobrv::input.inputText',['label'=>'Title','key'=>'video_title','type'=>'meta'])
			@include('phobrv::input.inputSelect',['label'=>'Nhóm video ','key'=>'video_term','type'=>'meta','array'=>$arrayVideo])
		</div>
		<div class="card-footer">
			{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
		</div>
	</form>
</div>


