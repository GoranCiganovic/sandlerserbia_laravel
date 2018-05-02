<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;
use Exception;

class TemplatesController extends Controller
{
    /**
     * Create a new Template Controller instance.
     *
     * @return void
     */
    public function __construct(Template $template = null)
    {
        $this->template = $template;
    }


    /**
     * Show the form for editing Template Options
     *
     * @param  \App\Template $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        return view('templates.edit_template', compact('template'));
    }


    /**
     * Update emplate Options
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        $this->validate($request, [
            'logo_bg' => "boolean",
            'logo_hd' => "boolean",
            'line_hd' => "boolean",
            'line_ft' => "boolean",
            'paginate' => "boolean",
            'margin_top' => "required|numeric|between:0,50",
            'margin_right' => "required|numeric|between:0,30",
            'margin_bottom' => "required|numeric|between:0,30",
            'margin_left' => "required|numeric|between:0,30"
        ]);

        $logo_bg = is_null($request->get('logo_bg')) ? 0 : 1;
        $logo_hd = is_null($request->get('logo_hd')) ? 0 : 1;
        $line_hd = is_null($request->get('line_hd')) ? 0 : 1;
        $line_ft = is_null($request->get('line_ft')) ? 0 : 1;
        $paginate = is_null($request->get('paginate')) ? 0 : 1;

        $template->update([
            'logo_bg' =>  $logo_bg,
            'logo_hd' =>  $logo_hd,
            'line_hd' =>  $line_hd,
            'line_ft' =>  $line_ft,
            'paginate' => $paginate,
            'margin_top' => $request->input('margin_top'),
            'margin_right' => $request->input('margin_right'),
            'margin_bottom' => $request->input('margin_bottom'),
            'margin_left' => $request->input('margin_left')
        ]);

        $request->session()->flash('message', 'Opcije su uspešno izmenjene.');

        return back();
       
    }

}
