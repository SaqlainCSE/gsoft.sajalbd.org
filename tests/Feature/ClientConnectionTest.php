<?php

namespace Tests\Feature;

use App\Events\ClientPackageChanged;
use App\Events\EnableClient;
use App\Events\TerminateClient;
use App\Models\Client;
use App\Models\MkCon;
use App\Models\Package;
use App\Models\User;
use App\Services\Mikrotik;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;

class ClientConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_client_package()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('Edit Client');
        $this->actingAs($user);

        $mkCon = MkCon::factory()->create();

        $package = Package::factory()->create([
            'mk_con_id' => $mkCon->id
        ]);

        $client = Client::factory()->create([
            'mk_con_id' => $mkCon->id,
            'branch_id' => $user->branch_id,
        ]);

        $this->mock(Mikrotik::class, function (MockInterface $mock) use ($client) {
            $mock->shouldReceive('changeClientPackage')->once()->andReturn(true);
        });
        Event::fake();
        $response = $this->actingAs($user)->post(route('client-change-package-store'),[
            'client_id' => $client->uuid,
            'package_id' => $package->id,
            'this_month_bill' => 'no_bill',
            'comment' => 'string',
        ]);
        Event::assertDispatched(ClientPackageChanged::class);
        $this->assertDatabaseHas('clients', [
            'package_id' => $package->id,
        ]);
        $response->assertRedirect(route('client.show', $client->uuid));
    }

    public function test_enable_client_in_mikrotik()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('Edit Client');
        $this->actingAs($user);

        $client = Client::factory()->create([
            'branch_id' => $user->branch_id,
        ]);

        $this->mock(Mikrotik::class, function (MockInterface $mock) use ($client) {
            $mock->shouldReceive('changeClientStatus')->once()->andReturn(true);
        });
        Event::fake();
        $response = $this->actingAs($user)->post(route('enable'), [
            'clientId' => $client->uuid
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', ['status' => 1]);
        Event::assertDispatched(EnableClient::class);
    }
    public function test_disable_client_in_mikrotik()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('Edit Client');
        $this->actingAs($user);

        $client = Client::factory()->create([
            'branch_id' => $user->branch_id,
        ]);

        $this->mock(Mikrotik::class, function (MockInterface $mock) use ($client) {
            $mock->shouldReceive('changeClientStatus')->once()->andReturn(true);
        });
        Event::fake();
        $response = $this->actingAs($user)->post(route('terminate'), [
            'clientId' => $client->uuid,
            'message' => 'Terminate message'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', ['status' => 0]);
        Event::assertDispatched(TerminateClient::class);
    }
}

