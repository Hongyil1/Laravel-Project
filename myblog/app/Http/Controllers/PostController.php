<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   // except to ensure only the login user can edit and delete
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Load the view
        // $posts = Post::all();
        // $posts = Post::orderBy('title','desc')->take(2)->get();
        // $post = Post::where('title', 'Post two')->get();
        // $posts = DB::select('SELECT * FROM posts');
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
        // return view('posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set the validation rules. title and body is required.
        $this->validate($request, [
            'title'=> 'required',
            'body'=> 'required',
            'cover_image' => 'image|nullable|max:1999',
        ]);

        // handle file uplaod
        if($request->hasFile('cover_image')){
          // Get filename with the extension
          $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
          // get just filename
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          // get just ext
          $extension = $request->file('cover_image')->getClientOriginalExtension();
          // Filename to Store
          $fileNameToStore = $filename.'_'.time().'_'.$extension;
          // Upload Image
          $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }else {
           $fileNameToStore = 'noimage.jpg';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // Get the currently authenticated user...
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
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
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // Check for correct use
        if(auth()->user()->id !== $post->user_id){
          return redirect('/posts')->with('error', 'Unauthorized Pages');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      // handle file uplaod
      if($request->hasFile('cover_image')){

        //Delete the previous image
        $post = Post::find($id);
        Storage::delete('public/cover_images/'.$post->cover_image);

        // Get filename with the extension
        $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
        // get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // get just ext
        $extension = $request->file('cover_image')->getClientOriginalExtension();
        // Filename to Store
        $fileNameToStore = $filename.'_'.time().'_'.$extension;
        // Upload Image
        $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
      }
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
          $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::find($id);

      // Check for correct use
      if(auth()->user()->id !== $post->user_id){
        return redirect('/posts')->with('error', 'Unauthorized Pages');
      }

      if($post->cover_image != 'noimage.jpg'){
          // Delete image
          Storage::delete('public/cover_images/'.$post->cover_image);
      }

      $post->delete();
      return redirect('/posts')->with('success', 'Post Romoved');
    }
}
