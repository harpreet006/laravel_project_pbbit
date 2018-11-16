
@php
 $testimonialData = App\Helper::get_testimonial();
@endphp

 @if(count($testimonialData)>0)
  <div class="testimonials">
        <div class="container mt-3">
            <h2 class="heading_text">What our students have to saydfdfd</h2>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">

              <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
              
              <!-- The slideshow -->
              <div class="carousel-inner">
        
         @foreach($testimonialData as $key =>$testimonial)
          @php 
            if($key == 0){
              $active = "active";
            }
            else{
              $active = "";
            }
            if($testimonial->avtar != ''){
              if(file_exists('public/images/avatar/'.$testimonial->avtar.'')){
                $userImg =   "public/images/avatar/".$testimonial->avtar;   
              }else{
                $userImg = "public/frontview/images/NoPicture.jpg";
              }         
            }
            else{
              $userImg = "public/frontview/images/NoPicture.jpg";
            }
            
          @endphp 
          
                <div class="carousel-item {{$active}}">
                     <img src="{{ url($userImg)}}" alt="stundent"  class="student_img">
                      <span class="product-rating float-rightt">
                       
            @for ($x = 1; $x <= $testimonial->rating; $x++)
              <i class="fa fa-star" aria-hidden="true"></i>
            @endfor
            @php 
              $remaining = 5 - $testimonial->rating; 
            @endphp 
            @if($remaining > 0)
              @for ($y = 1; $y <= $remaining; $y++)
                <i class="fa fa-star-o da-star" aria-hidden="true"></i>
              @endfor
            @endif
            <!-- <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star-o da-star" aria-hidden="true"></i> -->
                    </span>
                    <h3>{{ucfirst($testimonial->first_name)}} {{ucfirst($testimonial->last_name)}}</h3>
                    <p>“ {{ucfirst($testimonial->text)}}”</p>
                    <img src="{{ url('public/frontview/images/cords.png')}}" alt="stundent" class="cords">
                   
                </div>
                @endforeach
              
               
                


              </div>
              
              <!-- Left and right controls -->
              <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </a>
              <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                <span class="carousel-control-next-icon"></span>
              </a>
            </div>

            
        </div>
    </div> 
    @endif