<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendMessageJob;
use App\Traits\SortByCreatedDate;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use SortByCreatedDate;

    protected $fillable = ['from', 'to', 'message'];

    public function messageFrom() {
    	return $this->belongsTo('App\Models\User', 'from')->select('id', 'name','profile_image');
    }

    public function messageTo() {
    	return $this->belongsTo('App\Models\User', 'to')->select('id', 'name','profile_image');
    }

    public function getMessages() {
    	$auth_user = auth()->user()->id;

    	$messages = Message::select('from', 'to')
                            ->where('messages.from' , $auth_user)
    						->orWhere('messages.to', $auth_user)
                            ->groupBy('from', 'to')
    						->get();

        $user_ids = array();
        foreach ($messages as $msg) {
            $user_id = array();
            if($auth_user !== $msg->from && !in_array($msg->from, $user_ids)) {
                $user_id = $msg->from;
                array_push($user_ids, $user_id);
            }else if($auth_user !== $msg->to && !in_array($msg->to, $user_ids)){
                $user_id = $msg->to;
                array_push($user_ids, $user_id);
            }
        }
        $outer_array = array();

        foreach ($user_ids as $user_id) {
            $inner_array = array();
            $user = (new User)->getUserById($user_id);
            $user->message = $this->getLastMessage($user_id);
            array_push($inner_array, $user);
            $outer_array = array_merge($outer_array, $inner_array);
        }
    	return $this->sortContacts($outer_array);
    }

    public function getLastMessage($userId) {
        $auth_user = auth()->user()->id;

        $message = Message::where([['from' , $auth_user], ['to', $userId]])
                            ->orWhere([['to', $auth_user],['from', $userId]])
                            ->orderBy('created_at', 'DESC')
                            ->first();
        return $message;
    }

    public function getUserMessage($userId) {
    	$auth_user = auth()->user()->id;

    	$messages = Message::where([['from' , $auth_user], ['to', $userId]])
    						->orWhere([['to', $auth_user],['from', $userId]])
    						->get();
    	return $messages;
    }

    public function sendMessage($message, $userId) {
    	$message = Message::create([
    		'from'	=> auth()->user()->id,
    		'to'	=> $userId,
    		'message'	=> trim($message)
    	]);

        $job = (new SendMessageJob($message))
                ->delay(Carbon::now()->addSeconds(5));
  
        dispatch($job);

    	return $message;
    }
}
