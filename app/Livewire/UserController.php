<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserController extends Component
{

    public $search;
    public $role;
    public $roles = [];
    public $allUsersWithAllTheirRoles;

    public function mount()
    {
        // Obtener todos los nombres de roles y almacenarlos en la propiedad $roles


    }
        // $users = User::when($this->search,function ($query){
        //     $query->where('name','ilike','%'.$this->search.'%');
        // })->paginate(10);

    public function render()
    {
        $this->roles = Role::select('name')->get();


        // $role = User::role($this->role)->get();
        //  $users = User::search($this->search)->paginate(10);
        // // $users = User::role($this->role)->get();

        // return view('livewire.user-controller', ['users'=>$users,'roles'=>$this->role]);

   // Inicializar la consulta base
   $query = User::query();

   // Si hay un rol definido, filtrar por rol
   if ($this->role) {
       // Agregar el filtro de rol a la consulta
       $query->role($this->role);
   }

   // Si hay un término de búsqueda
   if ($this->search) {
       // Realizar la búsqueda en Meilisearch
       $searchResults = User::search($this->search)->get();

       // Filtrar los resultados de búsqueda según los usuarios que tienen el rol especificado
       $users = $searchResults->filter(function ($user) {
           return !$this->role || $user->hasRole($this->role);
       });

       // Ordenar los resultados filtrados por ID de menor a mayor
       $users = $users->sortBy('id'); // Ordena los resultados por el campo 'id'

       // Convertir la colección filtrada en una nueva colección para paginar
       $users = new \Illuminate\Pagination\LengthAwarePaginator(
           $users->forPage(1, 10), // Cambia el número de página según lo que necesites
           $users->count(),
           10,
           1, // Cambia el número de página aquí si necesitas
           ['path' => request()->url(), 'query' => request()->query()]
       );
   } else {
       // Si no hay término de búsqueda, paginar directamente la consulta
       $users = $query->orderBy('id')->paginate(10); // Asegúrate de ordenar por ID al paginar
   }

   return view('livewire.user-controller', [
       'users' => $users,
       'roles' => $this->role,
   ]);
    }
}
