<x-main-layout>
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h2>Your password for stream</h2>
        <form method="POST" action="{{ route('check-stream-password', $stream_id) }}">
            @csrf

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                @if($errors->has('password'))
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->get('password') as $err)
                            {{ $err }}
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>

    </div>
</x-main-layout>
