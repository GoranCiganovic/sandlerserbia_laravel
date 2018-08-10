<?php

namespace App\Http\Controllers;

use App\Classes\ExcelParse;
use App\Classes\Parse;
use App\Client;
use App\CompanySize;
use App\Legal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;

class LegalsController extends Controller
{
   
    /**
     * Validation Legal Rules
     *
     * @var array
     */
    protected $validation_rules = [
        'long_name' => 'required|max:255|unique:legals,long_name',
        'short_name' => 'max:100|unique:legals,short_name',
        'ceo' => 'alpha_spaces|min:2|max:45',
        'phone' => 'numeric_spaces|between:6,30',
        'email' => "email|min:7|max:150",
        'contact_person' => 'alpha_spaces|min:2|max:45',
        'contact_person_phone' => 'numeric_spaces|between:6,30',
        'identification' => 'numeric|digits_between:6,45|unique:legals,identification',
        'pib' => 'numeric|digits_between:6,45|unique:legals,pib',
        'activity' => 'max:255',
        'address' => 'min:2|max:150',
        'county' => 'alpha_spaces|min:2|max:45',
        'postal' => 'numeric|digits:5',
        'city' => 'alpha_spaces|min:2|max:45',
        'website' => 'max:45',
        'comment' => 'max:5000',
        'company_size_id' => 'integer|min:0|max:5',
    ];

    /**
     * Create a new Legals Controller instance.
     *
     * @return void
     */
    public function __construct(Legal $legal = null, CompanySize $company_size = null, Parse $parse = null, ExcelParse $excel = null)
    {
        $this->legal = $legal;
        $this->company_size = $company_size;
        $this->parse = $parse;
        $this->excel = $excel;
    }

    /**
     * Show the form for creating a new Legal
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company_sizes = $this->company_size->get_company_sizes();
        $current_time = $this->parse->generate_current_time_session_key('single_submit');
        return view('suspects.create_legal', compact('company_sizes', 'current_time'));
    }

    /**
     * Show the form for creating a new Legals from file.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_from_file()
    {
        $current_time = $this->parse->generate_current_time_session_key('single_submit');
        return view('suspects.create_legal_from_file', compact('current_time'));
    }

    /**
     * Store New Legal Client
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validation_rules['single_submit'] = 'numeric|size:' . $request->session()->get('single_submit');
        $this->validate($request, $this->validation_rules);
        /* Unique Nullable Columns */
        $request['short_name'] = $request->input('short_name') ? $request->input('short_name') : null;
        $request['identification'] = $request->input('identification') ? $request->input('identification') : null;
        $request['pib'] = $request->input('pib') ? $request->input('pib') : null;

        DB::beginTransaction();

