
@extends('layouts.app')

@section('title','Kasutajad')

@section('content')
<div class="container my-4">
    <h1 class="h4 mb-3">Kasutajad</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nimi</th>
                        <th>E-post</th>
                        <th>Viimane sisse</th>
                        <th>Peab parooli muutma</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->last_login_method ? ucfirst($user->last_login_method) : '-' }}
                            <br>
                            <small class="text-muted">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '-' }}</small>
                        </td>
                        <td>
                            @if($user->must_change_password)
                                <span class="badge bg-warning text-dark">Jah</span>
                            @else
                                <span class="badge bg-secondary">Ei</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Kustutada kasutaja {{ addslashes($user->email) }}?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Kustuta</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-3">Kasutajaid ei leitud.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection