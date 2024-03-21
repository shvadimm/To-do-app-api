<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\todos;
use App\Models\User;

class TodosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRetrieveSpecificTodo()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $todo = todos::create([
            'title' => 'Test Todo',
            'body' => 'This is a test todo.',
            'user_id' => $user->id,
        ]);

        $response = $this->get("/api/todos/{$todo->id}");

        $response->assertStatus(200)
            ->assertJson($todo->toArray());
    }
}