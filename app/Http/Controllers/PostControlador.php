<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;

class PostControlador extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return view('index', compact(['posts']));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $path = $request->file('arquivo')->store('imagens', 'public');

        $post = new Post();
        $post->email = $request->input('email');
        $post->mensagem = $request->input('mensagem');
        $post->arquivo = $path;
        $post->save();
        return redirect('/');
    }

    public function download($id)
    {
        $post = Post::find($id);
        if (isset($post)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($post->arquivo);
            return response()->download($path);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $post = Post::find($id);
        if (isset($post)){
            $arquivo = $post->arquivo;
            Storage::disk('public')->delete($arquivo);
            $post->delete();
        }
        return redirect('/');
    }
}
