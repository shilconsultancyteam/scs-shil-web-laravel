<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Shil Consultancy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #6e45e2;
            --secondary: #88d3ce;
            --accent: #ff7e5f;
            --dark: #0f0e17;
            --light: #fffffe;
            --dark-2: #1a1a2e;
            --dark-3: #24243e;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark);
            color: var(--light);
        }

        .orbitron {
            font-family: 'Orbitron', sans-serif;
        }

        .gradient-text {
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradient 8s ease infinite;
            background-size: 400% 400%;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-dark">
    <div class="w-full max-w-sm rounded-3xl p-8 shadow-2xl" style="background: var(--dark-2);">
        <h2 class="text-3xl text-center orbitron font-bold mb-6 gradient-text">RESET PASSWORD</h2>

        @if (session('status'))
            <div class="mb-4 p-4 rounded-xl" style="background: var(--dark-3); border: 1px solid var(--secondary);">
                <p class="text-secondary text-sm">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <p class="text-gray-400 text-sm text-center mb-4">
                Enter your email address and we'll send you a password reset link.
            </p>

            <!-- Email Input -->
            <div>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required autofocus
                    class="mt-1 w-full rounded-full bg-transparent border-2 border-transparent focus:border-primary focus:ring-0 shadow-sm p-3 text-light placeholder-gray-500 transition-all duration-300"
                    style="background: var(--dark-3); outline: none;"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-400 text-sm mt-2 ml-3">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full py-3 px-4 font-semibold rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
                    style="background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));">
                    <span class="text-dark-2 orbitron">Send Reset Link</span>
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-secondary hover:underline font-medium text-sm">
                    ← Back to Login
                </a>
            </div>
        </form>
    </div>
</body>
</html>