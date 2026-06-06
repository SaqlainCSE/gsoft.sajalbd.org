<?php

namespace App\Observers;

use App\Models\Client;

class ClientObserver
{
    public function creating(Client $client)
    {
        // $client->client_no = get_generate_client_no();
    }
}
