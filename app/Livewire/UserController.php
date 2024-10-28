<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserController extends Component
{
    public $search;

    public function render()
    {
        // $users = User::when($this->search,function ($query){
        //     $query->where('name','ilike','%'.$this->search.'%');
        // })->paginate(10);

        $users = User::search($this->search)->paginate(10);
        return view('livewire.user-controller', compact('users'));
    }
}
