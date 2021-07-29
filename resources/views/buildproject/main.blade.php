<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['post']) ? route('buildproject.update',array('buildproject'=>$data['post']->id)) : route('buildproject.store')}}"  enctype="multipart/form-data">
	@csrf
	@isset($data['post']) @method('put') @endisset
	<input type="hidden" id="typeSubmit" name="typeSubmit" value="">
	<div class="row">
		<div class="col-md-8">
			@isset($data['post'])

			@include('phobrv::input.inputText',['label'=>'Create date','key'=>'created_at','datepicker'=>true,'value'=>date('Y-m-d',strtotime($data['post']->created_at))])

			@include('phobrv::input.inputText',['label'=>'Url','key'=>'slug'])

			@endif
			@include('phobrv::input.inputText',['label'=>'Title','key'=>'title','required'=>true])
			@isset($data['post'])
			@include('phobrv::input.inputText',['label'=>'Địa chỉ','key'=>'address','type'=>'meta'])
			<hr>
			<label class="font16" style="margin-top: 10px;">{{__('Seo Meta')}}</label>
			@include('phobrv::input.inputText',['label'=>'Meta Title','key'=>'meta_title','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Meta Description','key'=>'meta_description','type'=>'meta'])
			@include('phobrv::input.inputText',['label'=>'Meta Keywords','key'=>'meta_keywords','type'=>'meta'])
			<hr>
			<label>Thumb ngang</label>
			@include('phobrv::input.inputImage',['key'=>'thumb_horizontal','type'=>'meta'])
			@endif

		</div>
		<div  class="col-md-4">
			@if(!isset($data['post']))
			<a href="#" onclick="update()"  class="btn btn-warning float-left">
				<i class="fa fa-wrench"></i> @lang('Submit')
			</a>
			@endif
		</div>
		<div class="col-md-4">
			@isset($data['post'])
			@include('phobrv::input.inputImage',['label'=>'Icon','key'=>'thumb','width'=>'100%'])
			<hr>

			<div class="form-group">
				<div class="col-sm-12">
					<label  class="font16">Group</label>
				</div>
				@isset($data['arrayGroup'])
				<ul>
					@foreach($data['arrayGroup'] as $cate)
					<li>
						<input type="checkbox" name="group[]" value="{{$cate->id}}" @if(in_array($cate->id,$data['arrayGroupID'])) checked @endif> {{$cate->name}}
					</li>
					@if(isset($cate->child))
					@foreach($cate->child as $c)
					<li style="padding-left: 30px;">
						<input type="checkbox" name="group[]" value="{{$c->id}}" @if(in_array($c->id,$data['arrayGroupID'])) checked @endif> {{$c->name}}
					</li>
					@endforeach
					@endif
					@endforeach
				</ul>
				@endisset
			</div>

			<label>Thumb dọc</label>
			@include('phobrv::input.inputImage',['key'=>'thumb_vertical','type'=>'meta'])
			@endif

		</div>
	</div>
	<button id="btnSubmit" style="display: none" type="submit" ></button>
</form>
<div class="box-footer">
	<a href="#" onclick="save()"  class="btn btn-primary float-left">
		<i class="fa fa-floppy-o"></i> @lang('Save & Close')
	</a>
	<a href="#" onclick="update()"  class="btn btn-warning float-left">
		<i class="fa fa-wrench"></i> @lang('Update')
	</a>
</div>