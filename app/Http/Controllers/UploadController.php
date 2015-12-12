<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Input;
use Response;
use App\Asset;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadController extends Controller {

    public function index() {
        return view('dropzone');
    }

    /**
     * Moves Uploaded File and Creates New Asset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'file' => 'mimes:jpeg,bmp,png,mp4,pdf|max:300000',
        ]);

        if ($validator->fails()) {

            dd('Validation Failed', $validator->errors());

        }

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $mime = $file->getMimeType();
            $ext = $file->getClientOriginalExtension();
            $name = rand(1111, 99999999).'.'.$ext;

            $saved = $file->move('uploads', $name);

            if ($saved) {

              $mimeParts = explode('/', $mime);

              if ($mimeParts[0] == 'video') {

                $thumb = $name . '-screenshot.jpg';
                $this->screenshot($name, $thumb);

              }

              (new Asset)->create([
                  'clientID'  => $request->get('clientID'),
                  'projectID' => $request->get('projectID'),
                  'name'      => $name,
                  'mime'      => $mime,
                  'thumb'     => isset($thumb) ? $thumb : ''
              ]);



              return Response::json('success', 200);

            }

            return Response::json('error', 400);

        }

        return Response::json('success', 200);
    }

    /**
     * Saves Screenshot From Video at Cue Point
     *
     * @param  {string} $file
     * @return {string} $thumb
     */
    public function screenshot($file, $thumb)
    {
      $process = new Process('cd ' . public_path() . '/uploads' . ' && /usr/local/Cellar/ffmpeg/2.7.2_1/bin/ffmpeg -i ' . $file . ' -ss '.rand(1,13).' -vframes 1 ' . $thumb);
      $process->run();
      if (!$process->isSuccessful()) {
          throw new ProcessFailedException($process);
      }
    }

}
