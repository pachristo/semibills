@extends('welcome')

@section('title')
About us - semibill.com

@endsection
@section('body')
    @include('partial',['title'=>'About Us'])


      <!-- App-Solution-Section-Start -->
      <section class="row_am app_solution_section">
        <!-- container start -->
        <div class="container">
          <!-- row start -->
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
              <!-- UI content -->
              <div class="app_text">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                  {{-- <h2><span>Providing innovative app solution</span> to make customer
                    life easy to grow.</h2> --}}
                </div>
                <p>Semibill.com, an esteemed virtual top-up platform.</p>
                <p>Our array of services encompasses, but is not limited to, the seamless buying and reselling of affordable data and airtime, hassle-free electricity bills payment, convenient cable TV subscriptions, as well as efficient hotel and flight bookings. At Semibill.com, our commitment to excellence is unwavering, and we continually optimize our platform for reliability and dependability.</p>
                <p>A cornerstone of our success lies in the development of a robust internal infrastructure tailored for unparalleled SIM hosting capabilities. Our dedicated server hosts numerous SIMs, efficiently processing VTU requests in milliseconds. These internal SIMs are adept at instantly delivering our VTU services by executing the requisite USSD codes and sending SMSs when necessary. Furthermore, our integration with cable TV subscription and electricity bill payment services is direct, utilizing Premium Direct Connections to provider gateways. We also leverage direct connections to banks where applicable, ensuring our services are not only cost-effective but also remarkably reliable.</p>
                <p>What sets us apart is the automation and instant delivery embedded in all our services, be it airtime, data, cable TV, or electricity. Our resellers and partners enjoy substantial discounts, providing lucrative opportunities to grow and prosper alongside us.</p>
                <p>Complementing our technological prowess is a dedicated team of customer support representatives available around the clock. Whether through phone, email, or live chat, our customer support ensures that your queries and concerns are promptly addressed, reinforcing your confidence in choosing Semibill.com as the right company for your virtual top-up needs.</p>
                <p>Partner with us, and experience a seamless, reliable, and cost-effective solution that transcends expectations. At Semibill.com, we don't just provide services; we deliver a commitment to excellence.</p>
              </div>
            </div>
            {{-- <div class="col-lg-6">
              <div class="app_images" data-aos="fade-in" data-aos-duration="1500">
                <ul>
                  <li><img src="{{asset('assets/images/abt_01.png')}}" alt=""></li>
                  <li>
                    <a class="popup-youtube play-button"
                      data-url="https://www.youtube.com/embed/tgbNymZ7vqY?autoplay=1&mute=1" data-toggle="modal"
                      data-target="#myModal" title="About Video">
                      <img src="{{asset('assets/images/abt_02.png')}}" alt="">
                      <div class="waves-block">
                        <div class="waves wave-1"></div>
                        <div class="waves wave-2"></div>
                        <div class="waves wave-3"></div>
                      </div>
                      <span class="play_icon"><img src="{{asset('assets/images/play_black.png')}}" alt="image"></span>
                    </a>
                  </li>
                  <li><img src="{{asset('assets/images/abt_03.png')}}" alt=""></li>
                </ul>
              </div>
            </div> --}}
          </div>
          <!-- row end -->
        </div>
        <!-- container end -->
      </section>
      <!-- App-Solution-Section-end -->





@endsection
