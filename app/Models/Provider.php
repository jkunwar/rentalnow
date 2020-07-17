<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'user_id', 'username', 'password', 'email', 'phone_number', 'token', 'provider'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       'password', 'username',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function findByUsername($request) {
        return Provider::where([['username', $request->username], ['provider', $request->provider]])
                        ->join('users', 'providers.user_id', 'users.id')
                        ->first();
    }

    public function storeProvider($request, $userId) {
        $provider = $this->ifProviderExists($request->provider, $userId);
        if(!$provider) {
            $provider = new Provider;
            $provider->user_id = $userId;
            $provider->token = $request->token;
            $provider->provider = $request->provider;
            $provider->username = $request->username;
            $provider->password = bcrypt($request->password);
            if(isset($request->email)){
                $provider->email = $request->email;
            }
            if(isset($request->phone_number)) {
                $provider->phone_number = $request->phone_number;
            }
            $provider->save();
        }else {
            $provider->token = $request->token;
            if($request->email) {
                $provider->email = $request->email;
            }
            if($request->phone_number) {
                $provider->phone_number = $request->phone_number;
            }
            $provider->save();
        }
        return $provider;
    }

    public function ifProviderExists($provider, $userId) {
        return Provider::where([['user_id', $userId],['provider', $provider]])->first();
    }

    public function updateEmailPhone($data) {
        $provider = Provider::where('user_id', auth()->user()->id)->first();
        if($provider) {
            if($data->email) {
                $provider->email = $data->email;
            }
            if($data->phone_number) {
                $provider->phone_number = $data->phone_number;
            }
            $provider->save();
        }
    }
}
