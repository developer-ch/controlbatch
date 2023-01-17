<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * {
            scrollbar-width: auto;
            scrollbar-color: blue orange;
        }

        /* Works on Chrome, Edge, and Safari*/
        *::-webkit-scrollbar {
            width: 12px;
        }

        *::-webkit-scrollbar-track {
            background: orange;
        }

        *::-webkit-scrollbar-thumb {
            background-color: blue;
            border-radius: 20px;
            border: 3px solid orange;
        }

        body {
            margin: 0;
            padding: 0;
        }

        table {
            text-align: left;
            position: relative;
            border-collapse: collapse;
        }

        table tr>td {
            padding: 0.3rem 0.6rem;
            border-bottom: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-left: 1px solid #ccc
        }

        table>thead>tr>th {
            background: darkblue;
            position: sticky;
            top: 0 ;
            /* Don't forget this, required for the stickiness */
            color: #ffffff;
            padding: 0.3rem 0.6rem;
            min-width: 6rem;
        }
    </style>
</head>

<body>
    @include('templates.includes.message')
    @yield('page')
    @yield('actions')
    @yield('listing')
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>M.AutoInit()</script>
    @stack('scripts')
</body>
</html>
