<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Entry - Cairo Zoo - Cangrow Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #fefefe;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        .login-card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            width: 100%;
            max-width: 950px;
            display: flex;
            flex-wrap: wrap;
        }

        .login-image {
            background: url('https://cdn.pixabay.com/photo/2017/09/25/13/12/dog-2785074_1280.jpg') center center/cover no-repeat;
            flex: 1 1 50%;
            min-height: 400px;
        }

        .login-form {
            padding: 3rem 2rem;
            flex: 1 1 50%;
        }

        .brand-title {
            font-weight: 700;
            font-size: 1.75rem;
            color: #ff7f50;
        }

        .pet-icons {
            font-size: 2.5rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
            animation: fadeIn 1s ease-in-out;
        }

        .pet-icon {
            display: inline-block;
            animation-duration: 2s;
            animation-iteration-count: infinite;
        }

        .pet-icon.dog {
            animation-name: bounceDog;
        }

        .pet-icon.cat {
            animation-name: bounceCat;
        }

        @keyframes bounceDog {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes bounceCat {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(10deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }

            .login-image {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container login-wrapper">

    @if ($errors->any())
        <div class="custom-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="custom-alert-badge">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <div class="login-card">

        <!-- Image side (hidden on mobile) -->
        <div class="login-image d-none d-md-block"></div>

        <!-- Login form -->
        <div class="login-form">
            <div class="text-center mb-4">
                <div class="pet-icons mb-2">
                    <span class="pet-icon dog">🐶</span>
                    <span class="pet-icon cat">🐱</span>
                </div>
                <h2 class="brand-title">PetFood </h2>
                <p class="text-muted">Data Entry for Dog & Cat Products</p>
            </div>

            <form method="POST" action="{{ route('dataEntryLogin') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-warning">
                        Login 🐾
                    </button>
                </div>

                <p class="text-center text-muted small">
                    Powered by <a href="https://cangrow-group.com">Cangrow Group </a> 💛
                </p>
            </form>
        </div>

    </div>
</div>

</body>
</html>
