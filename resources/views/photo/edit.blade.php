<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Photo Movements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <!-- Current Image Display -->
                <div class="mb-6">
                    <!-- Scale -->
                    <div class="mb-6">
                        <!-- Scale -->
                        <div class="relative w-full mb-4">
                            <!-- Scale Line -->
                            <div class="relative w-full h-2 bg-gray-300">
                                <!-- Vertical Markers -->
                                <div class="absolute top-0 left-0 w-0.5 h-full bg-gray-700"></div>
                                <div class="absolute top-0" style="left: 12.5%; width: 1px; height: 100%; background: #4a5568;"></div>
                                <div class="absolute top-0" style="left: 25%; width: 1px; height: 100%; background: #4a5568;"></div>
                                <div class="absolute top-0" style="left: 37.5%; width: 1px; height: 100%; background: #4a5568;"></div>
                                <div class="absolute top-0" style="left: 50%; width: 1px; height: 100%; background: #4a5568;"></div>
                                <div class="absolute top-0" style="left: 62.5%; width: 1px; height: 100%; background: #4a5568;"></div>
                                <div class="absolute top-0" style="left: 75%; width: 1px; height: 100%; background: #4a5568;"></div>
                                <div class="absolute top-0" style="left: 87.5%; width: 1px; height: 100%; background: #4a5568;"></div>
                                <div class="absolute top-0" style="left: 100%; width: 1px; height: 100%; background: #4a5568;"></div>
                            </div>

                            <!-- Marker Labels -->
                            <div class="absolute w-full top-[-1.5rem] text-sm text-gray-600">
                                <span class="absolute" style="left: 0%; transform: translateX(-50%);">-180</span>
                                <span class="absolute" style="left: 12.5%; transform: translateX(-50%);">-135</span>
                                <span class="absolute" style="left: 25%; transform: translateX(-50%);">-90</span>
                                <span class="absolute" style="left: 37.5%; transform: translateX(-50%);">-45</span>
                                <span class="absolute" style="left: 50%; transform: translateX(-50%);">0</span>
                                <span class="absolute" style="left: 62.5%; transform: translateX(-50%);">45</span>
                                <span class="absolute" style="left: 75%; transform: translateX(-50%);">90</span>
                                <span class="absolute" style="left: 87.5%; transform: translateX(-50%);">135</span>
                                <span class="absolute" style="left: 100%; transform: translateX(-50%);">180</span>
                            </div>
                        </div>

                        <!-- Image -->
                        <img src="{{ $photo->url }}" alt="Photo {{ $photo->uuid }}" class="w-full h-auto rounded">
                    </div>




                    <form action="{{ route('project.photo.update', [$project, $photo]) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Latitude -->
                    <div class="mb-4">
                        <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="text" name="latitude" id="latitude"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('latitude', $photo->latitude) }}" required>
                        @error('latitude')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Longitude -->
                    <div class="mb-4">
                        <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="text" name="longitude" id="longitude"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('longitude', $photo->longitude) }}" required>
                        @error('longitude')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Movements Section -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Movements</label>
                        <div id="movements-container" class="space-y-4">
                            @foreach ($photo->movements as $movement)
                                <div class="flex items-center space-x-4 movement-row">
                                    <!-- Left: Image of the picked photo -->
                                    <div class="w-3/4">
                                        <img src="{{ $movement->pivot->next_photo_id ? $project->photos->firstWhere('id', $movement->pivot->next_photo_id)?->url : '' }}"
                                             alt="Selected Photo"
                                             class="w-full h-24 object-cover rounded border border-gray-300"
                                             id="photo-preview-{{ $loop->index }}">
                                    </div>

                                    <!-- Right: Inputs and Button -->
                                    <div class="w-1/4 flex flex-col space-y-2 p-2">
                                        <!-- Photo Select -->
                                        <select name="movements[{{ $loop->index }}][photo_id]"
                                                class="rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                onchange="updateImagePreview(this, {{ $loop->index }})">
                                            <option value="">Select Photo</option>
                                            @foreach ($otherPhotos as $projectPhoto)
                                                <option value="{{ $projectPhoto->id }}"
                                                        {{ $movement->pivot->next_photo_id == $projectPhoto->id ? 'selected' : '' }}>
                                                    {{ $projectPhoto->uuid }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Value Input -->
                                        <input type="text" name="movements[{{ $loop->index }}][value]"
                                               class="rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                               value="{{ old('movements.' . $loop->index . '.value', $movement->pivot->angle) }}"
                                               placeholder="Enter Value">

                                        <!-- Remove Button -->
                                        <button type="button" class="remove-row bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">
                                            &times; Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add Movement Button -->
                        <button type="button" id="add-movement"
                                class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                            Add Movement
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <a href="{{ route('project.photo.index', $project) }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow mr-2">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Dynamic Movements -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('movements-container');
            const addButton = document.getElementById('add-movement');

            addButton.addEventListener('click', () => {
                const rowCount = container.querySelectorAll('.movement-row').length;
                const newRow = document.createElement('div');
                newRow.classList.add('flex', 'items-center', 'space-x-4', 'movement-row');
                newRow.innerHTML = `
                    <!-- Left: Placeholder for Image -->
                    <div class="w-3/4">
                        <img src="{{ asset('placeholder-image.jpg') }}"
                             alt="No Image"
                             class="w-full h-24 object-cover rounded border border-gray-300"
                             id="photo-preview-${rowCount}">
                    </div>

                    <!-- Right: Select, Input, and Delete Button -->
                    <div class="w-1/4 flex flex-col space-y-2 p-2">
                        <select name="movements[${rowCount}][photo_id]"
                                class="rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                onchange="updateImagePreview(this, ${rowCount})">
                            <option value="">Select Photo</option>
                            @foreach ($otherPhotos as $projectPhoto)
                <option value="{{ $projectPhoto->id }}">{{ $projectPhoto->uuid }}</option>
                            @endforeach
                </select>
                <input type="text" name="movements[${rowCount}][value]"
                               class="rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter Value">
                        <button type="button" class="remove-row bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">
                            &times; Remove
                        </button>
                    </div>
                `;
                container.appendChild(newRow);
                attachRemoveHandler(newRow.querySelector('.remove-row'));
            });

            container.querySelectorAll('.remove-row').forEach(button => attachRemoveHandler(button));

            function attachRemoveHandler(button) {
                button.addEventListener('click', () => {
                    button.parentElement.parentElement.remove();
                });
            }
        });

        function updateImagePreview(selectElement, index) {
            const photoId = selectElement.value;
            const previewImage = document.getElementById(`photo-preview-${index}`);
            const photos = @json($otherPhotos->pluck('url', 'id'));
            previewImage.src = photos[photoId] || '';
        }
    </script>
</x-app-layout>
