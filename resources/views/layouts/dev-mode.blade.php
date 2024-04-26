@if((env('APP_ENV')??"")==='local')
    <div class="py-2 px-6 text-center text-md font-bold bg-red-700 text-white/70 tracking-widest">
        <i class="fa fa-person-digging mr-4 text-xl align-middle"></i>
        DEVELOPMENT MODE: Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </div>
@endif
