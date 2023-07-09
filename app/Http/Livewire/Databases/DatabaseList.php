<?php

namespace App\Http\Livewire\Databases;

use App\Actions\Database\CreateDatabase;
use App\Actions\Database\CreateDatabaseUser;
use App\Models\Database;
use App\Models\Server;
use App\Traits\RefreshComponentOnBroadcast;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DatabaseList extends Component
{
    use RefreshComponentOnBroadcast;

    public Server $server;

    public int $deleteId;

    public string $name;

    public bool $user;

    public string $username;

    public string $password;

    public bool $remote = false;

    public string $host = '%';

    public function create(): void
    {
        app(CreateDatabase::class)->create($this->server, $this->all());

        if ($this->all()['user']) {
            app(CreateDatabaseUser::class)->create($this->server, $this->all());
        }

        $this->refreshComponent([]);

        $this->dispatchBrowserEvent('database-created', true);
    }

    public function delete(): void
    {
        $database = Database::query()->findOrFail($this->deleteId);

        $database->deleteFromServer();

        $this->refreshComponent([]);

        $this->emitTo(DatabaseUserList::class, '$refresh');

        $this->dispatchBrowserEvent('confirmed', true);
    }

    public function render(): View
    {
        return view('livewire.databases.database-list', [
            'databases' => $this->server->databases,
        ]);
    }
}