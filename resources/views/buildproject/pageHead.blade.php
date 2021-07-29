<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
	<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
	@csrf
	@include('phobrv::input.inputText',['label'=>'Title','key'=>'page_title','type'=>'meta'])
	@include('phobrv::input.inputText',['label'=>'Des','key'=>'page_des','type'=>'meta'])
	@include('phobrv::input.inputText',['label'=>'Backgroud Color','key'=>'page_color','type'=>'meta'])
	@include('phobrv::input.inputImage',['label'=>'Banner','key'=>'page_banner','type'=>'meta','width'=>'200px'])
	<hr>
	{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
</form>