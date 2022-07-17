<x-main-layout>
    <div class="container">
        <div>
            <h2>{{ $stream->title }}</h2>
            <p>{{ $stream->description }}</p>
        </div>
        <div>
            @if($broadcast_obj['status'] && $broadcast_obj['broadcast_url'])
                <h3>{{ $broadcast_obj['data']->username }}</h3>
                <div>
                    <iframe width="560" height="315" src="{{ $broadcast_obj['broadcast_url'] . $stream->stream_id }}" frameborder="0" allowfullscreen></iframe>
                </div>
            @else
                <div>
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($stream->preview) }}" alt="{{ $stream->title }}">
                </div>
            @endif
        </div>
    </div>
</x-main-layout>
