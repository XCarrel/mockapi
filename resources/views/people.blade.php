<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('People') }}
        </h2>
    </x-slot>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        @foreach(\App\Models\User::all() as $user)
                            <tr class="table-row">
                                <td class="table-cell p-2">{{ $user->firstname }} {{ $user->lastname }}</td>
                                <td class="table-cell p-2">{{ $user->email }}</td>
                                <td class="table-cell p-2" style="font-family: 'Courier New'">{{ $user->apiClient->api_token }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
