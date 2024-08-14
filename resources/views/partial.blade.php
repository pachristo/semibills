  <!-- BredCrumb-Section -->
  <div class="bred_crumb">
    <div class="container">
      <!-- shape animation  -->
      <span class="banner_shape1"> <img src="{{asset('assets/images/banner-shape1.png')}}" alt="image" > </span>
      <span class="banner_shape2"> <img src="{{asset('assets/images/banner-shape2.png')}}" alt="image" > </span>
      <span class="banner_shape3"> <img src="{{asset('assets/images/banner-shape3.png')}}" alt="image" > </span>

      <div class="bred_text">
        <h1>{{ $title }}</h1>
        <ul>
          <li><a href="{{url('/')}}">Home</a></li>
          <li><span>»</span></li>
          <li><a href="{{ url()->current() }}">{{ $title }}</a></li>
        </ul>
      </div>
    </div>
  </div>
<script>

</script>

@section('js')
<script>

// Fix Header Js
$(window).scroll(function(){
  if ($(window).scrollTop() >= 250) {

      $('header').removeClass('white_header');
  }
  else {

      $('header').addClass('white_header');
  }
  $('header').addClass('fixed');
  

});

</script>
@endsection
