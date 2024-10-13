 @include('buyer::includes.header')
 <main>
    <div div class="container">
     <div div class="row profile">
         @include('buyer::includes.sidebar')

         @yield('content')

     </div>
 </div>
</main>

@include('buyer::includes.footer')