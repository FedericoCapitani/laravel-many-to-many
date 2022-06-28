<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Mail\NewPostCreated;
use App\Mail\PostUpdatedAdminMessage;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentuser = Auth::id();
        $posts = Post::where('user_id', '=', $currentuser)->get()->sortDesc();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //dd($request->all());
        $validate_data = $request->validated();
        $validate_data['slug'] = Str::slug($request->title);
        $validate_data['user_id'] = Auth::id();

        if($request->hasFile('cover_image')){
            //validation
            $request->validate([
                'cover_image' => 'nullable|image|max:500'
            ]);
            //save
            //take path
            $path = Storage::put('post_images', $request->cover_image);


            //pass the path of array
            $val_data['cover_image'] = $path ;

        };

        $new_post = Post::create($validate_data);
        $new_post->tags()->attach($request->tags);
        Mail::to($request->user())->send(new NewPostCreated($new_post));
        return redirect()->route('admin.posts.index')->with('status', 'Post Create SuccessFull');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $validate_data = $request->validated();
        $validate_data['slug'] = Str::slug($request->title);

        if($request->hasFile('cover_image')){
            //validation
            $request->validate([
                'cover_image' => 'nullable|image|max:500'
            ]);
            //save
            Storage::delete($post->cover_image);
            //take path
            $path = Storage::put('post_images', $request->cover_image);


            //pass the path of array
            $val_data['cover_image'] = $path ;

        };

        $post->update($validate_data);
        $post->tags()->sync($request->tags);
        Mail::to('admin@boolpress.it')->send(new PostUpdatedAdminMessage($post));
        return (new PostUpdatedAdminMessage($post))->render();
        return redirect()->route('admin.posts.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Storage::delete($post->cover_image);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('status', 'Post Delete SuccessFull');
    }
}