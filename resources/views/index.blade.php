<x-main-layout>
    <div class="row">
        @foreach($streams as $item)
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{ \Illuminate\Support\Facades\Storage::url($item->preview) }}" alt="{{ $item->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <a href="{{ route('stream.show', $item->id) }}" class="btn btn-primary">See</a>
                </div>
            </div>
        @endforeach
    </div>
</x-main-layout>
