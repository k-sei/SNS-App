<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Talkroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $my_id = Auth::id();
        $talkroom = Talkroom::find(1);
        $messages = Message::where('talkroom_id', '=', 1)->orderBy('created_at')->get();

        return view('message', compact('my_id','talkroom', 'messages'));
    }
    public function send(Request $request)
    {
        /* バリデーション */
        $request->validate([
            'content' => 'required|max:1024'
        ]);

        $message_table = new Message();
        $message_table->content = $request->content;
        $message_table->user_id = $request->user_id;
        $message_table->talkroom_id = $request->talkroom_id;

        /* データベースにレコードを追加する */
        $message_table->save();

        return redirect('/message');
    }

}
