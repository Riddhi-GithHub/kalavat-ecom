<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Kalavat | {!! !empty($meta_title) ? $meta_title : '' !!} </title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
         <link rel="icon" href="{{ url('public/img/favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ url('public/files/css/theme-default.css') }}"/>
        <!-- EOF CSS INCLUDE -->     
        <style type="text/css">
  
        </style>
        @yield('style')                                  
    </head>
    <body>

        <div class="page-container">
         @include('backend.layouts._sidebar')
         <!-- START PAGE SIDEBAR -->
         <!-- END PAGE SIDEBAR -->
         <!-- PAGE CONTENT -->
         <div class="page-content">
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
               <!-- TOGGLE NAVIGATION -->
               <li class="xn-icon-button">
                  <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
               </li>
               <!-- END TOGGLE NAVIGATION -->
               <!-- SIGN OUT -->
               <li class="xn-icon-button pull-right">
                  <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
               </li>
               <li class="xn-icon-button pull-right">
                  <div style="margin-top: 16px;color: #fff;font-size: 14px;margin-right: 12px;">Welcome {{ Auth::user()->name }}</div>
               </li>
               <!--END SIGN OUT -->
            </ul>
            <!-- MESSAGE BOX-->
            <div class="message-box animated fadeIn"  id="mb-signout">
               <div class="mb-container">
                  <div class="mb-middle">
                     <div class="mb-title"><span class="fa fa-sign-out"></span> Log Out?</div>
                     <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                     </div>
                     <div class="mb-footer">
                        <div class="pull-right">
                           <a href="{{ url('admin/logout') }}" class="btn btn-success btn-lg">Yes</a>
                           <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @yield('content')
            <!-- END PAGE CONTENT WRAPPER -->
         </div>
         <!-- END PAGE CONTENT -->
      </div>


      



       <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{ url('public/files/audio/alert.mp3') }}" preload="auto"></audio>
        <audio id="audio-fail" src="{{ url('public/files/audio/fail.mp3') }}" preload="auto"></audio>
        <!-- END PRELOADS -->                      

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{ url('public/files/js/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('public/files/js/plugins/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('public/files/js/plugins/bootstrap/bootstrap.min.js') }}"></script>        
        <!-- END PLUGINS -->
        
        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src="{{ url('public/files/js/plugins/icheck/icheck.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('public/files/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
        
        <script type="text/javascript" src="{{ url('public/files/js/demo_tables.js') }}"></script>     
        <!-- END THIS PAGE PLUGINS-->  
        
        <!-- START TEMPLATE -->
        
        
        <script type="text/javascript" src="{{ url('public/files/js/plugins.js') }}"></script>        
        <script type="text/javascript" src="{{ url('public/files/js/actions.js') }}"></script>        
        <!-- END TEMPLATE -->
        @yield('script')
        <script type="text/javascript">
            
        </script>

    <!-- END SCRIPTS -->                 
    </body>
</html>

