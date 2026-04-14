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
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 font-medium">{{ $result['label'] }}</span>
                        <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-4 py-2 rounded-full font-bold">
                            {{ $result['count'] }} 票
                        </span>
                    </div>
                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                        @php
                            $percentage = count($results) > 0 
                                ? ($result['count'] / array_sum(collect($results)->pluck('count')->toArray())) * 100 
                                : 0;
                        @endphp
                        <div class="bg-purple-600 h-2 rounded-full transition-all" style="width: {{ $percentage }}%;"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ number_format($percentage, 1) }}%</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- コメント --}}
    <div class="mt-8">
        <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <span class="inline-block w-1 h-8 bg-blue-600 rounded"></span>
            選択肢ごとのコメント
        </h3>

        <div class="space-y-4">
            @foreach ($survey->options as $option)
                <div class="bg-white dark:bg-slate-950 border border-gray-200 dark:border-slate-800 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <!-- オプションヘッダー -->
                    <div class="bg-slate-50 dark:bg-slate-900 px-6 py-2 border-b border-gray-200 dark:border-slate-800">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h4 class="text-lg font-bold text-black dark:text-white mb-1">
                                    {{ $option->option_text }}
                                </h4>
                                <div class="flex flex-wrap items-center gap-2 text-sm">
                                    <span class="inline-flex items-center gap-1 bg-white dark:bg-slate-800 px-3 py-1 rounded-full font-medium border border-slate-200 dark:border-slate-700 text-black dark:text-white">
                                        <svg class="w-4 h-4 text-black dark:text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                        </svg>
                                        投票数: <strong>{{ $option->votes->count() }}</strong>
                                    </span>
                                    <span class="inline-flex items-center gap-1 bg-white dark:bg-slate-800 px-3 py-1 rounded-full font-medium border border-slate-200 dark:border-slate-700 text-black dark:text-white">
                                        <svg class="w-4 h-4 text-black dark:text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v16z"></path>
                                        </svg>
                                        コメント: <strong>{{ $option->comments->count() }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- コメント表示エリア -->
                    <div class="px-6 py-3">
                        @forelse ($option->comments as $comment)
                            <div class="mb-3 last:mb-0">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100">
                                            <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-gray-50 dark:bg-slate-900 rounded px-4 py-2 border-l-4 border-blue-400">
                                            <p class="text-gray-900 dark:text-gray-100 text-sm leading-relaxed">{{ $comment->comment }}</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                                {{ $comment->created_at->format('Y年m月d日 H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex items-center justify-center py-3">
                                <div class="text-center">
                                    <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium text-sm mt-1">コメントはまだありません</p>
                                </div>
                            </div>
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