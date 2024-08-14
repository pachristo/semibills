@extends('welcome')

@section('title')
    welcome to semibill.com
@endsection
@section('body')
<style>


.features_section .feature_detail .feature_img img {
    max-width: 300px;
}

    </style>
    <!-- Banner-Section-Start -->
    <section class="banner_section">
        <!-- container start -->
        <div class="container">
            <!-- vertical animation line -->
            <div class="anim_line">
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/images/anim_line.png') }}" alt="anim_line"></span>
            </div>
            <!-- row start -->
            <div class="row">
                <div class="col-lg-6 col-md-12" data-aos="fade-right" data-aos-duration="1500">
                    <!-- banner text -->
                    <div class="banner_text">
                        <!-- h1 -->
                        <h1>Enjoy easy <span> payment Solution.</span></h1>
                        <!-- p -->
                        <p> We offer a simple, fast, and secure way to pay your utility bills, and even place bets all in
                            one place.
                        </p>
                    </div>
                    <!-- app buttons -->
                    <ul class="app_btn" id="appbutton">
                        <li>
                            <a href="#">
                                <img class="blue_img" src="{{ asset('assets/images/appstore_blue.png') }}" alt="image">
                                <img class="white_img" src="{{ asset('assets/images/appstore_white.png') }}"
                                    alt="image">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img class="blue_img" src="{{ asset('assets/images/googleplay_blue.png') }}"
                                    alt="image">
                                <img class="white_img" src="{{ asset('assets/images/googleplay_white.png') }}"
                                    alt="image">
                            </a>
                        </li>
                    </ul>

                    <!-- users -->
                    {{-- <div class="used_app">
                <ul>
                  <li><img src="{{asset('assets/images/used01.png')}}" alt="image" ></li>
                  <li><img src="{{asset('assets/images/used02.png')}}" alt="image" ></li>
                  <li><img src="{{asset('assets/images/used03.png')}}" alt="image" ></li>
                  <li><img src="{{asset('assets/images/used04.png')}}" alt="image" ></li>
                </ul>
                <p>12M + <br> used this app</p>
              </div> --}}
                </div>

                <!-- banner slides start -->
                <div class="col-lg-6 col-md-12" data-aos="fade-in" data-aos-duration="1500">
                    <div class="banner_slider">
                        <div class="left_icon">
                            <img src="{{ asset('assets/images/message_icon.png') }}" alt="image">
                        </div>
                        <div class="right_icon">
                            <img src="{{ asset('assets/images/shield_icon.png') }}" alt="image">
                        </div>
                        <div id="frmae_slider" class="owl-carousel owl-theme">
                            <div class="item">
                                <div class="slider_img">
                                    <img src="{{ asset('assets/images/Home1.png') }}" alt="image">
                                </div>
                            </div>
                            {{-- <div class="item">
                                <div class="slider_img">
                                    <img src="{{ asset('assets/images/screen.png') }}" alt="image">
                                </div>
                            </div>
                            <div class="item">
                                <div class="slider_img">
                                    <img src="{{ asset('assets/images/screen.png') }}" alt="image">
                                </div>
                            </div> --}}
                        </div>
                        <div class="slider_frame">
                            <img src="{{ asset('assets/images/mobile_frame_svg.svg') }}" style="display:none" alt="image">
                        </div>
                    </div>
                </div>
                <!-- banner slides end -->

            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </section>
    <!-- Banner-Section-end -->




    <!-- Features-Section-Start -->
    <section class="row_am features_section" id="features">
        <!-- container start -->
        <div class="container">
            <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                <!-- h2 -->
                <h2><span>Features</span> that makes app different!</h2>
                <!-- p -->
                <p>Expressing admiration and warmth, bid farewell to those who command respect. Whether appreciating
                    fortunate circumstances or crafting visual representations, the sentiment is one of esteem.</p>
            </div>
            <div class="feature_detail">
                <!-- feature box left -->
                <div class="left_data feature_box">

                    <!-- feature box -->
                    <div class="data_block">
                        <div class="icon">
                            <img src="{{ asset('assets/images/secure_data.png') }}" alt="image">
                        </div>
                        <div class="text">
                            <h4>Secure data</h4>
                            <p>
                                At Semibill, safeguarding your security is our utmost priority. Employing cutting-edge
                                technology, we guarantee the constant safety and protection of your personal and financial
                                information. Additionally, our platform is known for its reliability, offering a smooth
                                payment process that ensures prompt and precise transaction processing.</p>
                        </div>
                    </div>

                    <!-- feature box -->
                    <div class="data_block">
                        <div class="icon">
                            <img src="{{ asset('assets/images/functional.png') }}" alt="image">
                        </div>
                        <div class="text">
                            <h4>Save Time and Energy</h4>
                            <p>
                                Bid farewell to the laborious chore of settling bills. Semibill simplifies the procedure,
                                enabling you to complete payments effortlessly with just a few clicks. Moreover, our
                                platform operates around the clock, granting you the flexibility to settle your bills at
                                your convenience, anytime and anywhere.</p>
                        </div>
                    </div>
                </div>

                <!-- feature box right -->
                <div class="right_data feature_box">

                    <!-- feature box -->
                    <div class="data_block" data-aos="fade-left" data-aos-duration="1500">
                        <div class="icon">
                            <img src="{{ asset('assets/images/live-chat.png') }}" alt="image">
                        </div>
                        <div class="text">
                            <h4>Simplify Payment</h4>
                            <p>Experience a stress-free payment process for your crucial bills and services with Semibill. We
                                provide a straightforward, swift, and secure method to pay your utility bills, and even
                                engage in betting, all within a single platform.</p>
                        </div>
                    </div>

                    <!-- feature box -->
                    <div class="data_block" data-aos="fade-left" data-aos-duration="1500">
                        <div class="icon">
                            <img src="{{ asset('assets/images/support.png') }}" alt="image">
                        </div>
                        <div class="text">
                            <h4>24-7 Support</h4>
                            <p>Experience uninterrupted support with our 24/7 chat feature. Instant assistance, real-time
                                solutions, and a user-friendly interface make our app your go-to for seamless and reliable
                                customer support.</p>
                        </div>
                    </div>

                </div>
                <!-- feature image -->
                <div class="feature_img" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                    <img src="{{ asset('assets/images/Services1.png') }}" alt="image">
                </div>
            </div>
        </div>
        <!-- container end -->
    </section>
    <!-- Features-Section-end -->

    <!-- How-It-Workes-Section-Start -->
    <section class="row_am how_it_works" id="how_it_work">
        <!-- container start -->
        <div class="container">
            <div class="how_it_inner">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                    <!-- h2 -->
                    <h2><span>How it works</span> - 3 easy steps</h2>
                    <!-- p -->
                    {{-- <p>Lorem Ipsum is simply dummy text of the printing and typese tting <br> indus orem Ipsum has beenthe --}}
                        {{-- standard dummy.</p> --}}
                </div>
                <div class="step_block">
                    <!-- UL -->
                    <ul>
                        <!-- step -->
                        <li>
                            <div class="step_text">
                                <h4>Download app</h4>
                                <div class="app_icon">
                                    <a href="#"><i class="icofont-brand-android-robot"></i></a>
                                    <a href="#"><i class="icofont-brand-apple"></i></a>

                                </div>
                                <p>Download our app from App Store or google play store. </p>
                            </div>
                            <div class="step_number">
                                <h3>01</h3>
                            </div>
                            <div class="step_img" data-aos="fade-left" data-aos-duration="1500">
                                <img src="{{ asset('assets/images/download_app.jpg') }}" alt="image">
                            </div>
                        </li>

                        <!-- step -->
                        <li>
                            <div class="step_text" data-aos="fade-left" data-aos-duration="1500">
                                <h4>Create account</h4>
                                {{-- <span>14 days free trial</span> --}}
                                <p>Create your Semibill account in 1 minute</p>
                            </div>
                            <div class="step_number">
                                <h3>02</h3>
                            </div>
                            <div class="step_img">
                                <img src="{{ asset('assets/images/create_account.jpg') }}" alt="image">
                            </div>
                        </li>

                        <!-- step -->
                        <li>
                            <div class="step_text">
                                <h4>It’s done, enjoy all Semibill has to offer

                                 </h4>
                                <span>   Have any questions, check our FAQ or contact our support
                                    </span>
                                {{-- <p>Get most amazing app experience,Explore and share the app</p> --}}
                            </div>
                            <div class="step_number">
                                <h3>03</h3>
                            </div>
                            <div class="step_img" data-aos="fade-left" data-aos-duration="1500">
                                <img src="{{ asset('assets/images/enjoy_app.jpg') }}" alt="image">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- video section start -->

            <!-- video section end -->
        </div>
        <!-- container end -->
    </section>
    <!-- How-It-Workes-Section-end -->



    <!-- FAQ-Section start -->
    <section class="row_am faq_section">
        <!-- container start -->
        <div class="container">
            <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                <!-- h2 -->
                {{-- <h2><span>FAQ</span> - Frequently Asked Questions</h2> --}}
                <!-- p -->
                {{-- <p>Here you can resolve any doubts that you may have</p> --}}
            </div>
            <!-- faq data -->
            {{-- <div class="faq_panel">
                <div class="accordion" id="accordionExample">
                    <div class="card" data-aos="fade-up" data-aos-duration="1500">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button type="button" class="btn btn-link active" data-toggle="collapse"
                                    data-target="#collapseOne">
                                    <i class="icon_faq icofont-plus"></i></i> How can i pay ?</button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum
                                    has. been the
                                    industrys standard dummy text ever since the when an unknown printer took a galley of
                                    type and
                                    scrambled it to make a type specimen book. It has survived not only five cen turies but
                                    also the
                                    leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-duration="1500">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                    data-target="#collapseTwo"><i class="icon_faq icofont-plus"></i></i> How to setup
                                    account ?</button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum
                                    has. been the
                                    industrys standard dummy text ever since the when an unknown printer took a galley of
                                    type and
                                    scrambled it to make a type specimen book. It has survived not only five cen turies but
                                    also the
                                    leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-duration="1500">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                    data-target="#collapseThree"><i class="icon_faq icofont-plus"></i></i>What is process
                                    to get refund
                                    ?</button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum
                                    has. been the
                                    industrys standard dummy text ever since the when an unknown printer took a galley of
                                    type and
                                    scrambled it to make a type specimen book. It has survived not only five cen turies but
                                    also the
                                    leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-duration="1500">
                        <div class="card-header" id="headingFour">
                            <h2 class="mb-0">
                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                    data-target="#collapseFour"><i class="icon_faq icofont-plus"></i></i>What is process
                                    to get refund
                                    ?</button>
                            </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum
                                    has. been the
                                    industrys standard dummy text ever since the when an unknown printer took a galley of
                                    type and
                                    scrambled it to make a type specimen book. It has survived not only five cen turies but
                                    also the
                                    leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- container end -->
    </section>
    <!-- FAQ-Section end -->
@endsection
