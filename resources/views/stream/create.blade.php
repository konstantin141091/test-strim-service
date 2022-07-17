<x-main-layout>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h2>Create new Stream</h2>
        <form method="POST" action="{{ route('stream.store') }}" enctype="multipart/form-data">
            @csrf

            @include('admin._form_components._input_text_create', [
                'input_name' => 'title',
                'input_title' => 'Title Text',
            ])

            @include('admin._form_components._textarea_create', [
                'input_name' => 'description',
                'input_title' => 'Description Text',
            ])

            <div class="form-group">
                <label for="preview_image">Preview image</label>
                <input type="file" class="form-control-file" id="preview_image" name="preview">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Создать</button>
            </div>
        </form>

    </div>
</x-main-layout>
