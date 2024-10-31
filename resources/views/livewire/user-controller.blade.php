<div>


<div class=" flex items-center space-x-4">
    <div class=" flex items-center space-x-4">
        <p class="text-white">Serach</p>
        <input type="text" class="my-5" wire:model.live="search">
    </div>

    <div class=" flex items-center">
        <label for="mainSelect" class="text-white">Filtro:</label>
    <select wire:model.live="role">
        <option value="">Seleccione</option>
        @foreach ($roles as $rol)
            <option key="{{$rol->id}}" value="{{$rol->name}}">{{$rol->name}}</option>
        @endforeach
    </select>
    </div>


</div>

<div class="relative overflow-x-auto pt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

            <tr>
                <th scope="col" class="px-6 py-3">
                    Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Roles
                </th>

            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$user->id}}
                </th>
                <td class="px-6 py-4">
                    {{ $user->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4">
                    {{ implode(', ', $user->getRoleNames()->toArray()) }} <!-- Mostrar roles -->
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

    <div class="pt-4">
        {{ $users->links() }}
    </div>


</div>
