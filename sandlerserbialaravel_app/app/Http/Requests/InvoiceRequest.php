<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InvoiceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value_euro' => 'required|numeric|digits_between:0,10|min:0',
            'exchange_euro' => 'required|numeric|digits_between:0,10|min:0',
            'value_din' => 'required|numeric|digits_between:0,10|min:0',
            'pdv' => 'required|numeric|digits_between:0,5|min:0',
            'pdv_din' => 'required|numeric|digits_between:0,10|min:0',
            'value_din_tax' => 'required|numeric|digits_between:0,10|min:0',
            'format_issue_date' => 'required|date_format:"d.m.Y."',
            'issue_date' => 'required|date_format:"Y-m-d"',
            'format_traffic_date' => 'required|date_format:"d.m.Y."',
            'traffic_date' => 'required|date_format:"Y-m-d"',
            'description' => 'required|max:255',
            'note' => 'required|max:255',

        ];
    }

    /**
     * Get the Store validation rules that do not apply to the request.
     *
     * @return array
     */
    public function store_except()
    {
        return [
            '_token', 'submit', 'form_pdf_action', 'contract_date', 'format_traffic_date', 'format_issue_date',
        ];
    }

    /**
     * Get the Update validation rules that do not apply to the request.
     *
     * @return array
     */
    public function update_except()
    {
        return [
            '_token', 'submit', 'form_pdf_action', 'contract_date', 'format_traffic_date', 'format_issue_date', 'form_issued_action', 'form_delete_action',
        ];
    }
}
