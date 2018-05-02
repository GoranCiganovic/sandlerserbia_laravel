<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Client;
use App\Invoice;
use App\Sandler;
use App\DiscDevine;

class StatisticsController extends Controller
{
    /**
     * Display Statistics - Conversation Ratio based on input range Ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function conversation_ratio(Request $request)
	{
		$from = $request->input('from');
		$to = $request->input('to');
		$formated_from = $request->input('formated_from');
		$formated_to = $request->input('formated_to');

        $this->validate($request, [
            'from' => 'date_format:"Y-m-d"|required|before:to',
            'to' => 'date_format:"Y-m-d"|required|after:from' ,
            'formated_from' => 'date_format:"d.m.Y."|required|before:to',
            'formated_to' => 'date_format:"d.m.Y."|required|after:from'          
        ]);

        $result = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            		    ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
					    ->selectRaw("distinct
(
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.conversation_date) from laravel_individuals where laravel_individuals.conversation_date between '{$from}' and '{$to}')
) as total,
(
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}' and laravel_legals.client_status_id in (3,5,6))+
(select count(laravel_individuals.conversation_date) from laravel_individuals where laravel_individuals.conversation_date between '{$from}' and '{$to}' and laravel_individuals.client_status_id in (3,5,6))
) as met,
(
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}' and laravel_legals.client_status_id = '2')+
(select count(laravel_individuals.conversation_date) from laravel_individuals  where laravel_individuals.conversation_date between '{$from}' and '{$to}' and laravel_individuals.client_status_id = '2')
) as dsq,
(
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}' and laravel_legals.client_status_id = '4')+
(select count(laravel_individuals.conversation_date) from laravel_individuals where laravel_individuals.conversation_date between '{$from}' and '{$to}' and laravel_individuals.client_status_id = '4')
) as jpb,

concat(
round(
((
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}' and laravel_legals.client_status_id in (3,5,6))+
(select count(laravel_individuals.conversation_date) from laravel_individuals where laravel_individuals.conversation_date between '{$from}' and '{$to}' and laravel_individuals.client_status_id in (3,5,6))
)/
(
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.conversation_date) from laravel_individuals where laravel_individuals.conversation_date between '{$from}' and '{$to}')
)
* 100),
2),
'%') as met_percentage,
concat(
round(
((
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}' and laravel_legals.client_status_id = '2')+
(select count(laravel_individuals.conversation_date) from laravel_individuals  where laravel_individuals.conversation_date between '{$from}' and '{$to}' and laravel_individuals.client_status_id = '2')
)/
(
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.conversation_date) from laravel_individuals where laravel_individuals.conversation_date between '{$from}' and '{$to}')
)
* 100),
2),
'%') as dsq_percentage,
concat(
round(
((
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}' and laravel_legals.client_status_id = '4')+
(select count(laravel_individuals.conversation_date) from laravel_individuals where laravel_individuals.conversation_date between '{$from}' and '{$to}' and laravel_individuals.client_status_id = '4')
)/
(
(select count(laravel_legals.conversation_date) from laravel_legals where laravel_legals.conversation_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.conversation_date) from laravel_individuals where laravel_individuals.conversation_date between '{$from}' and '{$to}')
)
* 100),
2),
'%') as jpb_percentage")

		            ->whereBetween('legals.conversation_date', [$from, $to])
		            ->orWhereBetween('individuals.conversation_date', [$from, $to])
		            ->first();

		if ($request->ajax()) {
            return view('statistics.conversation_ajax', compact('formated_from', 'formated_to', 'result'));
        }else{
        	return back(); 
        }

	}

	
    /**
     * Display Statistics -  Closing Ratio based on input range Ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
	public function closing_ratio(Request $request)
	{
        $from = $request->input('from');
		$to = $request->input('to');
		$formated_from = $request->input('formated_from');
		$formated_to = $request->input('formated_to');

        $this->validate($request, [
            'from' => 'date_format:"Y-m-d"|required|before:to',
            'to' => 'date_format:"Y-m-d"|required|after:from'           
        ]);

        $result = Client::leftJoin('legals', 'clients.id', '=', 'legals.client_id')
            		    ->leftJoin('individuals', 'clients.id', '=', 'individuals.client_id')
					    ->selectRaw(" distinct
(select count(laravel_legals.accept_meeting_date) from laravel_legals where laravel_legals.client_status_id in (2,5,6) and laravel_legals.accept_meeting_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.accept_meeting_date) from laravel_individuals where laravel_individuals.client_status_id in (2,5,6) and laravel_individuals.accept_meeting_date between '{$from}' and '{$to}') as total,
(select count(laravel_legals.accept_meeting_date) from laravel_legals where laravel_legals.client_status_id = '2' and laravel_legals.accept_meeting_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.accept_meeting_date) from laravel_individuals where laravel_individuals.client_status_id = '2' and laravel_individuals.accept_meeting_date between '{$from}' and '{$to}') as dsq,
(select count(laravel_legals.accept_meeting_date) from laravel_legals where laravel_legals.client_status_id in (5,6) and laravel_legals.accept_meeting_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.accept_meeting_date) from laravel_individuals where laravel_individuals.client_status_id in (5,6) and laravel_individuals.accept_meeting_date between '{$from}' and '{$to}') as clients,
concat(
round(
(
((select count(laravel_legals.accept_meeting_date) from laravel_legals where laravel_legals.client_status_id = '2' and laravel_legals.accept_meeting_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.accept_meeting_date) from laravel_individuals where laravel_individuals.client_status_id = '2' and laravel_individuals.accept_meeting_date between '{$from}' and '{$to}'))/
(
((select count(laravel_legals.accept_meeting_date) from laravel_legals where laravel_legals.client_status_id in (2,5,6) and laravel_legals.accept_meeting_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.accept_meeting_date) from laravel_individuals where laravel_individuals.client_status_id in (2,5,6) and laravel_individuals.accept_meeting_date between '{$from}' and '{$to}'))
)
* 100),
2),
'%') as dsq_percentage,
concat(
round(
(
((select count(laravel_legals.accept_meeting_date) from laravel_legals where laravel_legals.client_status_id in (5,6) and laravel_legals.accept_meeting_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.accept_meeting_date) from laravel_individuals where laravel_individuals.client_status_id in (5,6) and laravel_individuals.accept_meeting_date between '{$from}' and '{$to}'))/
(
((select count(laravel_legals.accept_meeting_date) from laravel_legals where laravel_legals.client_status_id in (2,5,6) and laravel_legals.accept_meeting_date between '{$from}' and '{$to}')+
(select count(laravel_individuals.accept_meeting_date) from laravel_individuals where laravel_individuals.client_status_id in (2,5,6) and laravel_individuals.accept_meeting_date between '{$from}' and '{$to}'))
)
 * 100),
2),
'%') as client_percentage")
					->whereIn('legals.client_status_id', [2,5,6])
		            ->whereBetween('legals.accept_meeting_date', [$from, $to])
		            ->orWhereIn('individuals.client_status_id', [2,5,6])
		            ->whereBetween('individuals.accept_meeting_date', [$from, $to])
		            ->first();

		if ($request->ajax()) {
            return view('statistics.closing_ajax', compact('formated_from', 'formated_to', 'result'));
        }else{
        	return back();
        }
    
	}


    /**
     * Display Statistics -  Sander Traffic based on input range Ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
	public function sandler_traffic(Request $request)
	{
        $from = $request->input('from');
		$to = $request->input('to');
		$formated_from = $request->input('formated_from');
		$formated_to = $request->input('formated_to');

        $this->validate($request, [
            'from' => 'date_format:"Y-m-d"|required|before:to',
            'to' => 'date_format:"Y-m-d"|required|after:from'           
        ]);
		$sandler = Sandler::select(DB::raw('SUM(sandler_dollar) as sandler_dollar, 
                                            SUM(invoice_din) as invoice_din,
                                            SUM(ppo_din) as ppo_din, 
                                            count(id) as invoice,
                                            sandler_percent as sandler_percent, 
                                            ppo as ppo'))
                            ->where('is_paid', 1)
                            ->whereBetween('paid_date', [$from, $to])
                            ->first();
		if ($request->ajax()) {
            return view('statistics.sandler_ajax', compact('formated_from', 'formated_to', 'sandler'));
        }else{
        	return back();
        }
   
	}

	 
    /**
     * Display Statistics - DISC/Devine Traffic based on input range Ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
	public function disc_devine_traffic(Request $request)
	{
        $from = $request->input('from');
		$to = $request->input('to');
		$formated_from = $request->input('formated_from');
		$formated_to = $request->input('formated_to');

        $this->validate($request, [
            'from' => 'date_format:"Y-m-d"|required|before:to',
            'to' => 'date_format:"Y-m-d"|required|after:from'           
        ]);
        $disc_devine = DiscDevine::select(DB::raw('SUM(dd_dollar) as dd_dollar,
                                            SUM(dd_din) as dd_din,
                                            count(id) as disc_devine,
                                            SUM(ppo_din) as ppo_din, 
                                            ppo as ppo'))
                            ->where('is_paid', 1)
                            ->whereBetween('paid_date', [$from, $to])
                            ->first();

		if ($request->ajax()) {
            return view('statistics.disc_devine_ajax', compact('formated_from', 'formated_to', 'disc_devine'));
        }else{
        	return back();
        }
 
	}


    /**
     * Display Statistics - Total Traffic based on input range Ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
	public function total_traffic(Request $request)
	{
        $from = $request->input('from');
		$to = $request->input('to');
		$formated_from = $request->input('formated_from');
		$formated_to = $request->input('formated_to');

        $this->validate($request, [
            'from' => 'date_format:"Y-m-d"|required|before:to',
            'to' => 'date_format:"Y-m-d"|required|after:from'           
        ]);

        $total = Invoice::select(DB::raw('SUM(value_euro) as total_euro,
                                        SUM(value_din) as total_din,
                                        count(id) as total,
                                        SUM(pdv_din) as pdv_din, 
                                        pdv as pdv,
                                        SUM(value_din_tax) as total_din_tax'))
                    ->where('is_paid', 1)
                    ->whereBetween('paid_date', [$from, $to])
                    ->first();

		if ($request->ajax()) {
            return view('statistics.total_ajax', compact('formated_from', 'formated_to', 'total'));
        }else{
        	return back();
        }
 
	}

}
