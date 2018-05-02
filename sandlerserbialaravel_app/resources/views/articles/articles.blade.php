@extends('layouts.app')

@section('title', 'Šablon Ugovora')

@section('content')
<div class="container main-container">
 
  <div class="col-lg-10 col-lg-offset-1 col-md-12">

    <div class="row">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Šablon Ugovora
          <!-- Back Button -->
          <a href="@if(url()->current() != url()->previous()){{ url()->previous()}}@else{{ url('/home')}}@endif 
          " class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Šablon Ugovora   
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">

            <!-- PDF Template Button -->
            <div class="panel panel-default san-light">
              <a href='{{ url("/pdf/contract_template") }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                  <i class="fa fa-btn fa-file-pdf-o" aria-hidden="true"></i><span>Šablon Ugovora PDF</span>
              </a>
            </div>
            <!-- PDF Template Button -->

            <!-- Template -->
            <div class="panel panel-default san-light">

              <div class="panel-heading alert-san-grey text-left">
                <i class="fa fa-btn fa-edit" aria-hidden="true"></i>Opcije 
              </div>

              <div class="panel-body bg-white">
                <!-- Table -->
                  <table class="table table-hover">
                      <tbody>

                        <tr>
                          <td>Logo u pozadini</td>
                          <td class="text-center"><span>@if($template_options->logo_bg == 1)Da @else Ne @endif</span></td>
                        </tr>
                        <tr>
                          <td>Logo u zaglavlju</td>
                          <td class="text-center"><span>@if($template_options->logo_hd == 1)Da @else Ne @endif</span></td>
                        </tr>
                        <tr>
                          <td>Linija gornjeg zaglavlja</td>
                          <td class="text-center"><span>@if($template_options->line_hd == 1)Da @else Ne @endif</span></td>
                        </tr>
                        <tr>
                          <td>Linija donjeg zaglavlja</td>
                          <td class="text-center"><span>@if($template_options->line_ft == 1)Da @else Ne @endif</span></td>
                        </tr>
                        <tr>
                          <td>Obeležavanje strana</td>
                          <td class="text-center"><span>@if($template_options->paginate == 1)Da @else Ne @endif</span></td>
                        </tr>
                        <tr>
                          <td>Margina gore</td>
                          <td class="text-center"><span>{{$template_options->margin_top}}</span></td>
                        </tr>
                        <tr>
                          <td>Margina desno</td>
                          <td class="text-center"><span>{{$template_options->margin_right}}</span></td>
                        </tr>
                        <tr>
                          <td>Margina dole</td>
                          <td class="text-center"><span>{{$template_options->margin_bottom}}</span></td>
                        </tr>
                        <tr>
                          <td>Margina levo</td>
                          <td class="text-center"><span>{{$template_options->margin_left}}</span></td>
                        </tr>
                      </tbody>
                  </table>
                  <!-- /Table -->
             </div>

              <a href='{{ url("/template/edit/".$template_options->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                  <i class="fa fa-btn fa-edit " aria-hidden="true"></i>
                  <span>Izmeni</span>
              </a>

            </div>
            <!-- Template -->

            <!-- Articles  -->
            @foreach($articles as $article)
              <div class="panel panel-default san-light">
                <div class="panel-heading alert-san-grey text-left">
                  <i class="fa fa-btn fa-edit" aria-hidden="true"></i>{{ $article->name}}
                </div>
               <div class="panel-body bg-white"> {!! $article->html !!}</div>
               <!-- Can't Change Articles 2,14,15 -->
               @if($article->id != 2 and $article->id != 14 and $article->id != 15)
                <a href='{{ url("/article/edit/".$article->id) }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                    <i class="fa fa-btn fa-edit " aria-hidden="true"></i>
                    <span>Izmeni</span>
                </a>
                @endif
              </div>
            @endforeach
            <!-- /Articles  -->
            
            <!-- PDF Template Button -->
            <div class="panel panel-default san-light">
              <a href='{{ url("/pdf/contract_template") }}' class='panel-body-sm btn btn-primary btn-block' role='button'>
                  <i class="fa fa-btn fa-file-pdf-o" aria-hidden="true"></i><span>Šablon Ugovora PDF</span>
              </a>
            </div>
            <!-- PDF Template Button -->

        </div><!--/panel-body -->

      </div><!-- panel panel-default -->

    </div><!-- /row -->

  </div><!-- col-lg-10 col-lg-offset-1 col-md-12 -->

</div><!-- /container main-container -->
@endsection
