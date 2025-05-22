{{-- filepath: resources/views/users/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit User</h2>
    </x-slot>
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required>
        </div>
        @if(!empty($roles))
            @include('users.partials.roles', ['roles' => $roles, 'user' => $user])
        @endif
        <button type="submit">Update</button>
    </form>
</x-app-layout>