<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino</title>
</head>
<body>
    @auth
        <p>ЛЫОВАЛЫВОАЛДВЫОАДЛО</p>
        <form action="{{ route('logout') }}" method="post"> 
            @csrf
            <input type="submit" value="Выйти">
        </form>
    @endauth
    <h1>Ваши карты:</h1>

    @foreach ($cards as $card)
        <p>{{ $card['type'] }} {{ $card['suit'] }}: {{ $card['points'] }}</p>
    @endforeach
    <br>

    <p>Всего: 23</p>

    <button>Еще карту</button>
    <button>Хватит</button>
</body>
</html>