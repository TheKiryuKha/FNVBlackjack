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

    <div class="croupiers_cards">
        <p>Карты диллера: </p>
        @foreach ($croupiers_cards as $card)
            <p>{{ $card->type }} {{ $card->suit }}</p>    
        @endforeach
    </div>

    <div class="users_cards">
        <p>Ваши карты: </p>
        @foreach ($users_cards as $card)
            <p>{{ $card->type }} {{ $card->suit }}</p>    
        @endforeach
    </div>

    <button class="addCard">Еще карта</button>
    
    <button class="doubleBet">Удвоить ставку</button>
    <button class="enough">Достаточно</button>
    <button class="stopGame">Отказ от игры</button>

</body>
<script>
    $('document').ready(function(){
        
        $('button.addCard').on('click', function(){
            $.ajax({
                method: "POST",
                url: "{{ route('cards.store', $game) }}",
                data: {
                    _token : "{{ csrf_token() }}"
                },
                dataType: 'json'
            })
            .done(function(response) {
                $('.users_cards').find('p:not(:first)').remove();
    
                // Добавляем новые карты
                response.user_cards.forEach(function(card) {
                    $('.users_cards').append('<p>' + card.type + ' ' + card.suit + '</p>');
                }); 
            });
        });

        $('button.doubleBet').on('click', function(){
            $.ajax({
                method: "PATCH",
                url: "{{ route('games.update', $game) }}",
                data: {
                    _token : "{{ csrf_token() }}"
                },
                dataType: 'json'
            })
            .done(function() {
                console.log('ставка удвоена!');
            });
        });

        $('button.enough').on('click', function(){
            $.ajax({
                method: "POST",
                url: "{{ route('croupier', $game) }}",
                data: {
                    _token : "{{ csrf_token() }}"
                },
                dataType: 'json'
            })
            .done(function(response) {
                $('.croupiers_cards').find('p:not(:first)').remove();
    
                // Добавляем новые карты
                response.croupiers_cards.forEach(function(card) {
                    $('.croupiers_cards').append('<p>' + card.type + ' ' + card.suit + '</p>');
                });

                console.log('крупье получил свой карты');
            });
        });

        $('button.stopGame').on('click', function(){
            $.ajax({
                method: "DELETE",
                url: "{{ route('games.destroy', $game) }}",
                data: {
                    _token : "{{ csrf_token() }}"
                },
                dataType: 'json'
            })
            .done(function() {
                console.log('игра удалена');
            });
        });


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