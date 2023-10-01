<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $video = Video::all();
        if ($video->count() > 0) {
            return response()->json(['status_code' => Response::HTTP_OK, 'status' => 'success', 'data' => $video]);
        } else {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'success', 'message' => 'No video found']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {

        if ($request->has('video')) {
            $videoupload = $request->file('video');
            $filename = time() . '.' . $request->video->extension();
            $videoupload->move(public_path('uploads'), $filename);

            $videourl = config('app.url').'/uploads/'.$filename;
        }
        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description ?? null,
            'url' => isset($videourl) ? $videourl : '',
        ]);


        $videostream = fopen($videourl, 'r');

        $apiURL = 'https://transcribe.whisperapi.com';
        $headers = [
            'Authorization' => 'Bearer '.config('app.whisperapi')
        ];

        $response = Http::withHeaders($headers)->attach('file',$videostream)->post($apiURL, [
            'diarization' => "false",
            'fileType' => 'mp4',
            'task' => 'transcribe'
        ]);

        $data= $response->json();

        $video->update([
            'payload' => $response->json(),
            'transcript' => $data['text'],
            //'segments' => $data['segments'],
            //'language'  => $data['language'],
        ]);



        return response()->json(['status_code' => Response::HTTP_CREATED, 'status' => 'success', 'data' => $video]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $video = video::find($id);

        //$video->update(['segments'=> $video->payload['segments']]);
        //return response()->json($video->payload['segments']);
        if (!$video) {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'error', 'message' => 'video does not exist']);
        } else {
            return response()->json(['status_code' => Response::HTTP_OK, 'status' => 'success', 'data' => $video], Response::HTTP_OK);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        //
    }


}
