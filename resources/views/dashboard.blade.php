<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <header class="p-6">
                    <h3 class="text-2xl">Welcome </h3>
                </header>
                <div class="p-6 text-neutral-900">
                    {{ __("You're logged in!") }}
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
