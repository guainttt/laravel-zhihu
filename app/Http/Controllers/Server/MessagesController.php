<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MessageRepository;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     *	私信仓库
     */
    protected $message;
    
    /**
     *  初始化
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }
    /**
     *	访客发送私信
     */
    public function store(Request $request)
    {
        $message = $this->message->CreateMessage([
          'to_user_id' => $request->get('user'),
          'from_user_id' => Auth::guard('api')->user()->id,
          'body' => $request->get('body'),
          'dialog_id' => ''
        ]);
        
        return $message ?
          response()->json(['status'=>true]) :
          response()->json(['status'=>false]);
    }
}
