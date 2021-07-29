<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
	<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
	@csrf
	@include('phobrv::input.inputText',['label'=>'Title','key'=>'area_title','type'=>'meta'])
	@include('phobrv::input.inputFile',['label'=>'Banner ','key'=>'area_banner','type'=>'meta','width'=>'200px'])
	<hr>
	{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
</form>


