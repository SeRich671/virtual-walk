<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800">Your Projects</h3>
                @if($projects->isNotEmpty())
                <a href="{{ route('project.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                    Create Project
                </a>
                @endif
            </div>

            @if ($projects->isEmpty())
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <p class="text-gray-700 text-lg">You have no projects yet.</p>
                    <a href="{{ route('project.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                        Create Your First Project
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($projects as $project)
                        <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $project->name }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-2">
                                    {{ Str::limit($project->description, 100) }}
                                </p>
                                <p>
                                    <a href="{{ route('project.show', $project->share_url) }}" target="_blank">{{ route('project.show', $project->share_url) }}</a>
                                </p>
                            </div>
                            <div class="mt-4 space-y-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('project.edit', $project) }}"
                                       class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">
                                        Edit
                                    </a>
                                    @if($project->share_url)
                                        <a href="{{ route('project.hide', $project) }}"
                                           class="flex-1 text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded">
                                            Hide
                                        </a>
                                    @else
                                        <a href="{{ route('project.publish', $project) }}"
                                           class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white py-2 rounded">
                                            Publish
                                        </a>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('project.photo.index', $project) }}"
                                       class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded">
                                        Images
                                    </a>
                                    <form action="{{ route('project.destroy', $project) }}" method="POST"
                                          class="flex-1" onsubmit="return confirm('Are you sure you want to delete this project?')">
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
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
