<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Trait IssueToken
 *
 * @package App\Trait
 */

trait IssueToken
{

    public function issueToken(Request $request, $grant_type, $scope = '*')
    {
        $params = [
            'grant_type'    => $grant_type,
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'username'      => $request->username,
            'password'      => $request->password,
            'scope'         => $scope,
        ];
        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }
}
