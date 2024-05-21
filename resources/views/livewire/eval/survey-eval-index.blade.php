<div class="container-fluid px-6 mx-auto grid">

    @if(session('success'))
    <div class="flex justify-between w-full bg-green-100 rounded-md mt-4 p-4 shadow-xs">
        <span class="text-green-500 text-md">{{ session('success') }}</span>
        <button class="text-green-500" wire:click="removeflash">x</button>
    </div>
    @endif

    <h2 class="my-2 text-2xl text-center font-semibold text-gray-700 dark:text-gray-200">
        {{ Str::of("Rapport d'évaluation")->headline() }}
    </h2>
    <div>
        
    <x-nav-link href="{{ route('survey-eval-create', ['id' => $surveyid]) }}" class="bg-blue-500 pt-2 py-2 px-2 rounded text-white" wire:navigate>
                                    Nouvelle évaluation
                                </x-nav-link>
    </div>
    @if(sizeof($evaluations)!=0)
    <table class="w-full whitespace-no-wrap">
        <thead>
        <tr class="text-gray-700 dark:text-gray-400" wire:key="">
                <th class="px-4 py-3 text-sm text-start">Nom complet</th>
                <th class="px-4 py-3 text-sm text-start">Grille</th>
                <th class="px-4 py-3 text-sm text-start">Année scolaire</th>
                <th class="px-4 py-3 text-sm text-start">Période</th>
                <th class="px-4 py-3 text-sm text-start">Date d'évaluation</th>
                <th class="px-4 py-3 text-sm text-start">&nbsp;</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @foreach($evaluations as $eval)
            <tr class="text-gray-700 dark:text-gray-400" wire:key="">
                <td class="px-4 py-3 text-sm">{{\App\Models\Student::find(1)->first_name}} {{\App\Models\Student::find(1)->last_name}}</td>
                <td class="px-4 py-3 text-sm">{{ $eval->title }}</td>
                <td class="px-4 py-3 text-sm">{{ $eval->academic_year }}</td>
                <td class="px-4 py-3">
                    {{ $eval->quarter }}{{ $eval->quarter=='1'?'er':'ème' }} {{ _("trimestre") }}
                </td>
                <td class="px-4 py-3 text-sm">{{ $eval->created_at->diffForHumans() }}</td>
                <td class="px-4 py-3">
                    <x-nav-link href="{{ route('evaluation-index', ['id' => $eval->student_id, 'q' => $eval->quarter, 'ay' => $eval->academic_year]) }}" wire:navigate class="flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
                        </svg>
                    </x-nav-link>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <table class="w-full whitespace-no-wrap">
        <thead>
        <tr class="text-gray-700 dark:text-gray-400">
                <th class="px-4 py-3 text-sm text-start">&nbsp;</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
           <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-sm text-center">
                    Y'a aucune évaluation pour cette grille !!!
                </td>
            </tr>
        </tbody>
    </table>
    @endif

</div>