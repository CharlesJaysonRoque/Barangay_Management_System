@extends('index')

@section('content')
<div class="admin-layout">
    <div class="admin-content">
        @yield('adminContent')
    </div>
</div>
<style>
    .admin-layout {
        display: flex;
        flex-direction: column;
    }

    /* If you actually need sidebar later, this already supports md-row behavior */
    @media (min-width: 768px) {
        .admin-layout {
            flex-direction: row;
        }
    }

    /* replaces "container p-6" */
    .admin-content {
        width: 100%;
        padding: 1.5rem; /* same as p-6 */
        max-width: 1200px;
        margin: 0 auto; /* same feel as container */
    }
</style>
@endsection
