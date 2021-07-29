<?php 
Route::middleware(['web', 'auth', 'auth:sanctum', 'lang', 'verified'])->namespace('Phobrv\BrvCore\Http\Controllers')->group(function () {
	Route::middleware(['can:menu_manage'])->prefix('admin')->group(function () {
		Route::resource('buildprojectgroup', 'TermController');
	});
});

Route::middleware(['web', 'auth', 'auth:sanctum', 'lang', 'verified'])->namespace('Phobrv\BrvBuildingProject\Controllers')->group(function () {
	Route::middleware(['can:supper_admin'])->prefix('admin')->group(function () {
		Route::resource('buildproject', 'BuildProjectController');
		Route::post('/buildproject/updateUserSelectGroup', 'BuildProjectController@updateUserSelectGroup')->name('buildproject.updateUserSelectGroup');
		Route::post('/buildproject/changeStatus', 'BuildProjectController@changeStatus')->name('buildproject.changeStatus');
		Route::get('/buildproject/setGroupSelect/{id}', 'BuildProjectController@setGroupSelect')->name('buildproject.setGroupSelect');

	});
});