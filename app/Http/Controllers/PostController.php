<?php

namespace App\Http\Controllers;

use App\Post;
use App\Profile;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //所有帖子
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return json_encode(["posts" => $posts, "status" => "true"]);
    }

    //当前用户的帖子
    public  function userPost(Request $request)
    {
        $userId = $request->get('userId');
        $user = User::find($userId);
        $posts = $user->posts;
        return json_encode(["posts" => $posts, "status" => "true"]);
    }


    //用户创建帖子
    public function store(Request $request)
    {
        $newPost = Post::create($request->get('post'));
        $post = Post::with('user')->find($newPost->id);
        return json_encode(["post" => $post, "status" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy($post)
    {
        $post = Post::find($post);
        $post->delete();
        return json_encode(["status" => true]);
    }

    public function userPostDelete($post)
    {
        $post = Post::find($post);
        $post->delete();
        return json_encode(["status" => true]);
    }
}
