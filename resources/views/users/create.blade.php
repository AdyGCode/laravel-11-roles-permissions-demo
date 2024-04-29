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

                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="pull-left">
                            <h2>Create New User
                                <div class="float-end">
                                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                                </div>
                            </h2>
                        </div>
                    </div>

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


                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 mb-3">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-xs-12 mb-3">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-xs-12 mb-3">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-xs-12 mb-3">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    <input type="password" name="confirm-password" class="form-control"
                                           placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-xs-12 mb-3">
                                <div class="form-group">
                                    <strong>Role:</strong>
                                    <select class="form-control multiple" multiple name="roles[]">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 mb-3 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
