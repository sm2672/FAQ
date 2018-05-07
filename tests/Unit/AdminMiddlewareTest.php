<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use App\User;
class AdminMiddlewareTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function non_admins_are_redirected()
    {
        $user = factory(User::class)->make(['is_admin' => false]);

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new AdminMiddleware;

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals($response->getStatusCode(), 302);
    }


/** @test */
public function admins_are_not_redirected()
{
    $user = factory(User::class)->make(['is_admin' => true]);

    $this->actingAs($user);

    $request = Request::create('/admin', 'GET');

    $middleware = new AdminMiddleware;

    $response = $middleware->handle($request, function () {});

    $this->assertEquals($response, null);
}

}

