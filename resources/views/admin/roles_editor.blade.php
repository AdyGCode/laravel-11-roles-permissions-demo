<x-admin-layout>

    <x-slot name="header">
        <h2 class="text-2xl text-amber-50">
            User Role Editor
        </h2>
    </x-slot>

    <article class="relative flex flex-col min-w-0 rounded rounded-lg break-words border bg-white border-1
                border-neutral-300">
        <header>
            <h3 class="text-xl py-3 px-6 mb-3
                   bg-neutral-800 text-neutral-200
                   border-b-1 border-neutral-300
                   rounded-t-lg">
                Role Assignments
            </h3>
        </header>

        <div class="flex flex-col lg:flex-row p-4 gap-6">

            @foreach($roles as $r)

                <section class="lg:w-1/3 border shadow rounded">
                    <header class="flex-none bg-neutral-600 text-neutral-100 p-2 rounded-t">
                        <h4 class="text-xl capitalize">{{$r->name}}</h4>
                    </header>

                    <div class="flex flex-col gap-2 mb-4">

                      @if($canEdit)
                            <form class="flex flex-row align-middle mb-2 border-b p-4"
                                  role="form" method="POST"
                                  action="{{ route('assignRole') }}">
                                @csrf  @method('post')
                                <input type="hidden" name="role_id" value="{{ $r->id }}">
                                <div class="flex flex-row gap-4 items-center">
                                    <label
                                        class="text-neutral-700 leading-normal"
                                        for="role-id-{{ $r->id }}">Add:</label>
                                    <div class="grow" id="input-r-{{$r->id}}">
                                        @include('admin._member_selector', ['fieldname' => 'member_id', 'field_id' => 'role-id-'.$r->id, 'current' => null, 'users' => $users])
                                    </div>
                                        <button type="submit"
                                                class="inline-block align-middle text-center select-none border
                                                       rounded py-1 px-3 leading-normal
                                                       no-underline py-1 px-2
                                                       bg-blue-200 hover:bg-blue-600
                                                       text-blue-800 hover:text-blue-200">
                                            <i class="fa fa-save text-xl"></i> Add
                                        </button>
                                </div>
                            </form>
                        @endif

                        @foreach ($r->users as $u)
                            @if( ($r->name !== 'Admin' && $canEdit) ||
                                 ($r->name === 'Admin' && $canDeleteAdmins) ||
                                 ($r->name === 'Super-Admin' && $canDeleteSuperAdmins) )
                                <form class="flex flex-row items-center hover:bg-neutral-100 px-4 py-1"
                                      role="form"
                                      method="POST"
                                      action="{{ route('revokeRole') }}">
                                    @csrf  @method('delete')
                                    <input type="hidden" name="role_id" value="{{ $r->id }}">
                                    <input type="hidden" name="member_id" value="{{ $u->id }}">
                                    <a href="/members/{{ $u->id }}" class="grow">{{ $u->name }}</a>
                                    <input type="submit"
                                           class="text-red-800 hover:text-red-100
                                                  inline-block align-middle text-center select-none
                                                  border border-red-800 hover:border-red-100
                                                  font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal
                                                  no-underline py-1 px-2 leading-tight text-xs
                                                  bg-red-200 hover:bg-red-800
                                                  print:hidden"
                                           value=" X " title="Revoke">
                                </form>
                            @else
                                <a href="/members/{{ $u->id }}">{{ $u->name }}</a>
                            @endif
                        @endforeach

                    </div>

                </section>
            @endforeach
        </div>
    </article>


</x-admin-layout>
