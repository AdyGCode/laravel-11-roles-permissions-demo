<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight uppercase">
            {{ __('Administration') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-8 ">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Use this for flash messages</p>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="table w-full">
                        <thead>
                        <tr class="bg-neutral-500 rounded-t-lg text-neutral-200">
                            <th class="p-2 text-left">Name</th>
                            <th class="p-2 text-left">Email</th>
                            <th class="p-2 text-left">Roles</th>
                            <th class="p-2 text-right w-48">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td class="px-2">{{ $user->name }}</td>
                                <td class="px-2">{{ $user->email }}</td>
                                <td class="px-2">
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-secondary text-dark">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="px-2 text-right">
                                    <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                    <a class="btn btn-success" href="{{ route('users.destroy',$user->id) }}"> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">{{ $data->links() }}</td>
                        </tr>
                        </tfoot>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
