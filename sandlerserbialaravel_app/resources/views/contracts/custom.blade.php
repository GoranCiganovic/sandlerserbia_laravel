@extends('layouts.app')

@section('title', 'Ugovor br.'.$contract['contract_number'])

@section('content')
<div class="container main-container">
 
  <div class="col-lg-10 col-lg-offset-1 col-md-12">

    <div class="row">

      <div class="panel panel-default">

        <div class="panel-heading san-yell">

          <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Ugovor
          <!-- Back Button -->
          <a href='{{ url("/contract/".$contract['id']) }}' class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Nazad</a>
          <!-- /Back Button -->
          <!-- Title -->
          <div class="text-center h3">
            <i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Ugovor br. {{$contract['contract_number']}}     
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

        	  <form id='form' method="POST" action='{{ url("/pdf/save_contract_custom/".$contract['id']) }}' class='form_prevent_multiple_submits'>

      			 <!-- PDF Button -->
            <div class="panel panel-default san-light">
  	        		<button type="submit" id='preview_top' name="preview_top" class='button_prevent_multiple_submits preview btn btn-primary btn-md btn-block'>
  		              <i class="no_spinner fa fa-btn fa-file-pdf-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>UGOVOR PDF		
  		          </button>
            </div>
      	     <!-- /PDF Button -->

  				   <div class="form-group">
  	             <textarea class='form-control' name='contract' id='contract' rows='150'></textarea>
  	         </div>
  	          <!-- /Token -->
  	          <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
  	          <!-- /Token -->
              <!-- Save Button -->
              <div class="panel panel-default san-light">
                  <button type="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                      <i class="no_spinner fa fa-btn fa-save" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>SAČUVAJ 
                  </button>
              </div>
              <!-- /Save Button -->
  	          <!-- PDF Button -->
              <div class="panel panel-default san-light">
    	            <button type="submit" id='preview_bottom' name="preview_bottom" class='button_prevent_multiple_submits preview btn btn-primary btn-md btn-block'>
    	                <i class="no_spinner fa fa-btn fa-file-pdf-o" aria-hidden="true"></i><i class='spinner fa fa-btn fa-spinner fa-spin' aria-hidden="true"></i>UGOVOR PDF		
    	            </button>
              </div>
  	          <input type='hidden' id='form_preview' name='form_preview' value='{{ url("/pdf/contract_custom/".$contract['id']) }}'>
  	          <!--/PDF Button -->
  	          <!-- Save Button Tinymce-->
  	          <button name="submitbtn" class='hidden'></button>
  	          <!-- /Save Button Tinymce -->
  	          <!-- html contract wrapper -->
  	          <input type='hidden' id='html' name='html'>
  	          <!-- /html contract wrapper -->

          	</form>
   
        </div><!--/panel-body -->

      </div><!-- panel panel-default -->

    </div><!-- /row -->

  </div><!-- col-lg-10 col-lg-offset-1 col-md-12 -->

</div><!-- /container main-container -->

@include('contracts.custom_articles') 

@endsection

@section('script')
<script src='/storage/tinymce/js/tinymce/tinymce.min.js'></script>
<script src='/js/contracts/text_editor/editor_config.js'></script>
<script src='/js/contracts/text_editor/editor.js'></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection


