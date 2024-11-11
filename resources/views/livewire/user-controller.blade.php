<div>
    <div class="flex w-full justify-between pt-3">
        <div class="flex items-center space-x-6">
            <p class="text-white">Search</p>
            <input class="my-5" type="text" wire:model.live="search">
        </div>

        <div class="flex items-center">
            <label class="text-white" for="mainSelect">Filtro:</label>
            <select wire:model.live="role">
                <option value="">Seleccione</option>
                @foreach ($roles as $key => $rol)
                    <option value="{{ $rol }}" key="{{ $key }}">{{ $rol }}</option>
                @endforeach
            </select>
        </div>
        <div class="ml-auto mr-3 flex gap-2">
            <button class="rounded bg-white px-4 py-2 font-bold text-black hover:bg-gray-200"
                wire:click="descargarArchivo(1)">Excel</button>
            <button class="rounded bg-white px-4 py-2 font-bold text-black hover:bg-gray-200"
                wire:click="descargarArchivo(2)">PDF</button>
            <a class="rounded bg-white px-4 py-2 font-bold text-black hover:bg-gray-200" href ="/pdf"
                target="_blank">PDF Chrome</a>

        </div>


    </div>

    @if (session('success'))
        <div class="fixed right-4 top-4 rounded bg-green-500 px-4 py-2 text-white shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative mt-8 overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">

                <tr>
                    <th class="px-6 py-3" scope="col">
                        <span>Id </span>

                    </th>
                    <th class="flex items-center space-x-2 px-6 py-3" scope="col">
                        <span>Name </span>
                        <button class="rounded-sm bg-gray-200 p-1 text-sm text-black"
                            wire:click="setOrder(field='name')">
                            @if ($sortOrder == 'asc')
                                <p>Asc</p>
                            @elseif($sortOrder == 'desc')
                                <p>Desc</p>
                            @elseif($sortOrder == null)
                                <p>No ordenar</p>
                            @endif
                        </button>

                    </th>
                    <th class="cursor-pointer px-6 py-3" scope="col" wire:click="setOrder('email')">
                        <span>Email </span>

                        {{ $sortField == 'email' ? ($sortOrder == 'asc' ? '▲' : ($sortOrder == 'desc' ? '▼' : '')) : '' }}

                    </th>
                    <th class="px-6 py-3" scope="col">
                        Roles
                        <button class="rounded-sm bg-gray-200 p-1 text-sm text-black"
                            wire:click="setOrder(field='role')">
                            @if ($sortOrder == 'asc')
                                <p>Asc</p>
                            @elseif($sortOrder == 'desc')
                                <p>Desc</p>
                            @elseif($sortOrder == null)
                                <p>No ordenar</p>
                            @endif
                        </button>
                    </th>
                    <th class="px-6 py-3" scope="col">
                        Correo
                    </th>

                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                        <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                            scope="row">
                            {{ $user->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->getRoleNames()->first() }} <!-- Mostrar roles -->
                        </td>
                        <td class="disabled:disble px-6 py-4" ">
                    <button class="rounded-md bg-gray-400 p-2 text-white" wire:click="enviarCorreo({{ $user->id }})" wire:loading.attr="disabled">
                        Enviar correo
                    </button>
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
