<div class="container-fluid px-6 mx-auto grid">

    @if(session('success'))
    <div class="flex justify-between w-full bg-green-100 rounded-md mt-4 p-4 shadow-xs">
        <span class="text-green-500 text-md">{{ session('success') }}</span>
        <button class="text-green-500" wire:click="removeflash">x</button>
    </div>
    @endif

    <div class="flex">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Liste des utilisateurs
        </h2>
    </div>

    <div>
        <x-button wire:click="showCreateUserModal" class="mb-2">
            {{ __('Ajouter un utilisateur') }}
        </x-button>
        <!-- Create classroom modal -->
        <x-dialog-modal wire:model="createUserModal">
            <x-slot name="title">
                {{ __('Créer un utilisateur') }}
            </x-slot>

            <form>
                <x-slot name="content">
                    <div class="flex px-2 my-2">
                        <div class="w-full md:w-1/1mr-4 ml-4">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Nom de l'utilisateur
                                </span>
                                <input wire:model="name" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" />
                                @error('name')
                                <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="flex px-2 my-2">
                        <div class="w-full md:w-1/1mr-4 ml-4">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Email
                                </span>
                                <input wire:model="email" type="email" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" />
                                @error('email')
                                <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="flex px-2 my-2">
                        <div class="w-full md:w-1/1mr-4 ml-4">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Role
                                </span>
                                <select wire:model.live="role" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option>Sélectionner un role</option>
                                    @foreach(\App\Enums\RoleType::cases() as $type)
                                    <option value="{{ $type->value }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="flex px-2 my-2">
                        <div class="w-full md:w-1/1mr-4 ml-4">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Mot de passe
                                </span>
                                <input wire:model="password" type="password" autocomplete="new-password" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" />
                                @error('password')
                                <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="flex px-2 my-2">
                        <div class="w-full md:w-1/1mr-4 ml-4">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Confirmer le mot de passe
                                </span>
                                <input wire:model="password_confirmation" type="password" autocomplete="new-password" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" />
                                @error('password_confirmation')
                                <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="px-2 my-2">
                        <div class="w-full md:w-2/3 mr-4 ml-4">
                            <x-button wire:click="save">
                                {{ __('Valider') }}
                            </x-button>
                        </div>
                    </div>
                </x-slot>
            </form>
        </x-dialog-modal>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        
                        <th class="px-4 py-3">
                            <div class="flex item-center">Type</div>
                        </th>
                        <th class="px-4 py-3">
                            <div class="flex item-center">Nom de la classe</div>
                        </th>
                        <th class="px-4 py-3">
                            <div class="flex item-center">Capacité</div>
                        </th>
                        <th class="px-4 py-3">
                            <div class="flex item-center">Nombre de cours</div>
                        </th>
                        <th class="px-4 py-3">Créé</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($users as $user)
                    <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">{{ $user->id }}</td>
                    <td class="px-4 py-3 text-sm">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-sm">
                        @foreach($user->allTeams() as $team)
                            <li>{{ $team->name }}({{ $user->teamRole($team)->name }})</li>
                        @endforeach
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <a href="{{ route('users.edit', $user->id) }}">Edit</a>
                        <form method="POST" action="{{ route('users.delete', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
                </tbody>
            </table>
        </div>
        <div class="w-full overflow-x-auto px-4 py-3">
        </div>
    </div>
</div>


