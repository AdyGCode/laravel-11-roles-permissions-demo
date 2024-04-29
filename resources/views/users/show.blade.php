<x-admin-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-neutral-200 leading-tight uppercase rounded-lg bg-neutral-700 p-6">
            {{ __('Administration') }}
        </h2>
    </x-slot>

    <div class="space-y-8 ">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-neutral-900">
                    <p>Use this for flash messages</p>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-neutral-900">

                    <div class="row">
                        <div class="col-lg-12 margin-tb mb-4">
                            <div class="pull-left">
                                <h2>Show User</h2>
                                <div class="float-end">
                                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 mb-3">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $user->name }}
                            </div>
                        </div>
                        <div class="col-xs-12 mb-3">
                            <div class="form-group">
                                <strong>Email:</strong>
                                {{ $user->email }}
                            </div>
                        </div>
                        <div class="col-xs-12 mb-3">
                            <div class="flex flex-row space-x-2 items-center">
                                <strong>Roles:</strong>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                        <label class="px-2 bg-neutral-700 text-neutral-200 rounded-full ">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
