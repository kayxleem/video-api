<?php

namespace App\Http\Controllers;

use App\Models\Video;
//use Illuminate\Http\Request;
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
            return response()->json($video);
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
            $image = $request->file('video');
            $filename = time() . '.' . $request->video->extension();
            $image->move(public_path('uploads'), $filename);

            $image = config('app.url').'/uploads/'.$filename;
        }
        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description ?? null,
            'url' => isset($image) ? $image : '',
        ]);
        return response()->json($video, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $video = video::find($video);
        if (!$video) {
            return response()->json(['status_code' => Response::HTTP_NOT_FOUND, 'status' => 'error', 'message' => 'video does not exist']);
        } else {
            return response()->json($video, Response::HTTP_OK);
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
