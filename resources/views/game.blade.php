<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
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

    <form action="{{ route('getCard', $game) }}}}" method="post">
        @csrf
        <button type="submit">Еще карта</button>
    </form>
    <a><button>Удвоить ставку</button></a>
    <a><button>Достаточно</button></a>
    <a><button>Отказ от игры</button></a>

</body>
</html>