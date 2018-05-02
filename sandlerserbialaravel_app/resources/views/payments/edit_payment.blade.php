@extends('layouts.app')

@section('title', 'Rata Ugovora')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading san-yell">
                  <i class="fa fa-btn fa-edit" aria-hidden="true"></i>Rata
                  <!-- Back Button -->
                  <a href='{{ url("/payments/".$contract->id) }}' class="btn btn-default pull-right alert-san-grey"><i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>Rate</a>
                  <!-- /Back Button -->
                  <!-- Title -->
                  <div class="text-center h3">
                    <i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>
                    @if($payment->is_advance == '1') Avans @else Rata @endif Ugovora br. {{ $contract->contract_number}} od {{ date("d.m.Y.",strtotime($contract->contract_date)) }}
                  </div>
                  <!-- /Title -->
                  <!-- Message -->
                  @if (Session::has('message'))
                  <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
                  @endif
                  <!-- /Message -->
                </div>

                  <div class="panel-body san-yell">
                    <form method="POST" id='form' action='{{ url("/payment/update/".$payment->id) }}' class='form_prevent_multiple_submits'>
                      <!-- Vrednost rate -->
                      <div class="form-group{{ $errors->has('value_euro') ? ' has-error' : '' }}">
                        <label class="control-label" for="value_euro">
                          <i class="fa fa-btn fa-eur"></i>Vrednost
                            @if($payment['is_advance'] == '1') avansa @else rate  @endif  
                        </label>
                        <input type="number" id="value_euro" name="value_euro" class="form-control" aria-describedby="value_euroHelp" value="{{ $payment->value_euro }}" step="0.01">
                        @if ($errors->has('value_euro'))
                        <small id="value_euroHelp" class="form-text text-danger h5">
                          {{ $errors->first('value_euro') }}
                        </small>
                        @endif
                      </div>
                      <!-- /Vrednost rate   -->
                      <!-- Datum placanja  -->
                      <div class="form-group{{ $errors->has('format_pay_date') ? ' has-error' : '' }}">
                        <label class="control-label" for="format_pay_date">
                          <i class="fa fa-btn fa-calendar"></i>Datum plaćanja
                        </label>
                        <input type="text" id="format_pay_date" name="format_pay_date" class="form-control" aria-describedby="format_pay_dateHelp" value='{{ date("d.m.Y.",strtotime($payment->pay_date)) }}'>
                        <input type="hidden" id="pay_date" name="pay_date" value="{{$payment->pay_date}}">
                        @if ($errors->has('format_pay_date'))
                        <small id="format_pay_dateHelp" class="form-text text-danger h5">
                          {{ $errors->first('format_pay_date') }}
                        </small>
                        @endif
                      </div>
                      <!-- /Datum placanja -->
                      <!-- Opis  -->
                        <div class="form-group{{ $errors->has('pay_date_desc') ? ' has-error' : '' }}">
                          <label class="control-label" for="pay_date_desc">
                            <i class="fa fa-btn fa-comment"></i>Opis 
                          </label>
                          <textarea id="pay_date_desc" name="pay_date_desc"  class="form-control" aria-describedby="pay_date_descHelp" rows="1">{{ $payment->pay_date_desc }}</textarea>
                          @if ($errors->has('pay_date_desc'))
                          <small id="pay_date_descHelp" class="form-text text-danger h5">
                            {{ $errors->first('pay_date_desc') }}
                          </small>
                          @endif
                        </div>
                        <!-- /Opis  -->
                      <!-- /Token -->
                      <input type="hidden" id='_token' name="_token" value="{{ csrf_token() }}">
                      <!-- /Token -->
                      <!-- Button -->
                      <div class="panel panel-default san-light">
                        <button type="submit" id="submit" name="submit" class='button_prevent_multiple_submits btn btn-primary btn-md btn-block'>
                            <i class="no_spinner fa fa-btn fa-check"></i><i class='spinner fa fa-btn fa-spinner fa-spin'></i>POTVRDI 
                        </button>
                      </div>
                      <!--/Button -->
                    </form>
                 </div>

            </div>
        </div>
    </div>
</div>
<div class="container"></div>
@endsection

@section('script')
<script src="/js/payments/edit_payment.js"></script>
<script src='/js/submits/prevent_multiple_submits.js'></script>
<script src='/js/submits/spinner.js'></script>
@endsection


 