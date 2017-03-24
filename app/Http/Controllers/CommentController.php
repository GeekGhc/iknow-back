<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index($commentId)
    {
        $comment = Comment::with(['user','toUser'])->find($commentId);
        dd($comment->toUser->name);
    }

    //帖子的所有评论
    public function postComments($postId)
    {
        $post = Post::find($postId);
        $commentsId = $post->comments->pluck('id')->toArray();
        $comments = Comment::with(['user','toUser'])->find($commentsId);
        return json_encode(["comments" => $comments, "status" => "true"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newComment = $request->get('comment');
        $newComment = Comment::create($newComment);
        $post = Post::find($newComment['post_id']);
        $post->comment_count++;
        $post->save();
        $comment = Comment::with(['user','toUser'])->find($newComment->id);
        return json_encode(["comment" => $comment, "status" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
