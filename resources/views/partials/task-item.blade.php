<div
    class="grid grid-cols-[auto_1fr_auto] gap-6 items-center border-b-2 border-gray-200 py-4 px-4 bg-white dark:bg-gray-700 rounded">
    <form method="POST" action="{{ route('task.marking', $data->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="{{ $data->status ? 0 : 1 }}">
        <input {{ $data->status ? 'checked' : '' }} type="checkbox" class="size-8" onChange="this.form.submit()" />
    </form>
    <div>
        <h3 class="text-lg font-bold  {{ $data->status ? 'line-through text-gray-300' : '' }} ">
            {{ $data->name }}</h3>
        <div class="text-sm text-gray-500 mt-1">
            Status:
            <span class="font-medium {{ $data->status ? 'text-green-500' : 'text-red-500' }}">
                {{ $data->status ? 'Finished' : 'Unfinished' }}
            </span>
            </span> |
            Due Date: <span class="font-medium">{{ $data->date }}</span>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <x-secondary-button x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'edit-task-{{ $data->id }}')">
            Edit
        </x-secondary-button>
        <form method="POST" action="{{ route('task.destroy', $data->id) }}">
            @csrf
            @method('DELETE')
            <x-danger-button type="submit">Delete</x-danger-button>
        </form>
    </div>
</div>

<x-modal name="edit-task-{{ $data->id }}" focusable>
    <form action="{{ route('task.update', $data->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Update Task {{ $data->name }}
        </h2>

        <div class="grid grid-cols-2 gap-4 pb-6">
            <div class="mt-6 col-span-2">
                <x-input-label for="name" value="Name" class="text-black" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full h-full"
                    value="{{ old('Name', $data->name) }}" placeholder="{{ __('Name') }}" required />
            </div>

            <div class="mt-6">
                <x-input-label for="priority" value="{{ __('Priority') }}" class="text-black" />
                <x-select-input name="priority" id="priority"
                    class="mt-1 block w-full h-full border rounded px-2 py-1">
                    <option value="" disabled>Select</option>
                    <option {{ $data->priority == '3' ? 'selected' : '' }} value="3">High</option>
                    <option {{ $data->priority == '2' ? 'selected' : '' }} value="2">Medium</option>
                    <option {{ $data->priority == '1' ? 'selected' : '' }} value="1">Low</option>
                </x-select-input>
            </div>

            <div class="mt-6">
                <x-input-label for="date" value="{{ __('Date') }}" class="text-black" />
                <x-text-input id="date" name="date" type="datetime-local" class="mt-1 block w-full h-full"
                    value="{{ old('Date', $data->date) }}" placeholder="{{ __('Date') }}" required />
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-primary-button>
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
