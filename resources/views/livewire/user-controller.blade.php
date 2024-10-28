
    <div>

        <div>
            @foreach ($users as $user)

                <p>{{ $user->name }}</p>

            @endforeach
        </div>
        {{ $users->links() }}


    </div>

