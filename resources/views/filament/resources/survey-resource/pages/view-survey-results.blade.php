<x-filament::page>
    <!-- ページヘッダー -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $survey->title }}</h1>
        <p class="text-gray-600">
            {{ $survey->description }}
        </p>
        @if($survey->expires_at)
            @php
                $createdAt = is_string($survey->created_at) 
                    ? \Carbon\Carbon::parse($survey->created_at) 
                    : $survey->created_at;
                $expiresAt = is_string($survey->expires_at) 
                    ? \Carbon\Carbon::parse($survey->expires_at) 
                    : $survey->expires_at;
            @endphp
            <p class="text-sm text-gray-500 mt-2">
                投票期間: {{ $createdAt->format('Y年m月d日') }} 
                〜 {{ $expiresAt->format('Y年m月d日 H:i') }}
            </p>
        @endif
    </div>

    {{-- グラフ --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">投票分布チャート</h3>
        <canvas id="chart"></canvas>
    </div>

    {{-- 投票結果 --}}
    <div class="mt-6">
        <h3 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <span class="inline-block w-1 h-8 bg-purple-600 rounded"></span>
            投票結果
        </h3>
<div class="grid gap-4">
    @foreach ($results as $result)
        @php
            $option = $survey->options->firstWhere('option_text', $result['label']);
        @endphp

        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow hover:shadow-md transition-shadow">
            
            <!-- タイトル＋票数 -->
            <div class="flex items-center justify-between">
                <span class="text-gray-700 font-medium">{{ $result['label'] }}</span>
                <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-4 py-2 rounded-full font-bold">
                    {{ $result['count'] }} 票
                </span>
            </div>

            <!-- バー -->
            <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                @php
                    $percentage = count($results) > 0 
                        ? ($result['count'] / array_sum(collect($results)->pluck('count')->toArray())) * 100 
                        : 0;
                @endphp
                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $percentage }}%;"></div>
            </div>

            <p class="text-xs text-gray-400 mt-1">{{ number_format($percentage, 1) }}%</p>

            <!-- ✅ コメント追加 -->
            <div class="mt-4 border-t pt-3">
                @forelse ($option?->comments as $comment)
                    <div class="mb-2">
                        <p class="text-sm text-gray-800">{{ $comment->comment }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $comment->created_at->format('Y年m月d日 H:i') }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">コメントはまだありません</p>
                @endforelse
            </div>

        </div>
    @endforeach
</div>
    </div>



    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chart');
        const data = @json(collect($results)->pluck('count'));
        const total = data.reduce((a, b) => a + b, 0);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(collect($results)->pluck('label')),
                datasets: [{
                    label: '投票数',
                    data: @json(collect($results)->pluck('count')),
                    backgroundColor: [
                        'rgba(147, 51, 234, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                    ],
                    borderColor: [
                        'rgba(147, 51, 234, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(236, 72, 153, 1)',
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        },
                    },
                },
            },
        });
    </script>
</x-filament::page>