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

    @php
        $htmlOutput = '';
        foreach ($results as $result) {
            $option = $survey->options->firstWhere('option_text', $result['label']);
            $comments = $option?->comments ?? collect();

            $htmlOutput .= '<h3>' . e($result['label']) . ' ' . e($result['count']) . '票</h3>' . PHP_EOL;
            $htmlOutput .= '<p>' . e($comments->first()?->comment ?? '') . '</p>' . PHP_EOL;
            $htmlOutput .= '<ul>' . PHP_EOL;

            foreach ($comments as $comment) {
                $htmlOutput .= '  <li>' . e($comment->comment) . '</li>' . PHP_EOL;
            }

            $htmlOutput .= '</ul>' . PHP_EOL;
        }
    @endphp

    {{-- 投票結果 --}}
    <div class="mt-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <h3 class="text-2xl font-bold flex items-center gap-2">
                <span class="inline-block w-1 h-8 bg-purple-600 rounded"></span>
                投票結果
            </h3>
            <x-filament::button
                type="button"
                color="gray"
                id="download-html-output"
            >
                HTML出力（.txt）
            </x-filament::button>
        </div>

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
                        <p class="text-gray-900 dark:text-gray-100 text-sm leading-relaxed break-words whitespace-pre-wrap">{{ $comment->comment }}</p>
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
        const htmlOutput = @json($htmlOutput);
        const downloadButton = document.getElementById('download-html-output');

        if (downloadButton) {
            downloadButton.addEventListener('click', function () {
                const blob = new Blob(['\uFEFF', htmlOutput], {
                    type: 'text/plain;charset=utf-8',
                });
                const downloadUrl = URL.createObjectURL(blob);
                const link = document.createElement('a');

                link.href = downloadUrl;
                link.download = 'survey-{{ $survey->id }}.txt';
                link.click();
                URL.revokeObjectURL(downloadUrl);
            });
        }

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