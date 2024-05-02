<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-800 leading-tight">
            {{ __('Admin Dashboard') }}
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

        {{--Add colours used in the statistics in a hidden div to fool Tailwindcss--}}
        <div class="bg-red-400 bg-violet-400 bg-sky-400 bg-slate-400 hidden"></div>

        <section class="flex justify-between bg-neutral-100 gap-8 pt-4">

            @foreach($statistics as $name=>$statistic)
                <div class="container mx-auto grow">
                    <div
                        class=" bg-white max-w-xs mx-auto rounded-lg overflow-hidden shadow-lg hover:shadow-xl
                               transition duration-500 transform hover:scale-100 cursor-pointer min-h-32">
                        <div class="h-16 {{ $statistic["colour"] }} flex items-center justify-between">
                            <p class="mr-0 text-white text-xl font-bold tracking-wider pl-5">{{ $name }}</p>
                        </div>
                        <p class="py-4 text-3xl ml-5">{{ $statistic["data"] }}</p>
                        <!-- <hr > -->
                    </div>
                </div>
            @endforeach

        </section>
    </div>
</x-app-layout>
