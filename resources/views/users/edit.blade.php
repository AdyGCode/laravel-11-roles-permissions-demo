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


                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <label class="w-1/6 font-bold">Whoops!</label> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ route('users.update', $user->id) }}" method="post"
                          class="flex flex-col gap-4">
                        @method('patch')
                        @csrf


                        <div class="flex flex-row">
                            <label class="w-1/6 font-bold">Name:</label>
                            <input type="text" value="{{ $user->name }}" name="name"
                                   class="grow"
                                   placeholder="Name">
                        </div>

                        <div class="flex flex-row">
                            <label class="w-1/6 font-bold">Email:</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="grow"
                                   placeholder="Email">
                        </div>


                        <div class="flex flex-row">
                            <label class="w-1/6 font-bold">Password:</label>
                            <input type="password" name="password" class="grow"
                                   placeholder="Password">
                        </div>

                        <div class="flex flex-row">
                            <label class="w-1/6 font-bold">Confirm Password:</label>
                            <input type="password" name="confirm-password" class="grow"
                                   placeholder="Confirm Password">
                        </div>

                        <div class="flex flex-row">
                            <label class="w-1/6 font-bold">Role:</label>
                            <select class="grow multiple" multiple name="roles[]">
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-12 mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
