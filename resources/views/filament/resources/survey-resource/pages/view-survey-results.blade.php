<x-filament::page>
    <h2 class="text-xl font-bold mb-4">
        {{ $survey->title }}
    </h2>

    {{-- グラフ --}}
    <canvas id="chart"></canvas>

    {{-- 投票結果 --}}
    <div class="mt-6">
        @foreach ($results as $result)
            <div class="mb-2">
                {{ $result['label'] }}：{{ $result['count'] }}票
            </div>
        @endforeach
    </div>

    {{-- コメント --}}
   <div class="mt-8">
    <h3 class="text-lg font-bold mb-2">選択肢ごとのコメント</h3>

        @foreach ($survey->options as $option)
            <h4>{{ $option->option_text }}</h4>

            @forelse ($option->comments as $comment)
                <div>{{ $comment->comment }}</div>
            @empty
                <div>コメントなし</div>
            @endforelse
        @endforeach
</div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(collect($results)->pluck('label')),
                datasets: [{
                    label: '投票数',
                    data: @json(collect($results)->pluck('count')),
                }]
            }
        });
    </script>
</x-filament::page>