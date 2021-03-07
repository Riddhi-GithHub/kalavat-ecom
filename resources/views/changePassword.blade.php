<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>Kalavat - Change Password</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="{{ url('public/img/favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ url('public/files/css/theme-default.css') }}"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        
     <div class="login-container">
        <div class="login-box animated fadeInDown">
            <div style="text-align: center;font-size: 26px; color: #ffffff;margin-bottom: 5px;">Kalavat</div>
            <div class="login-body">
               <div class="login-title">Reset Your Password</div>
                @include('message')
               <form action="{{ route('password') }}" class="form-horizontal" method="post">
               {{ csrf_field() }}
               <div class="form-group">
                  <div class="col-md-12">
                     {{-- <input type="text" class="form-control" value="{{$user->id}}" required="" name="email" placeholder="Email"/> --}}
                     <input id="id" type="hidden" class="form-control" name="id"  value="{{$user->id}}">
                  </div>
               </div>
                  <div class="form-group">
                     <div class="col-md-12">
                        {{-- <input type="text" class="form-control" value="{{$user->email}}" required="" name="email" placeholder="Email"/> --}}
                        <input id="email" type="text" class="form-control" name="email"  value="{{$user->email}}">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-12">
                        {{-- <input type="password" id="new_password" class="form-control" value="" required="" name="new_password" placeholder="New Password" autocomplete="current-password"/> --}}
                        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password" placeholder="New Password">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-12">
                        {{-- <input type="password" class="form-control" value="" required="" name="password" placeholder="New Confirm Password"/> --}}
                        <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" placeholder="New Confirm Password" autocomplete="current-password">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-6">
                     </div>
                     <div class="col-md-6">
                        {{-- <button class="btn btn-info btn-block">Log In</button> --}}
                        <button type="submit" class="btn btn-info btn-block">
                           Reset Password
                       </button>
                     </div>
                  </div>
                  <div class="login-subtitle">
                  </div>
               </form>
            </div>
            <div class="login-footer">
               <div class="pull-left">
                  @ {{ date('Y') }} Kalavat
               </div>
            </div>
         </div>
      </div>

        <!-- START PLUGINS -->
      <script type="text/javascript" src="{{ url('public/files/js/plugins/jquery/jquery.min.js') }}"></script>
      <script type="text/javascript" src="{{ url('public/files/js/plugins/jquery/jquery-ui.min.js') }}"></script>
      <script type="text/javascript" src="{{ url('public/files/js/plugins/bootstrap/bootstrap.min.js') }}"></script>
      <!-- END PLUGINS -->
        
    </body>
</html>






