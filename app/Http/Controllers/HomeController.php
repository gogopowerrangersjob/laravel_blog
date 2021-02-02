<?php

namespace App\Http\Controllers;

use App\Page;
use App\Category;
use App\Tag;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class HomeController extends Controller
{
    public function index()
    {
    	$posts = Post::where('status', 1)->paginate(2);
        
    	return view('pages.index')->with('posts', $posts);
    }

    public function show($slug) {
    	$post = Post::where('slug', $slug)->firstOrFail();
    	return view('pages.show', compact('post'));
    }

    public function tag($slug) {
    	$tag = Tag::where('slug', $slug)->firstOrFail();
    	$posts = $tag->posts()->paginate(2);
    	return view('pages.list', ['posts' => $posts]);
    }

    public function category($slug) {
        /*$cat = Category::find(1)->posts;*/
        /*$cats = Category::with('posts')->orderBy('id', 'desc')->get()->take(1);
        dd($cats);
        foreach($cats as $cat){
            echo $cat->posts; 
        }*/
    	$category = Category::where('slug', $slug)->firstOrFail();
    	$posts = $category->posts()->paginate(2);
    	return view('pages.list', ['posts' => $posts]);
    }

    public function page($slug) {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('pages.page', compact('page'));
    }
}
