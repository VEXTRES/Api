<div x-data="{
    show: false,
    pause() {
        this.show = true;
        setTimeout(() => this.show = false, 3000);
    }
}">
    <div class="flex items-center pt-3">
        <div class="flex items-center space-x-6">
            <p class="text-white">Search</p>
            <input type="text" class="my-5" wire:model.live="search">
        </div>

        <div class="flex items-center">
            <label for="mainSelect" class="text-white">Filtro:</label>
            <select wire:model.live="role">
                <option value="">Seleccione</option>
                @foreach ($roles as $key => $rol)
                    <option key="{{$key}}" value="{{$rol}}">{{$rol}}</option>
                @endforeach
            </select>
        </div>


    </div>


    @if (session()->has('success'))
        <div
            x-show="show"
            class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg"
        >
            {{session('success')}}
        </div>
    @endif

<div class="relative overflow-x-auto mt-8">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

            <tr>
                <th scope="col" class="px-6 py-3">
                    <span>Id </span>

                </th>
                <th scope="col" class="px-6 py-3 flex items-center space-x-2">
                <span>Name </span>
                <button wire:click="setOrder(field='name')" class="text-sm bg-gray-200 rounded-sm p-1 text-black ">
                    @if ($sortOrder == 'asc')
                        <p>Asc</p>
                    @elseif($sortOrder == 'desc')
                        <p>Desc</p>
                    @elseif($sortOrder == null)
                        <p>No ordenar</p>
                    @endif
                </button>

            </th>
                <th scope="col" class="px-6 py-3">
                    <span>Email </span>

                </th>
                <th scope="col" class="px-6 py-3">
                    Roles
                </th>
                <th scope="col" class="px-6 py-3">
                    Correo
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
                    {{ $user->getRoleNames()->first() }} <!-- Mostrar roles -->
                </td>
                <td class="px-6 py-4 disabled:disble" ">
                    <button
                        class="bg-gray-400 p-2 rounded-md text-white"
                        wire:click="enviarCorreo({{ $user->id }})"
                        x-on:click="pause()"
                        x-bind:disabled="show"
                        x-bind:class="{'opacity-50 cursor-not-allowed': show}"
                        >
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
