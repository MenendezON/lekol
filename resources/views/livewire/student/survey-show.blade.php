<div class="container px-6 mx-auto grid">

    @if(session('success'))
    <div class="flex justify-between w-full bg-green-100 rounded-md mt-4 p-4 shadow-xs">
        <span class="text-green-500 text-md">{{ session('success') }}</span>
        <button class="text-green-500" wire:click="removeflash">x</button>
    </div>
    @endif
    

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Questionnaire : {{ $survey->title }}
    </h2>

    <!-- Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-8 xl:grid-cols-16">
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>
            <div>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $survey->description }}
                </p>
            </div>
        </div>
    </div>
    <div>
        <x-button wire:click="showCreateQuestionModal" class="mb-2 btn-link">
            {{ __('Ajouter une question') }}
        </x-button>
        <!-- Create survey modal -->
        <x-dialog-modal wire:model="createQuestionModal">
            <x-slot name="title">
                {{ __('Créer une question') }}
            </x-slot>

            <form>
                <x-slot name="content">
                    <div class="flex px-2 my-2">
                        <div class="w-full md:w-1 mr-4 ml-4">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Type de classe
                                </span>
                                <select wire:model="category" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option>Sélectionner une valeur...</option>
                                    @foreach(\App\Enums\SurveyType::cases() as $type)
                                    <option value="{{ $type->value }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="flex px-2 my-2">
                        <div class="w-full md:w-1 mr-4 ml-4">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Questions
                                </span>
                                <div id="questions">
                                    @foreach ($questions as $index => $question)
                                    <div class="flex">
                                        <input type="text" wire:model.defer="questions.{{ $index }}.text" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" />
                                        <button type="button" wire:click="removeQuestion({{ $index }})" class="ml-2">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('questions.{{ $index }}.text')
                                    <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                    @enderror
                                    @endforeach
                                </div>
                            </label>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="px-2 my-2">
                        <div class="w-full md:w-3/3 mr-4 ml-4">
                            <x-button wire:click="addQuestion">
                                {{ __('Une autre question') }}
                            </x-button>
                            <x-button wire:click="create">
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
                        <th  colspan="2" class="px-4 py-3">
                            <div class="flex item-center">Question</div>
                        </th>
                        <th class="px-4 py-3">Fait seul</th>
                        <th class="px-4 py-3">Avec aide</th>
                        <th class="px-4 py-3">Fait pas</th>
                        <th class="px-4 py-3">Non éval</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($categories as $category)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td colspan="5" class="px-4 py-3 text-sm font-semibold">{{ $category }}</td><td>&nbsp;</td>
                    </tr>
                    @foreach($survey->questions as $question)
                    @if ($question->category === $category )
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td>&nbsp;</td><td class="px-4 py-3 text-sm">{{ $question->question_text }}</td>
                        
                        <td class="px-4 py-3 text-sm">0</td>
                        <td class="px-4 py-3 text-sm">0</td>
                        <td class="px-4 py-3 text-sm">0</td>
                        <td class="px-4 py-3 text-sm">0</td>
                    </tr>
                    @endif
                    @endforeach

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="w-full overflow-x-auto px-4 py-3">

        </div>
    </div>
</div>