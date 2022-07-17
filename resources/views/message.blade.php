<x-main-layout>
    <div class="row">
        @if(session('site_message'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>{{ session('site_message') }}</strong>
            </div>
        @endif
    </div>
</x-main-layout>
