<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForum extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_unauthenticated_user_may_not_add_replies_to_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/channel/1/replies', []);
    }

    /**
     * @test
     */
    public function an_authenticated_user_may_add_replies_to_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

    /**
     * @test
     */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
