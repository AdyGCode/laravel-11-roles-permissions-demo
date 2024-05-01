<x-admin-layout>

    <x-slot name="header">
        <h2 class="text-2xl text-amber-50">
            User Role Editor
        </h2>
    </x-slot>

    <article class="relative flex flex-col min-w-0
                    rounded-lg break-words
                    bg-white
                    border border-neutral-300  ">
        <header>
            <h3 class="text-xl py-3 px-6 mb-3
                   bg-neutral-800
                   text-neutral-200
                   border-b-1 border-neutral-300
                   rounded-t-lg">
                Role Assignments
            </h3>
        </header>

        <div class="flex flex-col lg:flex-row p-4 gap-6">

            @foreach($roles as $role)

                <section class="w-full md:w-1/3 border shadow rounded
                                border-neutral-300 ">
                    <header class="flex-none bg-neutral-600 text-neutral-100 p-2 rounded-t">
                        <h4 class="text-xl capitalize">{{$role->name}}</h4>
                    </header>

                    <div class="flex flex-col gap-0 mb-4 flex-wrap">
                        @if($canEdit)
                            @can('role-assign')
                                <form
                                    class="flex flex-row align-middle mb-2 border-b p-4
                                       border-neutral-300 "
                                    role="form"
                                    method="POST"
                                    action="{{ route('admin.assign-role') }}">

                                    @csrf
                                    {{--                                @method('post')--}}

                                    <input type="hidden"
                                           name="role_id"
                                           value="{{ $role->id }}">
                                    <div class="flex flex-row gap-4 items-center">
                                        <label
                                            class="text-neutral-700 leading-normal p-0 grow"
                                            for="role-id-{{ $role->id }}">Add:</label>

                                        <div class="grow -ml-1" id="input-r-{{$role->id}}">
                                            @include('admin._member_selector',
                                                    ['fieldname' => 'member_id',
                                                     'field_id' => 'role-id-'.$role->id,
                                                      'current' => null,
                                                      'users' => $users])
                                        </div>

                                        <button type="submit"
                                                class="align-middle text-center leading-normal select-none
                                                   border border-blue-600
                                                   rounded py-1.5 px-2
                                                   no-underline flex-none
                                                   bg-blue-200 hover:bg-blue-600
                                                   text-blue-800 hover:text-blue-200
                                                   transition-all duration-300 ease-in-out">
                                            <i class="fa fa-save text-xl"></i> Add
                                        </button>
                                    </div>
                                </form>
                            @endcan
                        @endif

                        @foreach ($role->users as $user)
                            @if( ($role->name !== 'Admin' && $canEdit) ||
                                 ($role->name === 'Admin' && $canEdit) ||
                                 ($role->name === 'Admin' && $canDeleteAdmins) ||
                                 ($role->name === 'Super-Admin' && $canDeleteSuperAdmins) )
                                <form class="flex flex-row items-center
                                             hover:bg-neutral-100
                                             px-4 py-1
                                             group transition-all duration-500 ease-in-out"
                                      role="form"
                                      method="POST"
                                      action="{{ route('admin.revoke-role') }}">

                                    @csrf
                                    @method('delete')

                                    <input type="hidden" name="role_id" value="{{ $role->id }}">
                                    <input type="hidden" name="member_id" value="{{ $user->id }}">

                                    <a href="{{ route('users.show', $user->id ) }}"
                                       class="px-4 grow text-neutral-600 hover:text-neutral-200">
                                        {{ $user->name }}
                                    </a>
                                    @can('role-revoke')
                                        <button type="submit"
                                                class="align-middle text-center select-none
                                                  rounded
                                                  py-1 px-4
                                                  no-underline text-xs
                                                  text-red-800 hover:text-red-100
                                                  border border-1 border-neutral-400 hover:border-red-100
                                                  group-hover:border-red-500
                                                  bg-neutral-200 hover:bg-red-500
                                                  transition-all duration-500 ease-in-out
                                                  print:hidden"
                                                value=" X " title="Revoke">
                                            <i class="fa fa-times text-lg"
                                               title="Revoke Role for User {{$user->name}}"></i>
                                        </button>
                                    @endcan
                                </form>
                            @else
                                <a href="{{ route('users.show', $user->id ) }}"
                                   class="px-4 grow text-neutral-600 hover:text-neutral-200">
                                    {{ $user->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                </section>
            @endforeach
        </div>
    </article>


</x-admin-layout>
