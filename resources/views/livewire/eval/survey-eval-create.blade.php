<div class="container px-6 mx-auto grid">
    <form>

        @if(session('success'))
        <div class="flex justify-between w-full bg-green-100 rounded-md mt-4 p-4 shadow-xs">
            <span class="text-green-500 text-md">{{ session('success') }}</span>
            <button class="text-green-500" wire:click="removeflash">x</button>
        </div>
        @endif

        <!-- Card -->
        <div class="flex items-center p-4 mt-8 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>
            <div class="">
                <div>
                    <select wire:model="studentId" class="block w-44 mt-1 text-sm rounded dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option>Sélectionner l'évaluateur</option>
                        @foreach(\App\Models\Student::all() as $student)
                        <option value="{{ $student->id }}">{{ucwords($student->first_name)}} {{strtoupper($student->last_name)}}</option>
                        @endforeach
                    </select>
                    @error('studentId')
                    <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full md:w-1/1mr-4 ml-4">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    School Year
                                </span>
                                <select wire:model="academic_year" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option>Sélectionner une année scolaire</option>
                                    @foreach($generateSchoolYears as $year)
                                    <option>{{ $year }}-{{ $year+1 }}</option>
                                    @endforeach
                                </select>
                                @error('academic_year')
                                <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                <div>
                    <select wire:model="quarter" class="block w-44 mt-1 text-sm rounded dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option>Sélectionner la période</option>
                        @foreach(range(1, 3) as $number)
                        <option value="{{ $number }}">{{ $number }}e trimestre</option>
                        @endforeach
                    </select>
                    @error('quarter')
                    <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs pt-4">
            <div class="w-full overflow-x-auto">
                <!-- Accordion Item 2 -->
                @foreach($categories as $category)
                <div class="accordion-item mb-4">
                    <x-button class="accordion-button w-full text-left py-2 px-4 bg-gray-200 hover:bg-gray-300 rounded-lg" onclick="toggleAccordion(event, this)" style="background:#023565">
                        {{ $category }}
                    </x-button>
                    <div class="accordion-content hidden mt-2 p-4 border border-t-0 border-gray-200 rounded-b-lg">
                        <table class="w-full whitespace-no-wrap">
                            @foreach($survey->questions as $index => $question)
                            @if ($question->category === $category )
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td>&nbsp;</td>
                                <td class="px-4 py-3 text-sm">{{ $question->question_text }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <select wire:model="option.{{ $index }}.{{ $question->id }}" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                        <option value="0" selected>Non_eval</option>
                                        @foreach(\App\Enums\SurveyValue::cases() as $type)
                                        <option value="{{ $type->value }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('option.{{ $index }}.{{ $question->id }}')
                                    <span class="text-xs text-red-600 dark:text-gray-400">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="w-full overflow-x-auto py-3">
                <div class="w-full overflow-x-auto">
                    <x-button type="submit" wire:click.prevent="save">{{ __('Valider') }}</x-button>
                </div>
            </div>
    </form>
</div>