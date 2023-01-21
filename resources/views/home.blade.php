<x-layout>
    @slot ('title')
        Tracker
    @endslot
    
    <div class="container">
        @auth
            <ul class="list-group">
                @foreach (Auth::user()->trackers as $tracker)
                <li class="list-group-item"><a href="{{ route('tracker.show', ['id' => $tracker->id]) }}" class="link link-primary"><h5>{{ $tracker->title }}</h5></a></li>
            @endforeach
            </ul>
            
        @endauth

        @guest
            <div class="text-center">
                <h4>Создавайте трекер привычек и следите за вашими привычками</h4>
            </div>
        @endguest

        <div class="text-center">
            <a href="{{ route('tracker.create') }}" class="btn btn-primary my-3">Создать трекер</a>
        </div>

        <div class="d-flex justify-content-center">
            <table>
                <tr>
                    <th class="p-2">Пн</th>
                    <th class="p-2">Вт</th>
                    <th class="p-2">Ср</th>
                    <th class="p-2">Чт</th>
                    <th class="p-2">Пт</th>
                    <th class="p-2">Сб</th>
                    <th class="p-2">Вс</th>
                </tr>

                @foreach ($month as $week)
                    <tr>
                        @foreach ($week as $day)
                            <td><div class="p-2 @if ($day == date('j')) border border-4 border-secondary @endif">{{ $day }}</div></td>
                        @endforeach
                    </tr>
                @endforeach
                
            </table>
        </div>
    </div>
</x-layout>