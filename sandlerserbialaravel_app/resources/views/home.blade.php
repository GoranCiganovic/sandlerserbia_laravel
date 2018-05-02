@extends('layouts.app')

@section('title', 'Početna Sandler Serbia')
    
@section('content')
<!-- Sandler Serbian DB -->
<div id="sandlerserbia_database" class="container main-container"> 

  <div class="well san-yell">
    <div class="row">
      <!-- Exchange -->
      <div id="home_exchange" class="col-lg-3 col-md-4 col-sm-3 text-left">
        <span><span class="eu-flag glyphicon glyphicon-globe"></span>EUR&nbsp;{{ $euro }}</span>&nbsp;&nbsp;
        <br class="hidden-lg hidden-md hidden-xs">
        <span><span class="usa-flag glyphicon glyphicon-globe"></span>USD&nbsp;{{ $dollar }}</span>
      </div>
      <!-- /Exchange -->
      <br class="hidden-lg hidden-md hidden-sm">
      <!-- Search -->
      <div id="home_search" class="col-lg-7 col-md-6 col-sm-6">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-search"></i></span>    
          <input type="text" id="search" name="search" class="form-control" placeholder="Pretraga..."><!-- Search on home page -->
          <input type="text" id="local_search" name="local_search" class="form-control hidden" placeholder="Pretraga..."><!-- Search on client statuses-ajax --> 
        </div>
      </div>
      <!-- /Search -->
      <!-- Time -->
      <div id="home_time" class="col-lg-2 col-md-2 col-sm-3 text-right">
        <span class="h4 hidden-xs" id="time"></span>
      </div>
      <!-- /Time -->
    </div>

    <h2 class="text-center"><i class="fa fa-btn fa-database" aria-hidden="true"></i>&nbsp;Sandler Srbija Baza</h2>
    @if (Session::has('message'))
        <div class="text-info h4 text-center"><i>{!! Session::get('message')!!}</i></div>
    @endif
    
    <div class="row text-center">

      <!-- /Suspects -->
      <div id="suspects" class="col-lg-4 col-md-4 col-sm-4">
        <h4><i class="fa fa-btn fa-star-o" aria-hidden="true"></i>Suspects</h4>
        <a href="{{ url('/sandler_db/1') }}"  class='sandler_db btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-phone-square" aria-hidden="true"></i>Nisu kontaktirani</a>
        <a href="{{ url('/sandler_db/2') }}" class='sandler_db btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-ban" aria-hidden="true"></i>Diskvalifikovani</a>
      </div>
      <!-- /Suspects -->
      <!-- Prosptects -->
      <div id="prospects" class="col-lg-4 col-md-4 col-sm-4">
        <h4><i class="fa fa-btn fa-star-half-o" aria-hidden="true"></i>Prospects</h4>
        <a href="{{ url('/sandler_db/3') }}" class='sandler_db btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-handshake-o" aria-hidden="true"></i>Prihvatio sastanak
          @if($accept > 0)
          <span class="alert-san-grey badge">{{$accept}}</span>
          @endif
        </a>
        <a href="{{ url('/sandler_db/4') }}" class='sandler_db btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-thumbs-o-up" aria-hidden="true"></i>Jasna precizna budućnost
          @if($jpb > 0)<span class="alert-san-grey badge">{{$jpb}}</span>@endif
        </a>
        
      </div>
      <!-- /Prosptects -->
      <!-- Clients -->
      <div id="clients" class="col-lg-4 col-md-4 col-sm-4">
        <h4><i class="fa fa-btn fa-star" aria-hidden="true"></i>Clients</h4>
        <a href="{{ url('/sandler_db/5') }}" class='sandler_db btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-toggle-off" aria-hidden="true"></i>Naktivni klijenti</a>
        <a href="{{ url('/sandler_db/6') }}" class='sandler_db btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-toggle-on" aria-hidden="true"></i>Aktivni klijenti</a>
      </div>
       <!-- /Clients -->

    </div>

    <div class="row text-center">

      <!-- Contracts -->
      <div id="contracts" class="col-lg-4 col-md-4 col-sm-4"><br>
        <h4 class="text-center"><i class="fa fa-btn fa fa-archive" aria-hidden="true"></i>&nbsp;Ugovori</h4>
        <a href="{{ url('/contracts/in_progress') }}" class='contracts btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-folder-open-o" aria-hidden="true"></i>U toku</a>
        <a href="{{ url('/contracts/unsigned') }}" class='contracts btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Nepotpisani
        @if($unsigned > 0)<span class="alert-san-grey badge">{{$unsigned}}</span>@endif
        </a>
        <a href="{{ url('/contracts/broken') }}" class='contracts btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-ban" aria-hidden="true"></i>Raskinuti
        </a>
        <a href="{{ url('/contracts/finished') }}" class='contracts btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-folder" aria-hidden="true"></i>Završeni</a>
      </div>
      <!-- /Contracts --> 
      <!-- Proinvoices -->
      <div id="proinvoices" class="col-lg-4 col-md-4 col-sm-4"><br>
        <h4 class="text-center"><i class="fa fa-btn fa-files-o" aria-hidden="true"></i>&nbsp;Profakture</h4>
        <a href="{{ url('/proinvoices/issue_today') }}" class='proinvoices btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa fa-calendar-plus-o" aria-hidden="true"></i>Izdati na današnji dan
          @if($proinvoice_issue_today > 0)<span class="alert-san-grey badge">{{$proinvoice_issue_today}}</span>@endif
        </a>
        <a href="{{ url('/proinvoices/confirm_issued') }}" class='proinvoices btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>Potvrda izdavanja
        @if($proinvoice_confirm_issued > 0)<span class="alert-san-grey badge">{{$proinvoice_confirm_issued}}</span>@endif
        </a>
        <a href="{{ url('/proinvoices/confirm_paid') }}" class='proinvoices btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa fa-credit-card" aria-hidden="true"></i>Potvrda plaćanja
        @if($proinvoice_confirm_paid > 0)<span class="alert-san-grey badge">{{$proinvoice_confirm_paid}}</span>@endif
        </a>
        <a href="{{ url('/invoices/from_proinvoices') }}" class='invoices btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa fa-file-text-o" aria-hidden="true"></i>Fakture po profakturi
        @if($invoices_from_paid_proinvoices > 0)<span class="alert-san-grey badge">{{$invoices_from_paid_proinvoices}}</span>@endif
        </a>
      </div>
      <!-- /Proinvoices -->
      <!-- Invoices -->
      <div id="invoices" class="col-lg-4 col-md-4 col-sm-4"><br>
        <h4 class="text-center"><i class="fa fa-btn fa-files-o" aria-hidden="true"></i>&nbsp;Fakture</h4>
        <a href="{{ url('/invoices/issue_today') }}" class='invoices btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa fa-calendar-plus-o" aria-hidden="true"></i>Izdati na današnji dan
          @if($invoices_issue_today > 0)<span class="alert-san-grey badge">{{$invoices_issue_today}}</span>@endif
        </a>
        <a href="{{ url('/invoices/confirm_issued') }}" class='invoices btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-calendar-check-o" aria-hidden="true"></i>Potvrda izdavanja
        @if($invoice_confirm_issued > 0)<span class="alert-san-grey badge">{{$invoice_confirm_issued}}</span>@endif
        </a>
        <a href="{{ url('/invoices/confirm_paid') }}" class='invoices btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa fa-credit-card" aria-hidden="true"></i>Potvrda plaćanja
        @if($invoice_confirm_paid > 0)<span class="alert-san-grey badge">{{$invoice_confirm_paid}}</span>@endif
        </a>
        <a href="{{ url('/invoices/all_paid') }}" class='invoices btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa fa-file-text" aria-hidden="true"></i>Plaćene fakture
        </a>
      </div>
      <!-- /Invoices -->

    </div>
    
    <div class="row text-center">

      <!-- Insert DB -->
      <div id="insert-db" class="col-lg-4 col-md-4 col-sm-4"><br>
        <h4 class="text-center"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Unos u bazu</h4>
         <a href="{{ url('/legal/create') }}" class="btn btn-primary btn-md btn-block"><i class="fa fa-btn fa-building-o" aria-hidden="true"></i>Pravno lice</a>
          <a href="{{ url('/individual/create') }}" class="btn btn-primary btn-md btn-block"><i class="fa fa-btn fa-user-o" aria-hidden="true"></i>Fizičko lice</a>
          <a href="{{ url('/legals/create_from_file') }}" class="btn btn-primary btn-md btn-block"><i class="fa fa-btn fa-file-excel-o" aria-hidden="true"></i>Preko fajla</a>
      </div>
      <!-- /Insert DB -->
      <!-- Ratio -->
      <div id="sandler-ratio" class="col-lg-4 col-md-4 col-sm-4"><br>
        <h4 class="text-center"><i class="fa fa-btn fa-pie-chart" aria-hidden="true"></i>&nbsp;Ratio</h4>
        <a href="{{ url('/conversation_ratio') }}" class='statistics btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-phone-square" aria-hidden="true"></i>Conversation Ratio</a>
        <a href="{{ url('/closing_ratio') }}" class='statistics btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-star" aria-hidden="true"></i>Closing Ratio</a>
        <a href="{{ url('/debts') }}" class='debts btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-file-powerpoint-o" aria-hidden="true"></i>Dugovanja
        @if($sandler_debt > 0 || $disc_devine_debt > 0)<span class="alert-san-grey badge"><b class='text-danger'>!</b></span>@endif
        </a>
      </div>
      <!-- /Ratio -->
      <!-- Traffic -->
      <div id="sandler-traffic" class="col-lg-4 col-md-4 col-sm-4"><br>
        <h4 class="text-center"><i class="fa fa-btn fa-bar-chart" aria-hidden="true"></i>&nbsp;Promet</h4>
        <a href="{{ url('/sandler_traffic') }}" class='statistics btn btn-primary btn-md btn-block' role='button'><span class="sandler-systems-icon glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Sandler procenat</a>
        <a href="{{ url('/disc_devine_traffic') }}" class='statistics btn btn-primary btn-md btn-block' role='button'><span class="disc-devine-icon glyphicon glyphicon-globe"></span>&nbsp;&nbsp;DISC/Devine</a>
        <a href="{{ url('/total_traffic') }}" class='statistics btn btn-primary btn-md btn-block' role='button'><i class="fa fa-btn fa-calculator" aria-hidden="true"></i>Ukupan promet</a>
      </div>
      <!-- /Traffic -->

    </div>

  </div>
  <!-- /Sandler Serbian DB -->

  <!-- Ajax search result -->
  <div id="search_result"></div>
  <!-- Ajax search result -->

</div>

@endsection

@section('script')
  <script src="/js/time.js"></script>
  <script src="/js/clients/home_search.js"></script> 
  <script src="/js/clients/home_clients.js"></script>
  <script src="/js/contracts/home_contracts.js"></script>
  <script src="/js/invoices/home_proinvoices.js"></script>  
  <script src="/js/invoices/home_invoices.js"></script> 
  <script src="/js/statistics/statistics.js"></script>
  <script src="/js/debts/debts.js"></script>  
@endsection