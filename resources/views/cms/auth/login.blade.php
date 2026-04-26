<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Artisan Hub | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/summernote/summernote-bs4.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <style>

        
  body.login-page {

    background: linear-gradient(rgba(30, 60, 114, 0.8), rgba(42, 82, 152, 0.8)),
                url('https://images.unsplash.com/photo-1513519245088-0e12902e5a38?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif !important;
  }

  .login-box {
    margin-top: 0;
  }


  .login-card-body {
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
  }

  .login-logo a {
    color: #fff !important;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    font-weight: 800;
    letter-spacing: 1px;
  }


  .btn-primary {
    background: linear-gradient(45deg, #1e3a8a, #3b82f6);
    border: none;
    border-radius: 8px;
    transition: 0.3s;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
  }


  .form-control {
    border-radius: 8px;
  }

  .input-group-text {
    border-radius: 0 8px 8px 0 !important;
  }
</style>


</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="cms/index2.html"><b>Artisan</b>Hub</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your own world</p>

      <form action="cms/index3.html" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="Password" class="form-control" id="password" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          {{-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> --}}
          <!-- /.col -->
          <div class="col-4">
            <button type="button" onclick="login()" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        {{-- <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a> --}}
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/crud.js') }}"></script>


<script>

   function login(){
      axios.post('/cms/login', {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    })
    .then(function (response) {
      window.location.href = response.data.url;
    })
    .catch(function (error) {

            if (error.response && error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else if (error.response) {
                showMessage(error.response.data);
            } else {
                console.error(error);
            }
        });
    }








</script>


</body>
</html>
