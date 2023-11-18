<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Arquivo Falhou</title>
    <style>
        /* Adicione estilos adicionais conforme necessário */
        body {
            font-family      : 'Arial', sans-serif;
            margin           : 0;
            padding          : 0;
            background-color : #f4f4f4;
        }

        .container {
            width    : 80%;
            margin   : auto;
            overflow : hidden;
        }

        header {
            background    : #fff;
            border-bottom : 1px solid #ccc;
        }

        header::after {
            content : '';
            display : table;
            clear   : both;
        }

        .logo {
            float   : left;
            padding : 10px 0;
        }

        .logo img {
            height : 50px;
        }

        nav {
            float       : right;
            padding-top : 15px;
        }

        nav ul {
            margin     : 0;
            padding    : 0;
            list-style : none;
        }

        nav li {
            display     : inline;
            margin-left : 20px;
            font-weight : bold;
        }

        nav a {
            text-decoration : none;
            color           : #333;
            font-size       : 16px;
        }

        .main {
            padding : 20px 0;
        }

        h2 {
            color : #333;
        }

        p {
            font-size : 18px;
            color     : #666;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <div class="logo">
            <img src="{{ asset('path/to/your/logo.png') }}" alt="Your Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <!-- Adicione mais itens de navegação, se necessário -->
            </ul>
        </nav>
    </header>

    <div class="main">
        <h2>Importação de Arquivo Funcionou!</h2>
        <p>Olá, {{ $userName }}!</p>
        <p>O arquivo foi importado com sucesso!</p>
        <p>Obrigado,<br>Equipe {{ config('app.name') }}</p>
    </div>
</div>
</body>
</html>
