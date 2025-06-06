<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    @auth
        <form action="{{ route('logout') }}" method="post"> 
            @csrf
            <input type="submit" value="Выйти">
        </form>
    @endauth

    <p>Карты диллера: </p>
    @foreach ($croupiers_cards as $card)
        <p>{{ $card->type }} {{ $card->suit }}</p>    
    @endforeach
    

    <p>Ваши карты: </p>
    @foreach ($users_cards as $card)
        <p>{{ $card->type }} {{ $card->suit }}</p>    
    @endforeach

    <form action="{{ route('cards.store', $game) }}}}" method="post">
        @csrf
        <button type="submit">Еще карта</button>
    </form>
    <a><button>Удвоить ставку</button></a>
    <a><button>Достаточно</button></a>
    <a href="{{ route('games.destroy', $game) }}"><button>Отказ от игры</button></a>

</body>
<script>
    $('document').ready(function(){
        @if ($isCroupiersMove)
            $.ajax({
                method: "POST",
                url: "{{ route('croupier', $game) }}",
                data: {
                    _token : "{{ csrf_token() }}"
                }
            })
            .done(function() {
                console.log('Ход крупье'); 
            });
        @endif

        @if ($isUserHasMoreChips)
            $.ajax({
                method: "DELETE",
                url: "{{ route('games.destroy', $game) }}",
                data: {
                    _token : "{{ csrf_token() }}"
                }
            })
            .done(function() {
                console.log('слишком много фишек'); 
            });
        @endif

        @if ($isGameOver)
            $.ajax({
                method: "DELETE",
                url: "{{ route('games.destroy', $game) }}",
                data: {
                    _token : "{{ csrf_token() }}"
                }
            })
            .done(function() {
                console.log('игра окончена'); 
            });
        @endif
    });
    
</script>
</html>