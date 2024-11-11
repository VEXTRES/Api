<h1>Hola</h1>
@foreach ($data as $user)
    <h2>{{ $user->name }}</h2>
    <p>{{ $user->email }}</p>
    <p>{{ $user->getRoleNames()->first() }}</p>
@endforeach
