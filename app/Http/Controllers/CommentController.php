<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Topic;
use App\Task;
use App\Comment;

class CommentController extends Controller
{
    public function store_topic(Topic $topic, Request $request)
    {
    	$this->store($topic, $request);
    	return redirect()->back();
    }

    public function store_task(Task $task, Request $request)
    {
    	$this->store($task, $request);
    	return redirect()->back();
    }

    private function store($commentable, Request $request)
    {
    	$request->validate(['comment' => 'required']);
    	$comment = new Comment();
    	$comment->author = Auth::id();
    	$comment->text = $request->comment;

    	$commentable->comments()->save($comment);
    }

    public function edit(Comment $comment, Request $request)
    {
        if(!$comment->canEdit()) return redirect()->back();
        
        if(session('errors'))
        {
            session()->keep('prev');
        }
        else
        {
            session()->flash('prev', url()->previous());
        }

        return view('comments.edit')
                ->with(compact('comment'));
    }

    public function update(Comment $comment, Request $request)
    {
        if($comment->canEdit())
        {
            session()->keep('prev');
            $request->validate(['comment' => 'required']);
            $comment->text = $request->comment;
            $comment->save();
        }

        return redirect(session('prev'));
    }
}
