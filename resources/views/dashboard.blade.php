<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('To-Do List') }}
        </h2>
    </x-slot>

    <div class="mx-auto px-8">
        <div class="px-6 mt-4">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between mb-6 items-center">
                    <x-primary-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'add-taks')">Add Task</x-primary-button>

                    <div class="flex items-center gap-4">
                        <form method="GET" class="flex items-center gap-2">
                            <div class="flex flex-col">
                                <x-input-label for="from" class="text-sm font-medium">From</x-input-label>
                                <x-text-input type="datetime-local" name="from" value="{{ request('from') }}" />
                            </div>

                            <div class="flex flex-col">
                                <x-input-label for="to" class="text-sm font-medium">To</x-input-label>
                                <x-text-input type="datetime-local" name="to" value="{{ request('to') }}" />
                            </div>

                            <div class="flex self-center gap-2 ">
                                <x-primary-button class="" type="submit" name="action" value="filter">
                                    Filter
                                </x-primary-button>

                                <x-secondary-button class="" type="submit" name="action" value="clear">
                                    Clear
                                </x-secondary-button>
                            </div>
                        </form>
                    </div>


                </div>


                <div class="space-y-4">
                    <div class="grid gap-4">
                        @foreach ([3, 2, 1] as $prioritas)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="font-semibold capitalize mb-2 text-md border-b pb-2">
                                    @if ($prioritas == 3)
                                        High
                                    @elseif ($prioritas == 2)
                                        Medium
                                    @else
                                        Low
                                    @endif
                                    Priority
                                </h3>

                                @if ($task->where('priority', $prioritas)->count() == 0)
                                    <p class="text-gray-500">
                                        @if ($prioritas == 3)
                                            High
                                        @elseif ($prioritas == 2)
                                            Medium
                                        @else
                                            Low
                                        @endif
                                        Priority Task Not Found
                                    </p>
                                @endif

                                @foreach ($task->where('priority', $prioritas) as $data)
                                    @include('partials.task-item', ['data' => $data])
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-taks" focusable>
        <form action="{{ route('task.store') }}" method="POST" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add Task') }}
            </h2>

            <div class="grid grid-cols-2 gap-4 pb-4">
                <div class="mt-6 col-span-2">
                    <x-input-label for="name" value="{{ __('Name') }}" class="text-black" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full h-full"
                        placeholder="{{ __('Name') }}" required />
                </div>

                <div class="mt-6">
                    <x-input-label for="priority" value="{{ __('Priority') }}" class="text-black" />
                    <x-select-input name="priority" id="priority"
                        class="mt-1 block w-full h-full border rounded px-2 py-1">
                        <option value="" disabled selected>Select</option>
                        <option value="3">High</option>
                        <option value="2">Medium</option>
                        <option value="1">Low</option>
                    </x-select-input>
                </div>

                <div class="mt-6">
                    <x-input-label for="date" value="{{ __('Date') }}" class="text-black" />
                    <x-text-input id="date" name="date" type="datetime-local" class="mt-1 block w-full h-full"
                        placeholder="{{ __('Date') }}" required />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button type="submit">
                    {{ __('add') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
