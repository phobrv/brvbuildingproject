
<div class="card">
	<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
		<div class="card-body">
			<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
			@csrf
			@include('phobrv::input.inputText',['label'=>'Title','key'=>'overall_title','type'=>'meta'])
			@include('phobrv::input.inputTextarea',['label'=>'Description','key'=>'overall_description','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Số lượng ảnh','key'=>'overall_img_number','type'=>'meta'])
			@isset($data['meta']['overall_img_number'])
			@for($i=0;$i<$data['meta']['overall_img_number'];$i++)
			@php $img = 'overall'.$i.'_img'; @endphp
			@include('phobrv::input.inputImage',['label'=>'Image '.($i+1),'key'=>$img,'type'=>'meta','width'=>'100px'])
			@endfor
			@endif

			<hr>
			@include('phobrv::input.inputText',['label'=>'Number','key'=>'overall_number','type'=>'meta'])
			@isset($data['meta']['overall_number'])
			@for($i=0;$i<$data['meta']['overall_number'];$i++)
			@php
			$label = 'overall'.$i.'_lable'; 
			$meta = 'overall'.$i.'_meta'; 
			@endphp
			<label>No {{ $i+1 }}</label>
			@include('phobrv::input.inputText',['label'=>'Label','key'=>$label,'type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Meta','key'=>$meta,'type'=>'meta'])
			@endfor
			@endif
		</div>
		<div class="card-footer">
			{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
		</div>
	</form>
</div>


