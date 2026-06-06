<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UniqueUsernameApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_unique_username_endpoint_api_forbidden()
    {
        $response = $this->call('GET',route('check_username_availablity'), [
            'username' => 'sabujdas94',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_unique_username_endpoint_api_can_be_access()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('Create Client');
        $response = $this->actingAs($user)->call('GET',route('check_username_availablity'), [
            'username' => 'sabujdas94',
        ]);
        $response->assertStatus(200);
    }
    public function test_unique_username_already_exits()
    {
        $client = Client::factory()->create(['branch_id' => 1]);

        $user = User::factory()->create(['branch_id' => 1]);
        $user->givePermissionTo('Create Client');

        $response = $this->actingAs($user)->call('GET',route('check_username_availablity'),[
            'username' => $client->username
        ]);
        $this->assertEquals('0', $response->getContent());
    }

    public function test_two_branch_can_have_same_user_name()
    {
        Model::unguard();

        $client1 = Client::factory()->create([
            'branch_id' => 1
        ]);

        $user = User::factory()->create(['branch_id' => 2]);

        $user->givePermissionTo('Create Client');
        $response = $this->actingAs($user)->call('GET',route('check_username_availablity'), [
            'username' => $client1->username,
        ]);
        $this->assertEquals('1', $response->getContent());
    }

}
