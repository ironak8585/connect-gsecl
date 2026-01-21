<x-app-layout>
    <x-slot name="header">
        {{ __('Add User') }}
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-3 lg:px-4">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:py-2 lg:px-4">
                <div class="item flex flex-wrap justify-end gap-4">
                    <x-link-button href="{{ route('admin.users.index') }}">Users</x-link-button>
                </div>
            </div>
            <hr>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-1/2 mx-auto">
                    <form method="POST" action="{{ route('admin.users.assign-role', $user->id) }}">
                        @csrf
                        <div class="p-6">
                            <div class="mb-4">
                                <x-form.text-input label="Name" name="name" value="{{ $user->name }}" disabled />
                            </div>

                            <div class="mb-4">
                                <x-show.multiple-data label="Assigned Roles" :values="$user->roles->pluck('name')" />
                            </div>

                            <div class="mb-1">
                                <x-form.select-input name="role" :options="$roles" label="Role" :selected="old('role')"
                                    :isDummyRequired="true" />
                            </div>
                        </div>
                        <div class="px-6 pb-3 dark:bg-gray-800 text-right">
                            <x-primary-button>Save</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>