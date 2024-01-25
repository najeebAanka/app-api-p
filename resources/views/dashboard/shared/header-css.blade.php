<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{url('')}}/dist/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('')}}/dist/assets/img/favicon.ico" type="image/x-icon">
    <title>test Dashboard | Home</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/feather-icon.css')}}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('dashboard/assets/css/color-3.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/responsive.css')}}">
    <style>



        @-webkit-keyframes fadeinout {
            0%,100% {
                opacity: 0.1;
            }
            50% {
                opacity: 1;
            }
        }

        @keyframes fadeinout {
            0%,100% {
                opacity: 0.1;
            }
            50% {
                opacity: 1;
            }
        }



        @-webkit-keyframes fadeinout-l {
            0%,100% {
                background-color: #fff;
            }
            50% {
                background-color: #fbff5f;
            }
        }

        @keyframes fadeinout-l {
            0%,100% {
                background-color: #fff;
            }
            50% {
                background-color: #fbff5f;
            }
        }


        p.sender {
            color: #0067b9;
        }


        p.name-service {
            font-weight: bold;
            font-size: 1.3rem;

        }
        p.time-elapsed {
            background-color: #e5f4ff;
            padding: 0.4rem;
            font-weight: bold;
            font-style: italic;
        }

        span.p-orp {
            position: absolute;
            padding: 0.3rem;
            top: 0px;
            right: 0px;
            border-radius: 0rem 0rem 0rem 1rem;
            padding: 0.5rem 1rem;
        }

        .animated-p{
            -webkit-animation: fadeinout 3s linear forwards;
            animation: fadeinout 3s linear forwards;
            animation-iteration-count: infinite;
        }
        .green-light-bg{
            background-color: #e1ffe3 !important;
        }
        .pending{
            background-color: #fff598;
            -webkit-animation: fadeinout 3s linear forwards;
            animation: fadeinout 3s linear forwards;
            animation-iteration-count: infinite;
            box-shadow: 0px 5px 9px #ccc;
            top: -5px;
            right: -7px;
        }

        .approved{
            background-color: #e0ffe3;

        }
        .rejected{
            background-color: #ffe0e0;
        }

        .notification-box {
            padding: 0.5rem;
            background-color: #f8f8f8;

            margin-bottom: 0.1rem;
        }
        .notification-box i {
            color: #858585;
            font-weight: normal
        }
        .notification-box p {
            color: #4a4c00;
        }
        .notification-box:hover{
            background-color: #fcff88;
            cursor: pointer;
              transition: all 0.5s ease-in-out;
        }

        .single-card-square{
            padding: 1rem;
            text-align: center;
            border: solid 1px  #ededed;
            min-height: 14rem;

            background-color: #fff;
            margin: 1rem;
            cursor: pointer;
        }
        .single-card-square img{
            max-width: 100px;
        }
        .single-card-square:hover{
            box-shadow: 0px 4px 18px #ccc;
            -webkit-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }
        .prof-row:hover{
            box-shadow: 0px 4px 18px #ccc;
            -webkit-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }
        .single-card-square p{
            margin-top: 2rem;
            font-weight: bold;
        }

        .prof-row {
            background-color: #fff;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
        }
        .prof-row img{
            float: right;
            width: 102px;

        }
        p.name {
            font-weight: bold;
        }


        .map-label{
            background-color: #fff;
            font-family: 'Century Gothic';
            font-style: italic;
            border-radius: 4px;
            padding: 5px;
            color: #0067b9;
            -webkit-animation: fadeinout-l 1.5s linear forwards;
            animation: fadeinout-l 1.5s linear forwards;
            animation-iteration-count: infinite;
            box-shadow: 2px 2px 5px #ccc;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #fff;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #9cc0f9;
            border-radius: 5px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
              transition: all 0.5s ease-in-out;
              
        }
        #updates-container{
            overflow: auto;
            scroll-behavior: smooth;
            max-height: 39rem;
              transition: all 0.5s ease-in-out;
        }

    </style>
</head>