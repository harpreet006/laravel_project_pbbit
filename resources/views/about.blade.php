 @extends('layouts.app')

 @section('title','home')

@section('style')

@endsection

 @section('content')
 <div class="outer_area">
 <div class="container">
  
   <p class="pargh">
  @php
  echo trans('pagetext.about_text1'); 
@endphp</p>
<p class="pargh">
  @php
  echo trans('pagetext.about_text2'); 
@endphp</p>

<p class="pargh">
  @php
  echo trans('pagetext.about_text3'); 
@endphp</p>

 
    </div>
</div>

    <div class="container">       
     @include('components.customcode')
    </div>
    @endsection

    @section('script')
    <script type="text/javascript">
     

    </script>
    @endsection



                                  