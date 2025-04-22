<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('main.login_ecommerce') }}</title> <!-- Use translation for title -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .35);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }

        h1 {
            font-size: 25px;
        }

        .container p {
            font-size: 14px;
            line-height: 20px;
            letter-spacing: .3px;
            margin: 20px 0;
        }

        .container span {
            font-size: 12px;
        }

        .container a {
            color: #333;
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
        }

        .container button {
            background-color: #512da8;
            color: #fff;
            font-size: 12px;
            padding: 10px 45px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container button.hidden {
            background-color: transparent;
            border-color: #fff;
        }

        .container form {
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 40px 0;
            height: 100%;
        }

        .container input {
            background-color: #eee;
            border: none;
            margin: 8px 0;
            padding: 10px 15px;
            font-size: 13px;
            border-radius: 8px;
            width: 100%;
            outline: none;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all .6s ease-in-out;
        }

        .sign-in {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.active .sign-in {
            transform: translateX(100%);
        }

        .sign-up {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.active .sign-up {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move .6s;
        }

        @keyframes move {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .social-icons {
            margin: 20px 0;
        }

        .social-icons a {
            border: 1px solid #ccc;
            border-radius: 20%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 3px;
            width: 40px;
            height: 40px;
        }

        .toggle-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all .6s ease-in-out;
            border-radius: 150px 0 0 100px;
            z-index: 1000;
        }

        .container.active .toggle-container {
            transform: translateX(-100%);
            border-radius: 0 150px 100px 0;
        }

        .toggle {
            background-color: #512da8;
            height: 100%;
            background: linear-gradient(to right, #5c6bc0, #512da8);
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translate(0);
            transition: all .6s ease-in-out;
        }

        .container.container.active .toggle {
            transform: translateX(50%);
        }

        .toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 30px;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: all .6s ease-in-out;
        }

        .toggle-left {
            transform: translateX(-200%);
        }

        .container.active .toggle-left {
            transform: translateX(0);
        }

        .toggle-right {
            right: 0;
            transform: translateX(0);
        }

        .container.active .toggle-right {
            transform: translateX(200%);
        }

        .alert {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="container" id="container">

    <div class="form-container sign-up">
        <form action="" method="POST">
            <h1>{{ __('main.cangrow_group') }}</h1> <!-- Translate heading -->
            <div class="social-icons">
                <a href="https://www.instagram.com/cangrow_group1?igsh=MWpid2NkOHFucmJreA==" class="icon" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="YOUR_FACEBOOK_LINK" class="icon" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="YOUR_YOUTUBE_LINK" class="icon" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                <a href="YOUR_TWITTER_LINK" class="icon" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
            </div>
            <span>{{ __('main.use_email_to_register') }}</span> <!-- Translate span text -->
            <p>{{ __('main.please_visit') }}</p> <!-- Translate paragraph -->
        </form>
    </div>

    <div class="form-container sign-in">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <h1>{{ __('main.sign_in') }}</h1> <!-- Translate heading -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="social-icons">
                <a href="https://www.instagram.com/cangrow_group1?igsh=MWpid2NkOHFucmJreA==" class="icon" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-youtube"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-linkedin"></i></a>
            </div>
            <span>{{ __('main.use_email_password') }}</span> <!-- Translate span text -->
            <input type="email" name="email" placeholder="{{ __('main.email') }}" required> <!-- Translate placeholder -->
            <input type="password" name="password" placeholder="{{ __('main.password') }}" required> <!-- Translate placeholder -->

            <button>{{ __('main.sign_in') }}</button> <!-- Translate button text -->
        </form>
    </div>

    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>{{ __('main.welcome_cangrow') }}</h1> <!-- Translate heading -->
                <p>{{ __('main.welcome_message') }}</p> <!-- Translate paragraph -->
                <button class="hidden" id="login">{{ __('main.back') }}</button> <!-- Translate button text -->
            </div>

            <div class="toggle-panel toggle-right">
                <h1>{{ __('main.welcome_cangrow') }}</h1> <!-- Translate heading -->
                <p>{{ __('main.dashboard_message', ['shop' => 'Imtiaz Shop']) }}</p> <!-- Translate paragraph with dynamic content -->
                <button class="hidden" id="register">{{ __('main.more') }}</button> <!-- Translate button text -->
            </div>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById("container");
    const registerBtn = document.getElementById("register");
    const loginBtn = document.getElementById("login");

    registerBtn.addEventListener("click", () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener("click", () => {
        container.classList.remove("active");
    });
</script>
</body>
</html>
