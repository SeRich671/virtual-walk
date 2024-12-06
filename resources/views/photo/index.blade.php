<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Photos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800">Project {{ $project->name }} -> Photos</h3>
                <a href="{{ route('project.photo.create', $project) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                    Add Photo
                </a>
            </div>

            @if ($photos->isEmpty())
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <p class="text-gray-700 text-lg">No photos available.</p>
                    <a href="{{ route('project.photo.create', $project) }}"
                       class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                        Add Your First Photo
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($photos as $photo)
                        <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
                            <div class="flex justify-center">
                                <img src="{{ $photo->url }}" alt="Photo {{ $photo->uuid }}"
                                     class="w-full h-48 object-cover rounded">
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-bold text-gray-900 text-center">
                                    {{ $photo->uuid }}
                                </h3>
                                <span class="font-bold">{{ $photo->latitude }}</span>
                                <span class="font-bold">{{ $photo->longitude }}</span>
                            </div>
                            <div class="mt-4 space-y-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('project.photo.edit', [$project, $photo]) }}"
                                       class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('project.photo.destroy', [$project, $photo]) }}"
                                          method="POST" class="flex-1"
                                          onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $photos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
