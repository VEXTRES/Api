<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserController extends Component
{
    public function render()
    {
        $users = User::paginate(10);
        return view('livewire.user-controller', compact('users'));
    }
}
