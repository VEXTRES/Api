<?php

namespace App\Livewire;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserController extends Component
{

    public $search;
    public $role;
    public $roles = [];
    public $sortOrder = 'asc';
    public $sortField = 'name';


    public function mount()
    {
        // Obtener todos los nombres de roles y almacenarlos en la propiedad $roles
        $this->roles = Role::orderBy('name')->pluck('name', 'id');
    }
    // $users = User::when($this->search,function ($query){
    //     $query->where('name','ilike','%'.$this->search.'%');
    // })->paginate(10);
    public function enviarCorreo($id)
    {
        $user = User::find($id);
        $user->notify(new UserNotification($user));
        session()->flash('success', '¡Correo enviado con éxito!');
    }
    public function setOrder($field)
    {
        $this->sortField = $field;

        if ($this->sortOrder == null) {
            $this->sortOrder = 'asc';
        } else if ($this->sortOrder == 'asc') {
            $this->sortOrder = 'desc';
        } else if ($this->sortOrder == 'desc') {
            $this->sortOrder = null;
        }
    }

    public function export()
    {
        // $path=storage_path('app/public/saves/users.xlsx');
        // Excel::store(new UsersExport, $path, 'local');
        // return session()->flash('success', 'Excel Guardado');

        return Excel::download(new UsersExport, 'users.xlsx');
        session()->flash('success', 'Excel Guardado');
    }
    public function render()
    {

        // Log::info($this->roles);
        $users = User::search($this->search, function ($meilisearch, $query, $options) {

            if ($this->role) {
                $options['filter'][] = 'role = "' . $this->role . '"';
            }

            if ($this->sortOrder != null) {
                $options['sort'] = [$this->sortField . ':' . $this->sortOrder];
            }

            return $meilisearch->search($query, $options);
        })->paginate(10);

        return view('livewire.user-controller', [
            'users' => $users,
        ]);
    }
}

//    // Inicializar la consulta base
//
//    $query = User::query();

//    // Si hay un rol definido, filtrar por rol
//    if ($this->role) {
//        // Agregar el filtro de rol a la consulta
//        $query->role($this->role);
//    }

//    // Si hay un término de búsqueda
//    if ($this->search) {
//        // Realizar la búsqueda en Meilisearch
//        $searchResults = User::search($this->search)->get();

//        // Filtrar los resultados de búsqueda según los usuarios que tienen el rol especificado
//        $users = $searchResults->filter(function ($user) {
//            return !$this->role || $user->hasRole($this->role);
//        });

//        // Ordenar los resultados filtrados por ID de menor a mayor
//        $users = $users->sortBy('id'); // Ordena los resultados por el campo 'id'

//        // Convertir la colección filtrada en una nueva colección para paginar
//        $users = new \Illuminate\Pagination\LengthAwarePaginator(
//            $users->forPage(1, 10), // Cambia el número de página según lo que necesites
//            $users->count(),
//            10,
//            1, // Cambia el número de página aquí si necesitas
//            ['path' => request()->url(), 'query' => request()->query()]
//        );
//    } else {
//        // Si no hay término de búsqueda, paginar directamente la consulta
//        $users = $query->orderBy('id')->paginate(10); // Asegúrate de ordenar por ID al paginar
//    }
