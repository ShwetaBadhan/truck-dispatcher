<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Theme Style (Wrapped in asset() helper) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.png') }}">
</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="login-page">
                <div class="left">
                    <img src="{{ asset('images/images-section/sign-in.jpg') }}" alt="image">
                </div>
                <div class="right">
                    <div class="login-box">
                        
                        <!-- UPDATED FORM -->
                        <form class="form-login flex flex-column gap22 w-full" method="POST" action="{{ route('login') }}">
                            @csrf <!-- Prevents Laravel 419 Page Expired errors -->

                            <div>
                                <h3>Login to account</h3>
                                <div class="body-text text-white">Or enter your email & password to login</div>
                            </div>

                            {{-- Display Validation Errors (Wrong password, inactive account, etc.) --}}
                            @if($errors->any())
                                <div style="color: #ff4d4d; background: rgba(255,0,0,0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <fieldset class="email">
                                <div class="body-title mb-10 text-white">Email address <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="email" placeholder="Enter your email address" name="email" tabindex="0" value="{{ old('email') }}" required>
                            </fieldset>

                            <fieldset class="password">
                                <div class="body-title mb-10 text-white">Password <span class="tf-color-1">*</span></div>
                                <input class="password-input" type="password" placeholder="Enter your password" name="password" tabindex="0" required>
                                <span class="show-pass">
                                    <i class="icon-eye view"></i>
                                    <i class="icon-eye-off hide"></i>
                                </span>
                            </fieldset>
                          
                            <button type="submit" class="tf-button w-full">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Javascript -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script defer src="{{ asset('js/main.js') }}"></script>
</body>
</html>