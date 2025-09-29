<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Models\BlogComment;

class AdminCommentController extends Controller
{
    /**
     * Display a listing of all blog comments with their associated blog post.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Eager load the 'blog' relationship
        $comments = BlogComment::with('blog')->latest()->paginate(20);

        return view('dashboard.comments.index', compact('comments'));
    }

    /**
     * Remove the specified comment from storage (Delete Comments).
     *
     * @param  \App\Models\BlogComment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BlogComment $comment)
    {
        $comment->delete();

        Session::flash('success', 'Comment successfully deleted!');
        return redirect()->route('dashboard.comments.index');
    }
}