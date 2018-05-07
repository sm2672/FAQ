<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\MemberMiddleware;
use Illuminate\Http\Request;
use App\User;

class MemberMiddlewareTestMiddlewareTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function Members_are_redirected()
    {
        $user = factory(User::class)->make(['is_admin' => false]);

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new MemberMiddleware;

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals($response->getStatusCode(), 302);
    }


    /** @test */
    public function members_are_not_redirected()
    {
        $user = factory(User::class)->make(['is_admin' => true]);

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new MemberMiddleware;

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response, null);
    }

}

