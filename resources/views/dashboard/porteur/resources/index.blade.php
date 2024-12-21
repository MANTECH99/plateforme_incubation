<x-app-layout>
    <h1>Ressources</h1>
    <ul>
        @foreach ($resources as $resource)
            <li>
                <a href="{{ $resource->url }}" target="_blank">{{ $resource->title }}</a> ({{ $resource->type }})
            </li>
        @endforeach
    </ul>
</x-app-layout>
