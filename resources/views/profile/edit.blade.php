<x-app-layout>
@section('header', 'Mon profil')

<div style="display:flex;flex-direction:column;gap:1.25rem;max-width:100%;">

    <div class="form-card">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="form-card">
        @include('profile.partials.update-password-form')
    </div>

    <div class="form-card" style="border-color:#FECACA;">
        @include('profile.partials.delete-user-form')
    </div>

</div>

@include('admin._form-styles')
@include('admin._table-styles')
</x-app-layout>
