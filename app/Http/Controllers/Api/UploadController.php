<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
  public function list() {
  	$images = DB::table('images')->select('filename')->get();
    foreach ($images as $key => $value) {
      $imgURl[] = env('APP_URL').$value->filename;
    }
    return response()->json($imgURl);
  }

  public function create(Request $request) {
    if ($request->hasfile('filename')) {
      $images = $request->file('filename');
      foreach($images as $image) {
        $name = $image->getClientOriginalName();
        $path = $image->storeAs('uploads', $name, 'public');
        // $image->move(base_path() . '/public/uploads/file/', $name);
        Image::create([
          'name' => $name,
          'filename' => env('APP_URL').'/storage/'.$path
        ]);
      }
      $imageData = DB::table('images')->select('filename')->get();
      foreach ($imageData as $key => $value) {
        $imgURl[] = $value->filename;
      }
      return response()->json($imgURl);
    }
  }
}
