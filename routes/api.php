<?php

use Illuminate\Http\Request;
Route::get('checkAuth', 'AutodeskController@checkAuth');
Route::get('createBucket', 'AutodeskController@createBucket');
Route::get('getBuckets', 'AutodeskController@getBuckets');
Route::get('getBucket/{bucketKey}', 'AutodeskController@getBucket');
Route::get('putObjects/{bucketKey}/{objectName}', 'AutodeskController@putObjects');
Route::get('putLargeObjects/{bucketKey}/{objectName}', 'AutodeskController@putLargeObjects');
Route::get('getStatusLargeObjectUpload/{bucketKey}/{objectName}/{sessionId}', 'AutodeskController@getStatusLargeObjectUpload');
Route::get('getObjects/{bucketKey}','AutodeskController@getObjects');
Route::get('getObject/{bucketKey}/{objectName}','AutodeskController@getObject');
Route::get('downloadObject/{bucketKey}/{objectName}','AutodeskController@downloadObject');
Route::get('signURL/{bucketKey}/{objectName}', 'AutodeskController@signURL');
Route::get('signResource/{id}', 'AutodeskController@signResource');
Route::get('signResourceResumable/{id}', 'AutodeskController@signResourceResumable');
Route::get('downLoadSignedURL/{id}', 'AutodeskController@downLoadSignedURL');
Route::get('deleteSignedURL/{id}', 'AutodeskController@deleteSignedURL');
Route::get('copyObject/{bucketKey}/{objectName}/{newObjectName}','AutodeskController@copyObject');
Route::get('deleteObject/{bucketKey}/{objectName}','AutodeskController@deleteObject');

// Route::get('get3DModels', 'AutodeskController@get3DModels');
// Route::get('getProject', 'AutodeskController@getProject');
// Route::get('getHubs', 'AutodeskController@getHubs');
// Route::get('checkManifest', 'AutodeskController@checkManifest');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
