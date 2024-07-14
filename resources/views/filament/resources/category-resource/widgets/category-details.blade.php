<x-filament::widget>
    <x-filament::card>
        <div>
            <h2 class="text-xl font-semibold">{{ $category->name }}</h2>
            @if($category->parent)
                <p class="text-gray-600">Parent Category: {{ $category->parent->name }}</p>
            @endif
        </div>
        <div class="mt-4">
            <h3 class="text-lg font-semibold">Child Categories:</h3>
            <ul class="list-disc pl-4">
                @foreach($children as $child)
                    <li>{{ $child->name }}</li>
                @endforeach
            </ul>
        </div>
    </x-filament::card>
</x-filament::widget>
