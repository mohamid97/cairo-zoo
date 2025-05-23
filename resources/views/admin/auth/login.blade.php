<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .custom-alert {
            background-color: #ffe6e6;
            border-left: 5px solid #d9534f;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            color: #a94442;
            font-size: 14px;
        }

        .custom-alert ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .custom-alert-badge {
            display: block;
            background-color: #f2dede;
            color: #a94442;
            padding: 8px 12px;
            border-radius: 5px;
            margin-bottom: 6px;
            font-weight: 500;
        }

        * {
            box-sizing: border-box;
        }
        body {
            width: 100vw;
            height: 100vh;
            background-color: #dfeffc;
            overflow: hidden;
            font-size: 12px;
        }
        .inspiration {
            position: fixed;
            bottom: 0;
            right: 0;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            font-family: 'Gill Sans', sans-serif;
            font-size: 12px;
            color: #969696;
        }
        .inspiration img {
            width: 60px;
        }
        .center {
            position: relative;
            top: 50%;
            left: 50%;
            display: inline-block;
            width: 275px;
            height: 490px;
            border-radius: 3px;
            transform: translate(-50%, -50%);
            overflow: hidden;
            background-image: linear-gradient(to top right, #f9a743, #f9db5f);
        }
        @media screen and (max-height: 500px) {
            .center {
                transition: transform 0.5s;
                transform: translate(-50%, -50%) scale(0.8);
            }
        }
        .center .ear {
            position: absolute;
            top: -110px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background-color: #243946;
        }
        .center .ear.ear--left {
            left: -135px;
        }
        .center .ear.ear--right {
            right: -135px;
        }
        .center .face {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 200px;
            height: 150px;
            margin: 80px auto 10px;
            --rotate-head: 0deg;
            transform: rotate(var(--rotate-head));
            transition: transform 0.2s;
            transform-origin: center 20px;
        }
        .center .eye {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: #243946;
        }
        .center .eye.eye--left {
            margin-right: 40px;
        }
        .center .eye.eye--right {
            margin-left: 40px;
        }
        .center .eye .glow {
            position: relative;
            top: 3px;
            right: -12px;
            width: 12px;
            height: 6px;
            border-radius: 50%;
            background-color: #fff;
            transform: rotate(38deg);
        }
        .center .nose {
            position: relative;
            top: 30px;
            transform: scale(1.1);
        }
        .center .nose .glow {
            position: absolute;
            top: 3px;
            left: 32%;
            width: 15px;
            height: 8px;
            border-radius: 50%;
            background-color: #476375;
        }
        .center .mouth {
            position: relative;
            margin-top: 45px;
        }
        .center svg.smile {
            position: absolute;
            left: -28px;
            top: -19px;
            transform: scaleX(1.1);
            stroke: #243946;
        }
        .center .mouth-hole {
            position: absolute;
            top: 0;
            left: -50%;
            width: 60px;
            height: 15px;
            border-radius: 50%/100% 100% 0% 0;
            transform: rotate(180deg);
            background-color: #243946;
            z-index: -1;
        }
        .center .tongue {
            position: relative;
            top: 5px;
            width: 30px;
            height: 20px;
            background-color: #ffd7dd;
            transform-origin: top;
            transform: rotateX(60deg);
        }
        .center .tongue.breath {
            -webkit-animation: breath 0.3s infinite linear;
            animation: breath 0.3s infinite linear;
        }
        .center .tongue-top {
            position: absolute;
            bottom: -15px;
            width: 30px;
            height: 30px;
            border-radius: 15px;
            background-color: #ffd7dd;
        }
        .center .line {
            position: absolute;
            top: 0;
            width: 30px;
            height: 5px;
            background-color: #fcb7bf;
        }
        .center .median {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 25px;
            border-radius: 5px;
            background-color: #fcb7bf;
        }
        .center .hands {
            position: relative;
        }
        .center .hands .hand {
            position: absolute;
            top: -6px;
            display: flex;
            transition: transform 0.5s ease-in-out;
            z-index: 1;
        }
        .center .hands .hand--left {
            left: 50px;
        }
        .center .hands .hand--left.hide {
            transform: translate(2px, -155px) rotate(-160deg);
        }
        .center .hands .hand--left.peek {
            transform: translate(0px, -120px) rotate(-160deg);
        }
        .center .hands .hand--right {
            left: 170px;
        }
        .center .hands .hand--right.hide {
            transform: translate(-6px, -155px) rotate(160deg);
        }
        .center .hands .hand--right.peek {
            transform: translate(-4px, -120px) rotate(160deg);
        }
        .center .hands .finger {
            position: relative;
            z-index: 0;
        }
        .center .hands .finger .bone {
            width: 20px;
            height: 20px;
            border: 2px solid #243946;
            border-bottom: none;
            border-top: none;
            background-color: #fac555;
        }
        .center .hands .finger .nail {
            position: absolute;
            left: 0;
            top: 10px;
            width: 20px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #243946;
            background-color: #fac555;
            z-index: -1;
        }
        .center .hands .finger:nth-child(1),
        .center .hands .finger:nth-child(3) {
            left: 4px;
            z-index: 1;
        }
        .center .hands .finger:nth-child(1) .bone,
        .center .hands .finger:nth-child(3) .bone {
            height: 10px;
        }
        .center .hands .finger:nth-child(3) {
            left: -4px;
        }
        .center .hands .finger:nth-child(2) {
            top: -5px;
            z-index: 2;
        }
        .center .hands .finger:nth-child(1) .nail,
        .center .hands .finger:nth-child(3) .nail {
            top: 0px;
        }
        .center .login {
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .center .login label {
            position: relative;
            padding: 0 20px;
        }
        .center .login label .fa {
            position: absolute;
            top: 40%;
            left: 35px;
            color: #bbb;
        }
        .center .login label .fa:before {
            position: relative;
            left: 1px;
        }
        .center .login input,
        .center .login .login-button {
            width: 100%;
            height: 35px;
            border: none;
            border-radius: 30px;
        }
        .center .login input {
            padding: 0 20px 0 40px;
            margin: 5px 0;
            box-shadow: none;
            outline: none;
        }
        .center .login input::-moz-placeholder {
            color: #ccc;
        }
        .center .login input:-ms-input-placeholder {
            color: #ccc;
        }
        .center .login input::placeholder {
            color: #ccc;
        }
        .center .login input.password {
            padding: 0 90px 0 40px;
        }
        .center .login .password-button {
            position: absolute;
            top: 9px;
            right: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 27px;
            border-radius: 20px;
            border: none;
            outline: none;
            background-color: #243946;
            color: #fff;
        }
        .bx-show {
            font-size: 20px;
        }
        .center .login .password-button:active {
            transform: scale(0.95);
        }
        .center .login .login-button {
            width: calc(100% - 40px);
            margin: 20px 20px 0;
            outline: none;
            background-color: #243946;
            color: #fff;
            transition: transform 0.1s;
        }
        .center .login .login-button:active {
            transform: scale(0.95);
        }
        .center .social-buttons {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }
        .center .social-buttons .social {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 35px;
            height: 35px;
            margin: 0 10px;
            border-radius: 50%;
            background-color: #243946;
            color: #fff;
            font-size: 18px;
        }
        .center .social-buttons .social:active {
            transform: scale(0.95);
        }
        .center .footer {
            text-align: center;
            margin-top: 15px;
        }
        @-webkit-keyframes breath {
            0%, 100% {
                transform: rotateX(0deg);
            }
            50% {
                transform: rotateX(60deg);
            }
        }
        @keyframes breath {
            0%, 100% {
                transform: rotateX(0deg);
            }
            50% {
                transform: rotateX(60deg);
            }
        }



    </style>

    <title>Cairo Zoo - Cangrow Group</title>
</head>
<body>
@if ($errors->any())
    <div class="custom-alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="custom-alert-badge">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="center">


    <div class="ear ear--left"></div>
    <div class="ear ear--right"></div>
    <div class="face">
        <div class="eyes">
            <div class="eye eye--left">
                <div class="glow"></div>
            </div>
            <div class="eye eye--right">
                <div class="glow"></div>
            </div>
        </div>
        <div class="nose">
            <svg width="38.161" height="22.03">
                <path d="M2.017 10.987Q-.563 7.513.157 4.754C.877 1.994 2.976.135 6.164.093 16.4-.04 22.293-.022 32.048.093c3.501.042 5.48 2.081 6.02 4.661q.54 2.579-2.051 6.233-8.612 10.979-16.664 11.043-8.053.063-17.336-11.043z" fill="#243946"></path>
            </svg>
            <div class="glow"></div>
        </div>
        <div class="mouth">
            <svg class="smile" viewBox="-2 -2 84 23" width="84" height="23">
                <path d="M0 0c3.76 9.279 9.69 18.98 26.712 19.238 17.022.258 10.72.258 28 0S75.959 9.182 79.987.161" fill="none" stroke-width="3" stroke-linecap="square" stroke-miterlimit="3"></path>
            </svg>
            <div class="mouth-hole"></div>
            <div class="tongue breath">
                <div class="tongue-top"></div>
                <div class="line"></div>
                <div class="median"></div>
            </div>
        </div>
    </div>
    <div class="hands">
        <div class="hand hand--left">
            <div class="finger">
                <div class="bone"></div>
                <div class="nail"></div>
            </div>
            <div class="finger">
                <div class="bone"></div>
                <div class="nail"></div>
            </div>
            <div class="finger">
                <div class="bone"></div>
                <div class="nail"></div>
            </div>
        </div>
        <div class="hand hand--right">
            <div class="finger">
                <div class="bone"></div>
                <div class="nail"></div>
            </div>
            <div class="finger">
                <div class="bone"></div>
                <div class="nail"></div>
            </div>
            <div class="finger">
                <div class="bone"></div>
                <div class="nail"></div>
            </div>
        </div>
    </div>


    <form action="{{ route('login') }}" method="POST">

    <div class="login">
            @csrf
            <label>
                <div class="fa fa-phone"></div>
                <input class="username" type="email"  name="email" autocomplete="on" placeholder="Email"/>
            </label>
            <label>
                <div class="fa fa-commenting"></div>
                <input class="password" type="password" name="password" autocomplete="off" placeholder="Password"/>
                <button class="password-button"><i class='bx bx-show'></i></button>
            </label>
            <button class="login-button" style="cursor:pointer">Login</button>


    </div>
    </form>
    <div class="social-buttons">
        <div class="social">
            <i class='bx bxl-facebook-circle'></i>
        </div>
        <div class="social">
            <i class='bx bxl-twitter'></i>
        </div>
        <div class="social">
            <i class='bx bxl-github'></i>
        </div>
    </div>
    <div class="footer">Code with <a style="    color: #3b3737;
    font-weight: bold;
    font-size: 14px;
}" href="https://cangrow-group.com"> Cangrow Group</a> </div>

    <script>


        /*
  Inspired by: "Login Page & Homepage"
  By: Neo
  Link: https://dribbble.com/shots/4485321-Login-Page-Homepage
*/

        let usernameInput = document.querySelector('.username');
        let passwordInput = document.querySelector('.password');
        let showPasswordButton = document.querySelector('.password-button');
        let face = document.querySelector('.face');

        passwordInput.addEventListener('focus', event => {
            document.querySelectorAll('.hand').forEach(hand => {
                hand.classList.add('hide');
            });
            document.querySelector('.tongue').classList.remove('breath');
        });

        passwordInput.addEventListener('blur', event => {
            document.querySelectorAll('.hand').forEach(hand => {
                hand.classList.remove('hide');
                hand.classList.remove('peek');
            });
            document.querySelector('.tongue').classList.add('breath');
        });

        usernameInput.addEventListener('focus', event => {
            let length = Math.min(usernameInput.value.length - 16, 19);
            document.querySelectorAll('.hand').forEach(hand => {
                hand.classList.remove('hide');
                hand.classList.remove('peek');
            });

            face.style.setProperty('--rotate-head', `${-length}deg`);
        });

        usernameInput.addEventListener('blur', event => {
            face.style.setProperty('--rotate-head', '0deg');
        });

        usernameInput.addEventListener('input', _.throttle(event => {
            let length = Math.min(event.target.value.length - 16, 19);

            face.style.setProperty('--rotate-head', `${-length}deg`);
        }, 100));

        showPasswordButton.addEventListener('click', event => {
            if (passwordInput.type === 'text') {
                passwordInput.type = 'password';
                document.querySelectorAll('.hand').forEach(hand => {
                    hand.classList.remove('peek');
                    hand.classList.add('hide');
                });
            } else {
                passwordInput.type = 'text';
                document.querySelectorAll('.hand').forEach(hand => {
                    hand.classList.remove('hide');
                    hand.classList.add('peek');
                });
            }
        });




    </script>
</body>



</html>
