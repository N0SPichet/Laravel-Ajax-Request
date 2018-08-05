<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Like;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('users.dashboard')->with('posts', $posts);
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
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = new Post;
        $post->body = $request->body;
        $message = 'There was an error';
        if ($request->user()->posts()->save($post)) {
            $message = 'Post successfully created';
        }
        return redirect()->route('posts.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = Post::find($request->id);
        if ($post->user_id == Auth::user()->id) {
            $post->body = $request->body;
            $post->save();
        }
        return response()->json(['new_body' => $post->body], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $post = Post::find($id);
        if ($post->user_id == Auth::user()->id) {
            $post->delete();
            return redirect()->route('posts.index')->with('message', 'Post successfully deleted!');
        }
        return redirect()->back();
    }

    public function postLike(Request $request)
    {
        $post_id = $request->id;
        $post = Post::find($post_id);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();        
        if ($like) {
            if ($like->like == true) {
                $like->delete();
                return response()->json(['msg' => 'unliked'], 200);
            }
        } else {
            $like = new Like;
            $like->like = true;
            $like->user_id = $user->id;
            $like->post_id = $post->id;
            $like->save();
            return response()->json(['msg' => 'liked'], 200);
        }
    }
}
