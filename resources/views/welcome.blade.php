<!DOCTYPE html>
<html lang="en">



<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
@yield('seo')
  <!-- icofont-css-link -->
  <link rel="stylesheet" href="{{asset('assets/css/icofont.min.css')}}">
  <!-- Owl-Carosal-Style-link -->
  <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
  <!-- Bootstrap-Style-link -->
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
  <!-- Aos-Style-link -->
  <link rel="stylesheet" href="{{asset('assets/css/aos.css')}}">
  <!-- Coustome-Style-link -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}?version={{ \Str::random(34) }}">
  <!-- Responsive-Style-link -->
  <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}?version={{ \Str::random(34) }}">
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{asset('assets/favicon.png')}}" type="image/png">

</head>

<body>

  <!-- Page-wrapper-Start -->
  <div class="page_wrapper">

    <!-- Preloader -->
    <div id="preloader">
      <div id="loader"></div>
    </div>

    <!-- Header Start -->
    <header  class="@if(url()->current()!=url('/')) white_header @endif">
      <!-- container start -->
      <div class="container">
      	<!-- navigation bar -->
        <nav class="navbar navbar-expand-lg">
          <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('assets/logo.png')}}" alt="image" >
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
              <!-- <i class="icofont-navigation-menu ico_menu"></i> -->
              <div class="toggle-wrap">
                <span class="toggle-bar"></span>
              </div>
            </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="ml-auto navbar-nav">
              <!-- secondery menu start -->
              <li class="nav-item ">
                <a class="nav-link" href="{{url('/')}}">Home</a>

              </li>
              <!-- secondery menu end -->

              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#features">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#how_it_work">How it works</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">About us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('terms') }}">Terms </a>
              </li>
               <li class="nav-item">
                <a class="nav-link" href="{{ route('privacy') }}">privacy </a>
              </li>
              <!-- secondery menu end -->





              <li class="nav-item">
                <a class="nav-link dark_btn" href="{{ url('/') }}#appbutton">GET STARTED</a>
              </li>
            </ul>
          </div>
        </nav>
        <!-- navigation end -->
      </div>
      <!-- container end -->
    </header>

@yield('body')


    <!-- Footer-Section start -->
    <footer>
        <div class="top_footer" id="contact">
          <!-- animation line -->
          <div class="anim_line dark_bg">
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{asset('assets/images/anim_line.png')}}" alt="anim_line"></span>
          </div>
          	<!-- container start -->
            <div class="container">
              <!-- row start -->
              <div class="row">
              	  <!-- footer link 1 -->
                  <div class="col-lg-4 col-md-6 col-12">
                      <div class="abt_side">
                        {{-- <div class="logo"> <img src="{{asset('assets/images/footer_logo.png')}}" alt="image" ></div> --}}
                        <ul>
                          <li><a href="mailto:admin@semibill.com">admin@semibill.com</a></li>
                          <li><a href="tel:2348153922022">+234 815 392 20227</a></li>
                        </ul>
                        <ul class="social_media">
                            <li><a href="https://www.facebook.com/semibillhq?mibextid=LQQJ4d"><i class="icofont-facebook"></i></a></li>
                            <li><a href="https://x.com/semibillafrica?s=21"><i class="icofont-twitter"></i></a></li>
                            <li><a href="https://www.instagram.com/semibillafrica?igsh=dWJzZmt5aHp2Y2Rz"><i class="icofont-instagram"></i></a></li>
                            <li><a href="https://www.linkedin.com/company/semibillafrica/"><i class="icofont-linkedin"></i></a></li>
                        </ul>
                      </div>
                  </div>

                  <!-- footer link 2 -->
                  <div class="col-lg-3 col-md-6 col-12">
                      <div class="links">
                        <h3>Useful Links</h3>
                          <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About us</a></li>

                          </ul>
                      </div>
                  </div>

                  <!-- footer link 3 -->
                  <div class="col-lg-3 col-md-6 col-12">
                    <div class="links">
                      <h3>Help & Suport</h3>
                        <ul>


                          <li><a href="{{ route('terms') }}">Terms & conditions</a></li>
                          <li><a href="{{ route('privacy') }}">Privacy policy</a></li>
                        </ul>
                    </div>
                  </div>

                  <!-- footer link 4 -->
                  <div class="col-lg-2 col-md-6 col-12">
                    <div class="try_out">
                        <h3>Let’s Try Out</h3>
                        <ul class="app_btn">
                          <li>
                            <a href="#">
                              <img src="{{asset('assets/images/appstore_blue.png')}}" alt="image" >
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <img src="{{asset('assets/images/googleplay_blue.png')}}" alt="image" >
                            </a>
                          </li>
                        </ul>
                    </div>
                  </div>
              </div>
              <!-- row end -->
          </div>
          <!-- container end -->
        </div>

        <!-- last footer -->
        <div class="bottom_footer">
        	<!-- container start -->
            <div class="container">
              <!-- row start -->
              <div class="row">
                <div class="col-md-6">
                    <p>© Copyrights {{ date('Y') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6">
                    <p class="developer_text">Design & developed by <a href="{{ url('/') }}" target="blank">Semibill</a></p>
                </div>
            </div>
            <!-- row end -->
            </div>
            <!-- container end -->
        </div>

        <!-- go top button -->
        <div class="go_top">
            <span><img src="{{asset('assets/images/go_top.png')}}" alt="image" ></span>
        </div>
    </footer>
    <!-- Footer-Section end -->

  <!-- VIDEO MODAL -->
  <div class="modal fade youtube-video" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <button id="close-video" type="button" class="text-right button btn btn-default" data-dismiss="modal">
            <i class="icofont-close-line-circled"></i>
          </button>
            <div class="modal-body">
                <div id="video-container" class="video-container">
                    <iframe id="youtubevideo" src="#" width="640" height="360" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>

  <div class="purple_backdrop"></div>

  </div>
  <!-- Page-wrapper-End -->

  <!-- Jquery-js-Link -->
  <script src="{{asset('assets/js/jquery.js')}}"></script>
  <!-- owl-js-Link -->
  <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
  <!-- bootstrap-js-Link -->
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <!-- aos-js-Link -->
  <script src="{{asset('assets/js/aos.js')}}"></script>
  <!-- main-js-Link -->
  <script src="{{asset('assets/js/main.js')}}"></script>
@yield('js')
</body>

</html>
