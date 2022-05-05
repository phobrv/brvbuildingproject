<div class="card">
	<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
		<div class="card-body">
			<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
			@csrf
			@include('phobrv::input.inputText',['label'=>'Title','key'=>'utility_title','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Des','key'=>'utility_test','type'=>'meta'])
			@include('phobrv::input.inputImage',['label'=>'Banner ','key'=>'utility_banner','type'=>'meta','width'=>'200px'])
			@include('phobrv::input.inputText',['label'=>'Number','key'=>'utility_number','type'=>'meta'])
			@isset($data['meta']['utility_number'])
			@for($i=0;$i<$data['meta']['utility_number'];$i++)
			@php
			$title = 'utility'.$i.'_title'; 
			$link = 'utility'.$i.'_link'; 
			@endphp
			<label>No {{ $i+1 }}</label>
			@include('phobrv::input.inputText',['label'=>'Title','key'=>$title,'type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Link','key'=>$link,'type'=>'meta'])
			@endfor
			@endif
		</div>
		<div class="card-footer">
			{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
		</div>
	</form>
</div>



