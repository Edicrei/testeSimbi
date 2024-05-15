<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response; // Import the Response class
use Illuminate\Http\Request;

use App\Models\Post; 

class PostController extends Controller
{
   //get data
   public function index()
   {
       $posts = Post::all(); // Retrieve all posts from the database
       return response()->json($posts, Response::HTTP_OK); // Return the data as JSON
   }

   //post
   public function store(Request $request)
   {
       $validatedData = $request->validate([
           'nome' => 'required|max:255',
           'segmento' => 'required',
       ]);

       // Create a new Post instance with the validated data
       $post = new Post([
           'nome' => $validatedData['nome'],
           'segmento' => $validatedData['segmento'],
       ]);

       $post->save(); // Save the new post to the database

       return response()->json($post, Response::HTTP_CREATED); // Return the new post as JSON
   }

   //delete
   public function destroy($id)
   {
       $post = Post::find($id);

       if (!$post) {
           return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
       }

       $post->delete();
       return response()->json(['message' => 'Post deleted'], Response::HTTP_OK);
   }
}
