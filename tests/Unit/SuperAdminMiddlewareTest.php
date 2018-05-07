<?php

namespace Tests\Unit;

use App\Http\Middleware\SuperAdminMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\User;
class SuperAdminMiddlewareTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function non_super_admins_are_redirected()
    {
        $user = factory(User::class)->make(['is_super_admin' => false]);

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new SuperAdminMiddleware;

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals($response->getStatusCode(), 302);
    }


    /** @test */
    public function super_admins_are_not_redirected()
    {
        $user = factory(User::class)->make(['is_super_admin' => true]);

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new SuperAdminMiddleware;

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response, null);
    }

}

