<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-800 leading-tight">
            {{ __('Member Area') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
        <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <header class="p-6 bg-neutral-500 text-neutral-50">
                <h3 class="text-2xl">Welcome {{ Auth::user()->name }}</h3>
            </header>

            <section class="p-6 text-neutral-900">
                {{ __("You're logged in!") }}
            </section>

        </article>

    </div>
</x-app-layout>
