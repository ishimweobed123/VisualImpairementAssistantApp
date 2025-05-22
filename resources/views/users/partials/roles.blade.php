{{-- filepath: resources/views/users/partials/roles.blade.php --}}
<div>
    <label for="roles">Roles</label>
    <select name="roles[]" id="roles" multiple required>
        @foreach($roles as $role)
            <option value="{{ $role->name }}" @if($user->roles->pluck('name')->contains($role->name)) selected @endif>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
</div>
