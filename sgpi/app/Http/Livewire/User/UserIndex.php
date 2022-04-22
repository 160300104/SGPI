<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public $search;
    
    protected $paginationTheme = "bootstrap";


    public function render()
    {
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
        ->orWhere('email', 'LIKE', '%' . $this->search . '%')
        ->paginate();
        return view('livewire.user.user-index', compact('users'));
    }
}
