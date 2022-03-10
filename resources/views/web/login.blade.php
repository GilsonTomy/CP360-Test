<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Login - Form Gen App" />
        <meta name="author" content="" />
        <title>Login - Form Gen App</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form name="loginForm" id="loginForm" autocomplete="off" action="{{ route('web.login.submit') }}" method="post">
                                            {{ csrf_field() }}
                                            @if (session()->get('errorLogin'))
                                                <div class="alert bg-danger alert-danger text-white mg-b-0" role="alert">
                                                    {{-- <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                                                        <span aria-hidden="true">&times;</span></button> --}}
                                                    {{ session()->get('errorLogin') }}
                                                </div>
                                            @endif
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="email" name="email" value="{{ old('email') }}" type="text" placeholder="Enter your email" />
                                                <label for="email">Email</label>
                                                @if ($errors->has('email'))
                                                    <div class="tags mt-1">
                                                        <span class="alert-danger">{{ $errors->first('email') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" name="password" value="{{ old('password') }}" type="password" placeholder="Enter your password" />
                                                <label for="password">Password</label>
                                                @if ($errors->has('password'))
                                                    <div class="tags mt-1">
                                                        <span class="alert-danger">{{ $errors->first('password') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" @if(old('remember_me')){{ 'checked="checked"' }}@endif  id="remember_me" name="remember_me" type="checkbox" value="1" />
                                                <label class="form-check-label" for="remember_me">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary">Login</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; {{ date('Y') }}</div>
                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
