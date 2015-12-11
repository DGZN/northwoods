<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use App\Asset;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadController extends Controller {

    public function index() {
        return view('dropzone');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [

        ]);

        if ($validator->fails()) {
            dd('Validation Failed', $validator->errors());

        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $saved = $file->move('uploads', rand(1111, 99999999).'.'.$extension);
            dd('FILE', $file, 'Saved', $saved);
        }

        dd($request->all());
    }

    public function uploadFilesBad() {

        $input = Input::all();

        $rules = array(
            'file' => 'mimes:jpeg,bmp,png,mp4,pdf|max:300000',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            dd('Validation Failed', $validation->errors());
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $saved = $file->move('uploads', rand(1111, 99999999).'.'.$extension);
            dd('FILE', $file, 'Saved', $saved);
        }

        dd('Not moved');

        $destinationPath = 'uploads';
        dd(Input::file('file'));
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path

        (new Asset)->create([
            'clientID' => $input['clientID'],
            'projectID' => $input['projectID'],
            'name'      => $fileName
        ]);

        if ($upload_success) {
            return Response::json('success', 200);
        } else {
            return Response::json('error', 400);
        }
    }

}
