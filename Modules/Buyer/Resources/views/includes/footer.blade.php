   {{--<div class="messageBox">
    <div class="container h-100">
        <div class="row align-items-center h-100">
         <div class="col-md-5">
            <div class="imgBx">

                <img src="{{asset('assets_front/images/smsBox.png')}}" class="img-fluid" />
            </div>
        </div>
        <div class="col-md-7">
            <div class="textArea">
              <h2>What is Lorem Ipsum?</h2>
              <small>Lorem Ipsum is simply dummy text of the printing and typesetting..</small>
              <a href="{{route('buyer-contact-us')}}" class="needHelp">Need Help? Talk to Exprt</a>
          </div>
      </div>
  </div>
</div>
</div> --}}

<footer class="mt-5">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-3">
                <a href="{{route('buyer-search-property') }}"> 

                    <img width="163" src="{{asset('storage'.getLogo())}}" class="img-fluid" />
                </a>
            </div>
            @php 
            $cmsMenu=getFooterCmsPageMenu();
            $role_chunck = array_chunk($cmsMenu, 3);
            @endphp

            @foreach($role_chunck as $key => $value) 
            <div class="col-md-2">
             <ul>
                @foreach ($value as $key => $value) 
                <li>
                    <a href="{{route('buyer-cms-page-view',$value['page_slug'])}}" class="link">{{$value['page_name']}}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
        @php $links=getFooterSocialLink(); @endphp 
        <div class="col-md-3 d-flex justify-content-between flex-wrap">
            <a href="{{@$links[0]}}" target="_blank"><i class="faicons fa_facebook"><img src="{{asset('assets_front/images/icons/facebook.svg')}}" class="img-fluid" /></i></a>
            <a href="{{@$links[1]}}" target="_blank"><i class="faicons fa_twitter"><img src="{{asset('assets_front/images/icons/twitter.svg')}}" class="img-fluid" /></i></a>
            <a href="{{@$links[2]}}" target="_blank"><i class="faicons fa_instagram"><img src="{{asset('assets_front/images/icons/instagram.svg')}}" class="img-fluid" /></i></a>
            <a href="mailto:{{@$links[3]}}" target="_blank"><i class="faicons fa_mailto"><img src="{{asset('assets_front/images/icons/m.svg')}}" class="img-fluid" /></i></a>
            <a href="{{@$links[4]}}" target="_blank"><i class="faicons fa_youtube"><img src="{{asset('assets_front/images/icons/youtube.svg')}}" class="img-fluid" /></i></a>

            <div class="textArea taButton">
                <a href="{{route('buyer-contact-us')}}" class="needHelp">Need Help? Talk to Expert</a>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="parraG">
                <p>{{ getFooterContent();}}</p>
            </div>
        </div>
    </div>
</div>
</footer>