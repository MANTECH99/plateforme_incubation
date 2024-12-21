<x-app-layout>
    <h1>Modifier une Ressource</h1>

    <form action="{{ route('resources.update', $resource->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" value="{{ $resource->title }}" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description">{{ $resource->description }}</textarea>

        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <option value="document" {{ $resource->type == 'document' ? 'selected' : '' }}>Document</option>
            <option value="formation" {{ $resource->type == 'formation' ? 'selected' : '' }}>Formation</option>
            <option value="outil" {{ $resource->type == 'outil' ? 'selected' : '' }}>Outil</option>
        </select>

        <label for="file">Fichier (optionnel) :</label>
        <input type="file" name="file" id="file">

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</x-app-layout>
