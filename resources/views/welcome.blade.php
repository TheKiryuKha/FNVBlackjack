<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino</title>
</head>
<body>
    @auth
        <form action="{{ route('logout') }}" method="post"> 
            @csrf
            <input type="submit" value="Выйти">
        </form>
    @endauth

    <p>
        Текущая ставка: <input type="number" id="numericInput" min="0" max="200" value="0">
    </p>
    <p>Всего фишек: {{ auth()->user()->chips }}</p>
    <p>Выиграно: {{ auth()->user()->chipsWon }}</p>

    <button>Играть</button>
    <button onclick="setMaxValue()">Макс. ставка</button>
    <button onclick="setPlusOne()">Увеличить ставку</button>
    <button onclick="setMinusOne()">Уменьшить ставку</button>

</body>

<script>
    function setMaxValue() {
        document.getElementById('numericInput').value = 200;
    }

    function setPlusOne(){
        if(document.getElementById('numericInput').value < 200){
            document.getElementById('numericInput').value++;
        }
    }

    function setMinusOne(){
        if(document.getElementById('numericInput').value > 0){
            document.getElementById('numericInput').value--;
        } 
    }
</script>
</html>