@extends('layouts.app')

@section('title', 'Opcije')

@section('content')
<div class="container main-container">
 
  <div class="col-lg-10 col-lg-offset-1 col-md-12">

    <div class="row">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Opcije
          <!-- Back Button -->
          <a href="{{ url('/articles')}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>
            Izmeni Opcije   
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">

          <!-- Template Form -->
            <form id='form' method="POST" action='{{ url("/template/update/".$template->id) }}' class='form_prevent_multiple_submits'>

                <!-- Prikaži logo u pozadini -->
                <div class="form-group{{ $errors->has('logo_bg') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" id="logo_bg" name="logo_bg" value="{{$template->logo_bg}}"@if($template->logo_bg == 1) checked @endif>
                        </span>
                        <div class="form-control" aria-describedby="logo_bgHelp">
                            <b>Prikaži logo u pozadini</b>
                        </div>
                    </div>
                    @if ($errors->has('logo_bg'))
                    <small id="logo_bgHelp" class="form-text text-danger h5">
                        {{ $errors->first('logo_bg') }}
                    </small>
                    @endif
                </div>
                <!-- /Prikaži logo u pozadini -->
                <!-- Prikaži logo u zaglavlju -->
                <div class="form-group{{ $errors->has('logo_hd') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" id="logo_hd" name="logo_hd" value="{{$template->logo_hd}}" @if($template->logo_hd == 1) checked @endif>
                        </span>
                        <div class='form-control' aria-describedby="logo_hdHelp">
                            <b>Prikaži logo u zaglavlju</b>
                        </div>
                    </div>
                    @if ($errors->has('logo_hd'))
                    <small id="logo_hdHelp" class="form-text text-danger h5">
                        {{ $errors->first('logo_hd') }}
                    </small>
                    @endif
                </div>
                <!-- /Prikaži logo u zaglavlju -->
                <!-- Prikaži liniju gornjeg zaglavlja -->
                <div class="form-group{{ $errors->has('line_hd') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" id="line_hd" name="line_hd" value="{{$template->line_hd}}" @if($template->line_hd == 1) checked @endif>
                        </span>
                        <div class='form-control' aria-describedby="line_hdHelp">
                            <b>Prikaži liniju gornjeg zaglavlja</b>
                        </div>
                    </div>
                    @if ($errors->has('line_hd'))
                    <small id="line_hdHelp" class="form-text text-danger h5">
                        {{ $errors->first('line_hd') }}
                    </small>
                    @endif                    
                </div>
                <!-- /Prikaži liniju gornjeg zaglavlja -->
                <!-- Prikaži liniju donjeg zaglavlja -->
                <div class="form-group{{ $errors->has('line_ft') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" id="line_ft" name="line_ft" value="{{$template->line_ft}}" @if($template->line_ft == 1) checked @endif>
                        </span>
                        <div class='form-control' aria-describedby="line_ftHelp">
                            <b>Prikaži liniju donjeg zaglavlja</b>
                        </div>
                    </div>
                    @if ($errors->has('line_ft'))
                    <small id="line_ftHelp" class="form-text text-danger h5">
                        {{ $errors->first('line_ft') }}
                    </small>
                    @endif
                </div>
                <!-- /Prikaži liniju donjeg zaglavlja -->
                <!-- Prikaži obeležavanje strana -->
                <div class="form-group{{ $errors->has('paginate') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" id="paginate" name="paginate" value="{{$template->paginate}}" @if($template->paginate == 1) checked @endif>
                        </span>
                        <div class='form-control' aria-describedby="paginateHelp">
                            <b>Prikaži obeležavanje strana</b>
                        </div>
                    </div>
                    @if ($errors->has('paginate'))
                    <small id="paginateHelp" class="form-text text-danger h5">
                        {{ $errors->first('paginate') }}
                    </small>
                    @endif
                </div>
                <!-- /Prikaži obeležavanje strana -->
                <!-- Margina gore -->
                <div class="form-group{{ $errors->has('margin_top') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-pencil-square-o"></i>
                        </span>
                        <span class="input-group-addon template-addon"><b>Margina gore</b></span>
                        <input type="number" id="margin_top" name="margin_top" class="form-control" aria-describedby="margin_topHelp" value="{{$template->margin_top}}">
                    </div>
                    @if ($errors->has('margin_top'))
                    <small id="margin_topHelp" class="form-text text-danger h5">
                        {{ $errors->first('margin_top') }}
                    </small>
                    @endif
                </div>
                <!-- /Margina gore -->
                <!-- Margina desno -->
                <div class="form-group{{ $errors->has('margin_right') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-pencil-square-o"></i>
                        </span>
                        <span class="input-group-addon template-addon"><b>Margina desno</b></span>
                        <input type="number" id="margin_right" name="margin_right" class="form-control" aria-describedby="margin_rightHelp" value="{{$template->margin_right}}">
                    </div>
                    @if ($errors->has('margin_right'))
                    <small id="margin_rightHelp" class="form-text text-danger h5">
                        {{ $errors->first('margin_right') }}
                    </small>
                    @endif
                </div>
                <!-- /Margina desno -->
                <!-- Margina dole -->
                <div class="form-group{{ $errors->has('margin_bottom') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-pencil-square-o"></i>
                        </span>
                        <span class="input-group-addon template-addon"><b>Margina dole</b></span>
                        <input type="number" id="margin_bottom" name="margin_bottom" class="form-control" aria-describedby="margin_bottomHelp" value="{{$template->margin_bottom}}">
                    </div>
                    @if ($errors->has('margin_bottom'))
                    <small id="margin_bottomHelp" class="form-text text-danger h5">
                        {{ $errors->first('margin_bottom') }}
                    </small>
                    @endif
                </div>
                <!-- /Margina dole -->
                <!-- Margina levo -->
                <div class="form-group{{ $errors->has('margin_left') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-pencil-square-o"></i>
                        </span>
                        <span class="input-group-addon template-addon"><b>Margina levo</b></span>
                        <input type="number" id="margin_left" name="margin_left" class="form-control" aria-describedby="margin_leftHelp" value="{{$template->margin_left}}">
                    </div>
                    @if ($errors->has('margin_left'))
                    <small id="margin_leftHelp" class="form-text text-danger h5">
                        {{ $errors->first('margin_left') }}
                    </small>
                    @endif
                </div>
                <!-- /Margina levo -->

                <!-- /Token -->
                <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                <!-- /Token -->

                <!-- Update Button -->
                <div class="panel panel-default san-light">
                    <button type="submit" id='submit' name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                        <i class="no_spinner fa fa-btn fa-check" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>POTVRDI IZMENU
                    </button>
                </div>
                <!--/Update Button -->

            </form>
            <!-- /Template Form -->
            
        </div><!--/panel-body san-yell -->

      </div><!-- panel panel-default -->

    </div><!-- /row -->

  </div><!-- col-lg-10 col-lg-offset-1 col-md-12 -->

</div><!-- /container main-container -->
@endsection


@section('script')
<script src='/js/templates/template.js'></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection



