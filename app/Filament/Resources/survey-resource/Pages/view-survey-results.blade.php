<x-filament::page>

    <h2>投票結果</h2>

    <table>
        <thead>
            <tr>
                <th>選択肢</th>
                <th>票数</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
                <tr>
                    <td>{{ $result['text'] }}</td>
                    <td>{{ $result['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h2>コメント一覧</h2>

    @foreach($comments as $comment)
        <div style="border-bottom:1px solid #ccc; padding:5px;">
            {{ $comment->comment }}
        </div>
    @endforeach

</x-filament::page>