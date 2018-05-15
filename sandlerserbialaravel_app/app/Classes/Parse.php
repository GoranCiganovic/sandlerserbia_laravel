<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Parse
{

    /**
     * Returns No JavaScript Message Response
     *
     * @param  boolean $user
     * @return  array
     */
    public function getNoJSMessage($user)
    {
        if ($user) {
            $data['information'] = 'Greška';
            $data['message'] = 'Za korišćenje aplikacije neophodan je JavaScript!';
            $data['img_path'] = '/storage/images/nojs/ser/no_js_oswald_san_blue.png';
            $data['reload'] = 'Učitaj ponovo';
            $data['logout'] = 'Odjavi se';
        } else {
            $data['information'] = 'Failure';
            $data['message'] = 'JavaScript is required to use the application!';
            $data['img_path'] = '/storage/images/nojs/eng/no_js_oswald_san_blue.png';
            $data['reload'] = 'Reload';
            $data['logout'] = 'Logout';
        }
        return $data;
    }

    /**
     * Returns column name and order by value based on sort filter value
     *
     * @param  string $sort_filter
     * @return  array
     */
    public function getSortFilterArrayValue($sort_filter)
    {
        switch ($sort_filter) {
            case '1':
                return ['legal_column' => 'long_name',
                'individual_fcolumn' => 'first_name',
                'individual_lcolumn' => 'last_name',
                'order_by' => 'ASC'];
            break;
            case '2':
                return ['legal_column' => 'long_name',
                'individual_fcolumn' => 'first_name',
                'individual_lcolumn' => 'last_name',
                'order_by' => 'DESC'];
            break;
            case '3':
                return ['legal_column' => 'laravel_legals.id',
                'individual_fcolumn' => 'laravel_individuals.id',
                'individual_lcolumn' => 'laravel_individuals.id',
                'order_by' => 'ASC'];
            break;
            case '4':
                return ['legal_column' => 'laravel_legals.id',
                'individual_fcolumn' => 'laravel_individuals.id',
                'individual_lcolumn' => 'laravel_individuals.id',
                'order_by' => 'DESC'];
            break;
            default:
                return ['legal_column' => 'long_name',
                'individual_fcolumn' => 'first_name',
                'individual_lcolumn' => 'last_name',
                'order_by' => 'ASC'];
            break;
        }
    }

    /**
     * Returns legal statuses based on legal filter id
     *
     * @param  string $legal_filter
     * @return  array
     */
    public function getSortLegalStatuses($legal_filter)
    {
        return $legal_status_in = $legal_filter ? [$legal_filter] : ['1', '2'];
    }

    /**
     *  Returns statistic title, fa icon and statistic method
     *
     * @param  string $param
     * @return  array
     */
    public function getStatisticsParams($param)
    {
        switch ($param) {
            case 'conversation_ratio':
                return ['title' => 'Conversation Ratio',
                'fa_icon' => '<i class="fa fa-btn fa-phone-square" aria-hidden="true"></i>',
                'submit' => 'conversation_ratio'];
            break;
            case 'closing_ratio':
                return ['title' => 'Closing Ratio',
                'fa_icon' => '<i class="fa fa-btn fa-star" aria-hidden="true"></i>',
                'submit' => 'closing_ratio'];
            break;
            case 'sandler_traffic':
                return ['title' => 'Sandler procenat',
                'fa_icon' => '<span class="sandler-systems-icon-lg glyphicon glyphicon-globe"></span>&nbsp;&nbsp;',
                'submit' => 'sandler_traffic'];
            break;
            case 'disc_devine_traffic':
                return ['title' => 'DISC/Devine promet',
                'fa_icon' => '<span class="disc-devine-icon-lg glyphicon glyphicon-globe"></span>&nbsp;&nbsp;',
                'submit' => 'disc_devine_traffic'];
            break;
            case 'total_traffic':
                return ['title' => 'Ukupan promet',
                'fa_icon' => '<i class="fa fa-btn fa-calculator" aria-hidden="true"></i>',
                'submit' => 'total_traffic'];
            break;
            default:
                return false;
            break;
        }
    }

    /**
     * Returns  Date With A Name Of The Month In Serbian
     *
     * @param  string $date
     * @return  string
     */
    public function get_serbian_month_name($date)
    {
        $date = str_replace("January", "Januar", $date);
        $date = str_replace("February", "Februar", $date);
        $date = str_replace("March", "Mart", $date);
        $date = str_replace("April", "April", $date);
        $date = str_replace("May", "Maj", $date);
        $date = str_replace("June", "Jun", $date);
        $date = str_replace("July", "Jul", $date);
        $date = str_replace("August", "Avgust", $date);
        $date = str_replace("September", "Septembar", $date);
        $date = str_replace("October", "Octobar", $date);
        $date = str_replace("November", "Novembar", $date);
        $date = str_replace("December", "Decembar", $date);
        return $date;
    }

    /**
     * Returns  Date With A Name Of The Day In Serbian
     *
     * @param  string $date
     * @return  string
     */
    public function get_serbian_day_name($date)
    {
        $date = str_replace("Monday", "Ponedeljak", $date);
        $date = str_replace("Tuesday", "Utorak", $date);
        $date = str_replace("Wednesday", "Sreda", $date);
        $date = str_replace("Thursday", "Četvrtak", $date);
        $date = str_replace("Friday", "Petak", $date);
        $date = str_replace("Saturday", "Subota", $date);
        $date = str_replace("Sunday", "Nedelja", $date);
        return $date;
    }

    /**
     * Returns  Name Of Previous Month
     *
     * @return  string
     */
    public function get_previous_month_name()
    {
        $months = [
            '01' => "Januar",
            '02' => "Februar",
            '03' => "Mart",
            '04' => "April",
            '05' => "Maj",
            '06' => "Jun",
            '07' => "Jul",
            '08' => "Avgust",
            '09' => "Septembar",
            '10' => "Oktobar",
            '11' => "Novembar",
            '12' => "Decembar",
        ];
        $previous_month = date('m', strtotime(date('Y-m-d') . " -1 month"));
        foreach ($months as $key => $value) {
            if ($key == $previous_month) {
                return $value;
            }
        }
    }

    /**
     * Returns Next Month Paying Date Based On The Day In Format Y-m-d
     *
     * @param  string $day
     * @return  string
     */
    public function get_next_month_paying_date($day)
    {
        $next_month_date = date('Y-m-d', strtotime('+1 month'));
        $date_array = explode('-', $next_month_date);
        return $date_array[0] . '-' . $date_array[1] . '-' . $day;
    }

    /**
     * Returns First And Last Day Of The Previous Month
     *
     * @return  array
     */
    public function get_first_and_last_day_previous_month()
    {
        $last_month_start = new Carbon('first day of last month');
        $last_month_end = new Carbon('last day of last month');
        $data['from'] = $last_month_start->toDateString();
        $data['to'] = $last_month_end->toDateString();
        return $data;
    }

    /**
     * Creates And Returns Session Key With Current Time
     *
     * @param string $session_key
     * @return int
     */
    public function generate_current_time_session_key($session_key)
    {
        session([$session_key => time()]);
        return session()->get($session_key);
    }

    /**
     * Returns Array of Payment Type (Proinvoice/Invoice)
     *
     * @param  string $type
     * @return  array
     */
    public function get_payment_type($type)
    {

        switch ($type) {
            case 'proinvoice':
                return ['type' => 'proinvoice',
                'name' => 'Profaktura',
                'class' => 'Proinvoice',
                'table' => 'proinvoices',
                'number' => 'proinvoice_number',
                'submit' => 'PROFAKTURU'];
            break;
            case 'invoice':
                return ['type' => 'invoice',
                'name' => 'Faktura',
                'class' => 'Invoice',
                'table' => 'invoices',
                'number' => 'invoice_number',
                'submit' => 'FAKTURU'];
            break;
            default:
                return false;
            break;
        }
    }

    /**
     * Returns Client Status Id Based On Status Name
     *
     * @param  string $status_name
     * @return  int
     */
    public function get_client_status_id_by_name($status_name)
    {

        switch ($status_name) {
            case 'active':
                return 6;
            break;
            case 'inactive':
                return 5;
            break;
            case 'jpb':
                return 4;
            break;
            case 'accept_meeting':
                return 3;
            break;
            case 'disqualified':
                return 2;
            break;
            case 'uncontacted':
                return 1;
            break;
            default:
                return 0;
            break;
        }
    }

    /**
     * Returns Contract Status Id Based On Status Name
     *
     * @param  string $status_name
     * @return  int
     */
    public function get_contract_status_id($status_name)
    {

        switch ($status_name) {
            case 'broken':
                return 4;
            break;
            case 'finished':
                return 3;
            break;
            case 'in_progress':
                return 2;
            break;
            case 'unsigned':
                return 1;
            break;
            default:
                return 0;
            break;
        }
    }

    /**
     * Returns Pdf Invoice/Proinvoice Storage Path (Without Filename Returns Directory Path)
     *
     * @param  bool $full_path
     * @param  int $client_id
     * @param  int $contract_id
     * @param  string $filename
     * @return  string
     */
    public function get_pdf_invoice_path($full_path, $client_id, $contract_id, $filename)
    {
        $path = config('constants.pdf_storage_path') . '/client_id_' . $client_id . '/contracts/contract_id_' . $contract_id . '/payments/' . $filename;
        return $full_path ? storage_path($path) : $path;
    }

    /**
     * Returns Pdf Contract Storage Path (Without Filename Returns Directory Path)
     *
     * @param  bool $full_path
     * @param  int $client_id
     * @param  int $contract_id
     * @param  string $filename
     * @return  string
     */
    public function get_pdf_contract_path($full_path, $client_id, $contract_id, $filename)
    {
        $path = config('constants.pdf_storage_path') . '/client_id_' . $client_id . '/contracts/contract_id_' . $contract_id . '/' . $filename;
        return $full_path ? storage_path($path) : $path;
    }

    /**
     * Get Client (Legal or Individual) Data For PDF Contract View
     *
     * @param int $legal_status
     * @param  array $client
     * @return array
     */
    public function get_client_contract_pdf($legal_status, $client)
    {
        if ($legal_status == 1) {
            /* Legal Client */
            $client['name'] = $client['long_name'];
            $client['servise_user'] = $client['address'] . ', matični broj ' . $client['identification'] . ', PIB ' . $client['pib'] . ', koje zastupa ' . $client['ceo'] . ',  direktor';
        } else {
            /* Individual Client */
            $name = $client['first_name'] . " " . $client['last_name'];
            $client['name'] = $name;
            $client['servise_user'] = 'JMBG ' . $client['jmbg'] . ', br. lične karte ' . $client['id_card'] . ', ' . $client['address'] . ', ' . $client['city'];
            $client['short_name'] = $name;
            $client['ceo'] = $name;
        }
        return $client;
    }

    /**
     * Get Client (Legal or Individual) Data For PDF View Invoice/Proinvoice/Presentation
     *
     * @param int $legal_status
     * @param  array $client
     * @return array
     */
    public function get_client_invoice_pdf($legal_status, $client)
    {
        if ($legal_status == 1) {
            /* Legal Client */
            $client['name'] = $client['long_name'];
            $client['id_number'] = 'Matični broj';
            $client['personal_number'] = 'PIB';
        } else {
            /* Individual Client */
            $client['name'] = $client['first_name'] . " " . $client['last_name'];
            $client['id_number'] = 'JMBG';
            $client['personal_number'] = 'Broj lične karte';
            $client['identification'] = $client['jmbg'];
            $client['pib'] = $client['id_card'];
        }
        return $client;
    }

    /**
     * Returns Next Invoice or Proinvoice Number based on Legal Status
     *
     * @param  int  $legal_status
     * @param  array  $type
     * @return  array
     */
    public function next_invoice_proinvoice_number($legal_status, $type)
    {
        if ($legal_status == 1) {
            return $this->get_next_invoice_proinvoice_legal_number($type);
        } else {
            return $this->get_next_invoice_proinvoice_internally_number($type);
        }
    }

    /**
     * Returns Next Invoice or Proinvoice Number based on last stored Invoice/Proinvoice Number
     *
     * @param  array  $type
     * @return  array
     */
    public function get_next_invoice_proinvoice_legal_number($type)
    {
        /* Current Year */
        $current_year = date('Y');
        /* Last Proinvoice or Invoice Serial Number (Where Proinvoice or Invoice Number Is Not Null */
        $last = DB::table($type['table'])->whereNotNull($type['type'] . '_number')->latest('serial_number')->first();

        if (!$last || !$last->$type['number']) {
            //Next Proinvoice or Invoice Serial Number
            $next['serial_number'] = 1;
            //Next Proinvoice or Invoice Number (Serial Number/Current Year)
            $next[$type['number']] = $next['serial_number'] . '/' . $current_year;
        } else {
            //Last Proinvoice or Invoice Number
            $last_number = $last->$type['number'];
            //Explode Last Number on Serial Number and Year
            $array = explode('/', $last_number);
            //Serial Number - Incremented Last Serial Number
            $serial_number = ++$last->serial_number;
            //Proinvoice or Invoice Year Number
            $year = $array[1];

            if ($year == $current_year) {
                $next['serial_number'] = $serial_number;
                $next[$type['number']] = $next['serial_number'] . '/' . $year;
            } else {
                //Increment Year and Reset Serial Number
                ++$year;
                $next['serial_number'] = 1;
                $next[$type['number']] = $next['serial_number'] . '/' . $year;
            }
        }
        return $next;
    }

    /**
     * Returns Invoice or Proinvoice Internally Number
     *
     * @param  array  $type
     * @return  array
     */
    public function get_next_invoice_proinvoice_internally_number($type)
    {
        /* Current Year */
        $current_year = date('Y');
        /* Current Time */
        $current_timestamp = Carbon::now()->timestamp;
        /* Last Proinvoice or Invoice Serial Number (Where Proinvoice or Invoice Number Is Not Null */
        $last = DB::table($type['table'])->whereNotNull($type['type'] . '_number')->latest('serial_number')->first();
        /* Next Serial Number (0 if Not Exist) */
        if (!$last || !$last->$type['number']) {
            $next['serial_number'] = 0;
        } else {
            $next['serial_number'] = $last->serial_number;
        }
        /* Next Proinvoice or Invoice Number - Interno Current Time / Current Year*/
        $next[$type['number']] = 'interno_' . $current_timestamp . '/' . $current_year;

        return $next;
    }

    /**
     * Returns Html String Without Tags Doctype, Html, Head, Body And New Line(\r\n)
     *
     * @param  string  $html
     * @return  string
     */
    public function remove_unnecessary_html_tags($html)
    {
        $html_tags_arr = [
            "<!DOCTYPE html>", "<html>", "<head>", "</head>", "<body>", "</body>", "</html>", "\r\n",
        ];
        foreach ($html_tags_arr as $tag) {
            $html = str_replace($tag, "", $html);
        }
        return $html;
    }

    /**
     * Returns Html String Without Html Entities (Spaces - &nbsp;)
     *
     * @param  string  $html
     * @return  string
     */
    public function remove_html_space_entity($html)
    {
        return $html = str_replace("&nbsp;", "", $html);
    }
}
