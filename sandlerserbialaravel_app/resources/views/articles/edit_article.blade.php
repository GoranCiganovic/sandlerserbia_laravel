@extends('layouts.app')

@section('title', $article->name)

@section('content')
<div class="container main-container">
 
  <div class="col-lg-10 col-lg-offset-1 col-md-12">

    <div class="row">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>{{ $article->name }} Ugovora
          <!-- Back Button -->
          <a href="{{ url('/articles')}}" class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Template</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>
            Izmeni <span id="confirm_name">{{ $article->name }}</span> Ugovora    
          </div>
          <!-- /Title -->
          <!-- Message -->
          @if (Session::has('message'))
            <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
          @endif
          <!-- /Message -->
          <!-- Errors -->
          @if($errors->has())
             @foreach ($errors->all() as $error)
                <div class="text-danger h4 text-center"><i>{{ $error }}</i></div>
            @endforeach
          @endif
          <!-- /Errors -->
        </div><!-- /panel-heading -->

        <div class="panel-body san-yell">

            <form id='form' method="POST" action='{{ url("article/update/".$article->id) }}' class='form_prevent_multiple_submits'>

              <!-- Naziv -->
              <div class="form-group">
                <label>
                  <i class="fa fa-btn fa-edit"></i>Naziv
                </label>
                <input type="text" id="title" name="title" class="form-control" value="{{ $article->name }}">
              </div>
              <!-- /Naziv -->
              <!-- Sadržaj -->
              <div class="form-group">
                  <label>
                    <i class="fa fa-btn fa-edit"></i>Sadržaj
                  </label>
                 <textarea class='form-control' name='article' id='article'>
                   {{ $article->html }}
                 </textarea>
              </div>
              <!-- /Sadržaj -->
              <!-- /Token -->
              <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
              <!-- /Token -->
              <!-- Save Button Tinymce-->
              <button name="submitbtn" id='submitbtn' class='hidden'></button>
              <!-- /Save Button Tinymce -->
              <!-- Button Confirm -->
              <div class="panel panel-default san-light">
                <button type="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                    <i class="no_spinner fa fa-btn fa-check"></i><i class='spinner fa fa-btn fa-spinner fa-spin'></i>POTVRDI IZMENU
                </button>
              </div>
              <!--/Button Confirm -->

            </form>
        	
        </div><!--/panel-body san-yell -->

      </div><!-- panel panel-default -->

    </div><!-- /row -->

  </div><!-- col-lg-10 col-lg-offset-1 col-md-12 -->

</div><!-- /container main-container -->
@endsection


@section('script')
<script src='/storage/tinymce/js/tinymce/tinymce.min.js'></script>
<script src='/js/contracts/text_editor/editor_config.js'></script>
<script src='/js/articles/article.js'></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection