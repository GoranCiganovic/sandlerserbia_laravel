<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sandler extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_din', 'middle_ex_dollar', 'sandler_percent', 'sandler_din', 'sandler_dollar', 'issued_date', 'paid_date', 'ppo', 'ppo_din', 'is_paid', 'invoice_id',
    ];

    /**
     * The attribute timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Invoice record associated with the Sandler.
     */
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    /**
     * Returns Number Of Sandler Invoices Issued Last Month
     *
     * @param  string $first_day
     * @param  string $last_day
     * @return  int
     */
    public function count_last_month_sandler_debt($first_day, $last_day)
    {
        return Sandler::whereBetween('issued_date', [$first_day, $last_day])->count();
    }

    /**
     * Returns Total Sandler Debt RSD Value Issued Last Month
     *
     * @param  string $first_day
     * @param  string $last_day
     * @return  float
     */
    public function get_last_month_sandler_debt($first_day, $last_day)
    {
        return Sandler::select(DB::raw('SUM(invoice_din) as invoice_din_total'))
            ->whereBetween('issued_date', [$first_day, $last_day])
            ->first()->invoice_din_total;
    }

    /**
     * Returns Number Of Sandler Invoices Not Paid With Paid Date Before Today (Home Page)
     *
     * @return int
     */
    public function count_sandler_debt_deadline_expired()
    {
        return Sandler::where('is_paid', 0)->where('paid_date', '<=', date('Y-m-d'))->count();
    }

    /**
     * Returns Sandler Debt Not Paid With Paid Date Before Today
     *
     * @return  \App\Sandler
     */
    public function get_sandler_debt_deadline_expired()
    {
        return Sandler::where('is_paid', 0)->where('paid_date', '<=', date('Y-m-d'))->get();
    }

    /**
     * Returns Number Sandler Invoices Not Paid With Paid Date On Today
     *
     * @return int
     */
    public function count_unpaid_sandler_payday_today()
    {
        return Sandler::where('is_paid', 0)->where('paid_date', date('Y-m-d'))->count();
    }

    /**
     * Update Sandler Debt Not Paid With Paid Date On Today
     *
     * @param  float $middle_ex_dollar
     * @param  float $sandler_percent
     * @param  float $ppo
     * @return bool
     */
    public function update_unpaid_sandler_payday_today($middle_ex_dollar, $ppo, $sandler_percent)
    {
        return Sandler::where('is_paid', 0)->where('paid_date', date('Y-m-d'))
            ->update([
                'middle_ex_dollar' => $middle_ex_dollar,
                'sandler_percent' => $sandler_percent,
                'ppo' => $ppo,
                'sandler_din' => DB::raw('(invoice_din*sandler_percent)/100'),
                'sandler_dollar' => DB::raw('sandler_din/middle_ex_dollar'),
                'ppo_din' => DB::raw('(invoice_din*ppo)/100'),
                'is_paid' => 1,
            ]);
    }

    /**
     *  Create Sandler Debt  - Insert Value Din, Issued Date, Paid Date, Invoice Id
     *
     * @param  float $value_din
     * @param  string $issued_date
     * @param  int $invoice_id
     * @return void
     */
    public function create_sandler_debt($invoice_din, $issued_date, $paid_date, $invoice_id)
    {
        return Sandler::create([
            'invoice_din' => $invoice_din,
            'issued_date' => $issued_date,
            'paid_date' => $paid_date,
            'invoice_id' => $invoice_id,
        ]);
    }
}
