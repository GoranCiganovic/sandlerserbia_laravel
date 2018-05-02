<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\ExchangeRate;
use Mail;
use Exception;
use Illuminate\Support\Facades\Log;
use Sunra\PhpSimple\HtmlDomParser;


class ExchangeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user, ExchangeRate $exchange)
    {
        parent::__construct();
        
        $this->user = $user;
        $this->exchange = $exchange;
    }

    /**
     * Update Exchage Rate Or Send Email to Admin and SuperAdmin if It Fails
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            /* Euro and Dollar From Web */
            $euro = $this->getWebExhangeRate('EUR');
            $dollar = $this->getWebExhangeRate('USD');

            if(is_numeric($euro) && is_numeric($dollar)){
                /* Update Euro And Dollar Exchange */
                $this->exchange->update_currency('EUR', $euro);
                $this->exchange->update_currency('USD', $dollar);

            }else{
                $admin_email = $this->user->get_admin_email();
                $data = ['exchange_url' => config('constants.exchange_url')];
                /* Sending Emial To Admin And SuperAdmin With Error Message */
                Mail::send('exchange_rates.emails.false_exchange', $data, function ($message) use ($admin_email) 
                {
                    $message->from(config('mail.username'), config('constants.application_name'));
                    $message->to($admin_email);
                    $message->bcc(config('constants.superadmin_email'));
                    $message->subject('Neispravan kurs');
                });
            } 

            $this->info('Exchange:Cron Cummand Run successfully!');
             
        }catch(Exception $e){

            Log::info('Exchange:Cron Failed!'); 
        }     
    }

    /*
        Returns Exchage Rate From Web (Banca Intesa) 
    */
    public function getWebExhangeRate($currency){

        $page = file_get_contents(config('constants.exchange_url'));//constant url seed(config/constants.php)
        $raw = HtmlDomParser::str_get_html( $page );
        $table = $raw->find('.currencyListTable',0);
        if($table){
            $rowData = array();
            foreach($table->find('tr') as $row){
                $flight = array();
                foreach($row->find('td') as $cell) {
                    $flight[] = $cell->plaintext;                
                }
                $rowData[] = $flight;
            } 
            unset($rowData[0]);//unset first element (empty)
            foreach($rowData as $key=>$data){
                if($currency == $data[1]){
                     return $data[4];   
                }
             }
        }else{
            return false;
        }
    }


}
