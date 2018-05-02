<!-- Contract Articles  From Contract Html Or From Aricles Template  -->
<div id="articles"> 
  @if($html)
    {{ $html }}
  @else
    <div class='container'>
      <!-- Title -->
      {!! $article['title'] !!}
      <!--/Title -->
      <!-- Header -->
      <br><br>
      <p>Zaključen dana {{ date("d.m.Y.",strtotime($contract['contract_date'])) }} godine u Beogradu između:</p>
      <ol>
          <li>
              <b>Davalac usluga: {{$gt['name']}}</b>, {{$gt['address']}}, {{$gt['county']}}, matični broj: {{$gt['identification']}}, PIB: {{$gt['pib']}},  koga zastupa {{$gt['representative']}},  ovlašćeni zastupnik
          </li>
          i
          <li>
              <b>Korisnik usluga: {{$client['name']}}</b>, {{$client['servise_user']}}
          </li>
      </ol>
      <br><br>
      <!-- /Header -->
      <!-- Top Articles -->
      {!! $article['top_articles'] !!}
      <!-- /Top Articles -->
      <!-- Event Place-->
      @if($contract['event_place'])
      {!! $article['event_place'] !!}{{$contract['event_place']}}<br>           
      @endif
      <!-- /Event Place -->
      <!-- Classes Number-->
      @if($contract['classes_number'])
      {!! $article['classes_number'] !!}{{$contract['classes_number']}}<br>
      @endif
      <!-- /Classes Number -->
      <!-- Start End -->
      @if($contract['start_date'] and $contract['end_date'])
      {!! $article['start_end'] !!}
      od {{ date("d.m.Y.",strtotime($contract['start_date'])) }} do {{ date("d.m.Y.",strtotime($contract['end_date'])) }}godine<br>
      @endif
      <!-- /Start End -->
      <!-- Work Dynamics-->
      @if($contract['work_dynamics'])
      {!! $article['work_dynamics'] !!}{{$contract['work_dynamics']}}<br>          
      @endif
      <!-- /Work Dynamics -->
      <!-- Event Time -->
      @if($contract['event_time'])
      {!! $article['event_time'] !!}{{$contract['event_time']}}<br>             
      @endif
      <!-- /Event Time -->
      <!-- Participants Number -->
      @if($contract['participants'] > 0)
      {!! $article['participants_number'] !!}<br>
      @endif
      <!-- /Participants Number -->
      <!-- Agreement -->
      {!! $article['agreement'] !!}<br>
      <!-- /Agreement -->
      <!-- Middle Articles -->
      {!! $article['middle_articles'] !!}
      <!-- /Middle Articles -->
      <!-- Payings -->
      &nbsp;{{ number_format($contract['value'], 2, ',', '.') }} EUR (i slovima: {{$contract['value_letters']}}), prema sledećoj dinamici:
      </p>
      <ul>
          @foreach($payments as $payment)
          <li>
              {{ number_format($payment['value_euro'], 2, ',', '.') }} &euro;&nbsp;{{ $payment['pay_date_desc'] }}, odnosno nakon {{ date("d.m.Y.",strtotime($payment['pay_date'])) }}godine.
          </li>
          @endforeach
      </ul>
      {!! $article['payings'] !!}
      <!-- /Payings -->
      <!-- Bottom Articles -->
      {!! $article['bottom_articles'] !!}
      <!-- /Bottom Articles -->
      <!-- Signature -->
      <br>
      <div style='overflow:hidden' class="container new-page-signature">
          <div class="row">
            <div style='text-align:center;float:left' class="col-xs-4 pull-left text-center">
              <div style='border-bottom: 1px solid #000;height: 80px;' class='signature'>Za Davaoca usluga</div>  
              <span>Ovlašćeni zastupnik</span><br>
              <span>{{$gt['representative']}}</span>
            </div>
            <div style='text-align:center;float:right' class="col-xs-4 pull-right text-center">
              <div style='border-bottom: 1px solid #000;height: 80px;' class='signature'>Za Korisnika usluga</div>
              <span>Ovlašćeni zastupnik</span><br>
              <span>{{$client['ceo']}}</span>
            </div>
          </div>
      </div>
      <!-- /Signature -->
      <!-- Attachment -->
      @if($contract['participants'] > 0)
      <br><br>
      <h4 class="new-page">PRILOG 1 <br>
        UGOVORA O PRUŽANJU USLUGA od {{date("d.m.Y.",strtotime($contract['contract_date']))}} godine.</h4>
      <p>Broj i imena učesnika programa:</p>
      <ol>
          @foreach($participants as $participant)
          <li>{{ $participant['name'] }}</li>
          @endforeach
      </ol>
      <p>&ldquor;{{$client['short_name']}}&rdquo;, kao Korisnik usluga ima pravo da izvrši zamenu učesnika i obavezu da o tome unapred obavesti Davaoca usluga, što će biti konstatovano izmenom ovog priloga.</p>
      @endif
      <!-- /Attachment -->
      
    </div>
  @endif
</div>
<!-- /Contract Articles  From Contract Html Or From Aricles Template  -->


   

            
