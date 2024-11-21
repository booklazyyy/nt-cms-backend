<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function index(array $filters = [])
    {
        // $posts = Post::paginate();
        // if ($request->has('type')) {
        //     $type = $request->query('type');

        //     $order_by = $request->query('order_by', 'id');
        //     $order = $request->query('order', 'asc');
        //     $posts = Post::where([
        //         'type' => $type,
        //     ])
        //         ->orderBy($order_by, $order)
        //         ->paginate();
        // }

        // return $posts;
        $posts = new Post();
        // กรองตาม 'type' หากมีในคำขอ
        $published_posts_count = 0;
        $draft_posts_count = 0;
        if (isset($filters['type'])) {
            $posts = $posts->where('type', $filters['type']);
            // $published_posts_count = $posts->where('status', 'published')->count();
            $posts = new Post();
            $draft_posts_count = $posts->where('status', 'draft')->count();
        }

        // การจัดเรียงข้อมูลตาม 'order_by' และ 'order' หากมีในคำขอ
        $order_by = $filters['order_by'] ?? 'id';
        $order = $filters['order'] ?? 'asc';

        $posts->orderBy($order_by, $order);

        // ใช้การแบ่งหน้า
        return $posts->paginate();
    }

    public function getById($id)
    {
        return Post::findOrFail($id);
    }

    public function store(array $data)
    {
        return Post::create($data);
    }

    public function update(array $data, $id)
    {
        return Post::whereId($id)->update($data);
    }

    public function delete($id)
    {
        Post::destroy($id);
    }
}