        try {
            /* Create Client and Legal Suspect */
            Legal::create(array_merge($request->all(), ['client_id' => Client::create(['legal_status_id' => 1])->id]));
            /* Remove Single Submit Session */
            $request->session()->forget('single_submit');

            DB::commit();
            $request->session()->flash('message', 'Suspect ' . $request->input('long_name') . ' je uspešno unet.');
        } catch (Exception $e) {
            DB::rollback();
            $request->session()->flash('message', 'Greška!');
        }
        return back();
    }

    /**
     * Store a new Legals from uploaded file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_file(Request $request)
    {
        $this->validate($request, [
            'excel_file' => 'required|file|mimes:xlsx,xls,xla,xlam,xlsm,xlt,xltx,xltm|max:2048',
            'single_submit' => 'numeric|size:' . $request->session()->get('single_submit'),
        ]);

        $excel_file = $request->file('excel_file');
        
        DB::beginTransaction();

        try {
            if ($request->hasFile('excel_file') && $excel_file->isValid()) {
                $file_name = $excel_file->getClientOriginalName(); // File Name
                $request->file('excel_file')->move($this->excel->get_excel_file_path(true, ''), $file_name); //Move File
                $file_path = $this->excel->get_excel_file_path(true, $file_name); //File Storage Path

                $filled = $this->excel->fileIsFilled($file_path); //Filled In File
                if (!$filled) {
                    Storage::disk('local')->delete($this->excel->get_excel_file_path(false, $file_name)); // Delete File
                    $request->session()->flash('message', 'Dokument je prazan!');
                    return back();
                }
                $headers = $this->excel->getHeaders($file_path); //Headers Form Excel File
                $false_headers = $this->excel->checkHeaders($headers); //Check Headers
                if ($false_headers) {
                    Storage::disk('local')->delete($this->excel->get_excel_file_path(false, $file_name)); // Delete File
                    $request->session()->flash('message', 'Greška! Neispravan naziv polja: ' . $false_headers);
                    return back();
                }

                $excel_array = $this->excel->createExcelArrayWithTableNames($file_path); //Excel File As Array
                $suspects_array = $this->excel->replaceCompanySizeValue($excel_array); // Replace String With Int
                Storage::disk('local')->delete($this->excel->get_excel_file_path(false, $file_name)); // Delete File
 
                foreach ($suspects_array as $array) {
                    /* Add Excel File Row In Request Object */
                    $request->request->add($array);
                    /* Validate Each Excel File Row */
                    $this->validate($request, $this->validation_rules);
                    /* Create Client and Legal Suspects */
                    Legal::create(array_merge($array, ['client_id' => Client::create(['legal_status_id' => 1])->id]));
                }

                /* Remove Single Submit Session */
                $request->session()->forget('single_submit');
                
                DB::commit();
                $request->session()->flash('message', 'Podaci su uspešno uneti u bazu.');
            } else {
                $request->session()->flash('message', 'Greška! Neispravan dokument!');
            }
        } catch (Exception $e) {
            DB::rollback();
            $request->session()->flash('message', 'Greška!');
        }

        return back();
    }

    /**
     * Update Legal profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Legal  $legal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Legal $legal)
    {

        $this->validate($request, [
            'long_name' => "required|max:255|unique:legals,long_name,{$legal->id}",
            'short_name' => "max:100|unique:legals,short_name,{$legal->id}",
            'ceo' => 'alpha_spaces|min:2|max:45',
            'phone' => 'numeric_spaces|between:6,30',
            'email' => "email|min:7|max:150",
            'contact_person' => 'alpha_spaces|min:2|max:45',
            'contact_person_phone' => 'numeric_spaces|between:6,30',
            'identification' => "numeric|digits_between:6,45|unique:legals,identification,{$legal->id}",
            'pib' => "numeric|digits_between:6,45|unique:legals,pib,{$legal->id}",
            'activity' => 'max:255',
            'address' => 'min:2|max:150',
            'county' => 'alpha_spaces|min:2|max:45',
            'postal' => 'numeric|digits:5',
            'city' => 'alpha_spaces|min:2|max:45',
            'website' => 'max:45',
            'comment' => 'max:5000',
            'company_size_id' => 'filled|integer|min:0|max:5',
        ]);

        /* Unique Nullable Columns */
        $request['short_name'] = $request->input('short_name') ? $request->input('short_name') : null;
        $request['identification'] = $request->input('identification') ? $request->input('identification') : null;
        $request['pib'] = $request->input('pib') ? $request->input('pib') : null;

        $legal->update($request->except('_token'));

        $request->session()->flash('message', 'Profil je uspešno izmenjen.');

        return back();
    }

    /**
     * Update Legal Meeting Date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Legal  $legal
     * @return \Illuminate\Http\Response
     */
    public function add_meeting_date(Request $request, Legal $legal)
    {
        $this->validate($request, [
            'format_meeting_date' => 'date_format:"d.m.Y. H:i"',
            'meeting_date' => 'date_format:"Y-m-d H:i"',
        ]);
 
        try {
            if ($legal->client_status_id == 3) {
                $legal->update($request->all());

                $request->session()->flash('message', 'Datum sastanka je uspešno unet.');
            }
        } catch (Exception $e) {
            $request->session()->flash('message', 'Greška!');
        }

        return back();
    }
}
