<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\PostRepositoryInterface;
use App\Classes\ResponseClass;
use App\Models\Post;
use App\Models\User;
use App\Models\UserHasOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\RecordsNotFoundException;

/**
 * @group Posts
 *
 * APIs for Posts
 */
class PostController extends Controller
{
    private PostRepositoryInterface $postRepositoryInterface;

    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface = $postRepositoryInterface;
    }
    /**
     * Get all posts
     * 
     * @response 200 {
     *   "id": 1,
     *   "name": "John Doe"
     * }
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'type' => 'nullable|string',
            'order_by' => 'nullable|in:id,type,created_at',
            'order' => 'nullable|in:asc,desc',
        ]);
        $data = $this->postRepositoryInterface->index($validated);


        return ResponseClass::sendResponse(PostResource::collection($data)->response()->getData(true), 'Get Data Successfully!', 200);
    }

    /**
     * Add a new Post
     */
    public function store(PostRequest $request)
    {
        // if ($request->input('type') == 'attachment') {
        //     $data = $this->postRepositoryInterface->uploadMedia($request);
        // } else {
        //     $data = $this->postRepositoryInterface->store($request->validated());
        // }
        DB::beginTransaction();
        try {
            $data = $this->handleRequest($request);
            if (is_array($data)) {
                DB::commit();
                return ResponseClass::sendResponse(PostResource::collection($data), 'Upload Success!!', 201);
            }
            DB::commit();
            return ResponseClass::sendResponse(new PostResource($data), 'Insert Success!!', 201);
        } catch (\Exception $e) {
            return ResponseClass::rollback($e);
        }
        // return Post::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = $this->postRepositoryInterface->getById($id);
            return ResponseClass::sendResponse(new PostResource($data), '', 200);
        } catch (RecordsNotFoundException $e) {
            return ResponseClass::throw($e, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(PostRequest $request, Post $post): Post
    // {
    //     $post->update($request->validated());

    //     return $post;
    // }

    public function update(Request $request, Post $post): Post
    {

        $post->update($request->all());

        return $post;
    }

    public function destroy(Post $post): Response
    {
        $post->delete();

        return response()->noContent();
    }

    private function uploadMedia(PostRequest $request)
    {
        $files = $request->file('files');

        $image_inserted = [];
        foreach ($files as $file) {
            $imageName = time() . $file->hashName();

            $path = $file->storeAs('image', $imageName, 'public');
            $url_path = env('APP_URL') . Storage::url($path);
            // return response()->json($file);

            // รวมค่า request เดิมกับค่าที่ต้องการเพิ่ม
            $postData = array_merge(
                $request->validated(), // ใช้ validated เพื่อรับเฉพาะข้อมูลที่ผ่าน validation
                [
                    'title' => $imageName,
                    'content' => $url_path,
                ]
            );

            $image_inserted[] = $this->postRepositoryInterface->store($postData);
        }
        return $image_inserted;

        // $image = $files[0];
        // $request->validate([
        //     'files' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
        // $response = [
        //     'data' => $images
        // ];

        // return $image_inserted;
    }

    private function handleRequest($request)
    {
        // ตรวจสอบ type และเรียกฟังก์ชันที่เหมาะสม
        if ($request->input('type') === 'attachment') {
            return $this->uploadMedia($request);
        }

        // ถ้าไม่ใช่ attachment ให้ทำการ store ข้อมูลปกติ
        return $this->postRepositoryInterface->store($request->validated());
    }
}
