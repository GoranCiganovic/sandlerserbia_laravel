<?php

namespace App\Http\Controllers;

use App\Article;
use App\Classes\Parse;
use App\Client;
use App\Contract;
use App\GlobalTraining;
use App\Http\Requests\InvoiceRequest;
use App\Template;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Purifier;

class PdfController extends Controller
{
    /**
     * Create a new Pdf Controller instance.
     *
     * @return void
     */
    public function __construct(GlobalTraining $global_training = null, Client $client = null, Article $article = null, Template $template = null, Parse $parse = null)
    {
        $this->global_training = $global_training;
        $this->client = $client;
        $this->article = $article;
        $this->template = $template;
        $this->parse = $parse;
    }

    /**
     * Display PDF Contract Template
     *
     * @return \Illuminate\Http\Response
     */
    public function contract_template()
    {
        /* Articles */
        $articles = $this->article->get_articles();
        /* Articles Need Break Tag */
        $articles_br_array = [5, 6, 7, 8, 9, 10];
        /* HTML From Articles */
        $html['contract'] = '';
        foreach ($articles as $article) {
            if (in_array($article->id, $articles_br_array)) {
                $html['contract'] .= "<br>" . $article->html;
            } else {
                $html['contract'] .= $article->html;
            }
        }
        /* Contract PDF Filename */
        $filename = 'Ugovor_template.pdf';
        /* Template Options */
        $options = $this->get_pdf_template_options();
        /* Background Logo */
        $html['logo_bg'] = $options['logo_bg'];
        /* Load PDF View */
        $pdf = $this->load_pdf_contract_view($html, 'template', $options);
        /* Display PDF From Page */
        return $pdf->inline()->withHeaders($this->get_pdf_headers($filename));
    }

    /**
     * Display PDF Contract Default
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function contract_default(Contract $contract)
    {
        /* Contract Unsigned Status */
        if ($contract->contract_status_id == 1) {
            try {
                /* Articles */
                $html = $this->article->get_articles_html();
                /* Global Training */
                $html['gt'] = $global_training = $this->global_training->get_global_training();
                /* Get Client (Legal or Individal) */
                $client_array = $this->client->get_client($contract->client)->toArray();
                /* Contract Client Array Fof PDF View */
                $html['client'] = $this->parse->get_client_contract_pdf($contract->client->legal_status_id, $client_array);
                /* Contract */
                $html['contract'] = $contract;
                $html['payments'] = $contract->payment;
                $html['participants'] = $contract->participant;
                /* Template Options */
                $options = $this->get_pdf_template_options();
                /* Background Logo */
                $html['logo_bg'] = $options['logo_bg'];
                /* Contract PDF Filename */
                $filename = 'Ugovor_' . $contract->contract_number . '.pdf';
                /* Contract PDF File Path */
                $pdf_file = $this->parse->get_pdf_contract_path(true, $contract->client_id, $contract->id, $filename);
                /* Load PDF View */
                $pdf = $this->load_pdf_contract_view($html, 'default', $options);
                /* Delete PDF File If It Exists */
                if (file_exists($pdf_file)) {
                    unlink($pdf_file);
                }
                /* Save PDF File */
                $pdf->save($pdf_file);
                /* Display PDF From Page */
                return $pdf->inline()->withHeaders($this->get_pdf_headers($filename));
            } catch (Exception $e) {
                $request->session()->flash('message', 'Greška!');
            }
        }

        return back();
    }

    /**
     * Display PDF Contract Custom
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function contract_custom(Request $request, Contract $contract)
    {
        /* Contract Unsigned Status */
        if ($contract->contract_status_id == 1) {
            /* Input Validation */
            $this->validate($request, ['contract_html' => 'required']);
            /* Set Absolute Image Path For PDF View  */
            $contract_html = str_replace('src="', 'src="'.public_path(), $request->input('contract_html'));
            /* HTMl Contract Stored or From Input Cleaned with Purifier */
            $html['contract'] = $contract->html ? $contract->html : $contract_html;
            /* Template Options */
            $options = $this->get_pdf_template_options();
            /* Background Logo */
            $html['logo_bg'] = $options['logo_bg'];
            /* Contract PDF Filename */
            $filename = 'Ugovor_' . $contract->contract_number . '.pdf';
            /* Contract PDF File Path */
            $pdf_file = $this->parse->get_pdf_contract_path(true, $contract->client_id, $contract->id, $filename);
            /* Load PDF View */
            $pdf = $this->load_pdf_contract_view($html, 'template', $options);
            /* Delete PDF File If It Exists */
            if (file_exists($pdf_file)) {
                unlink($pdf_file);
            }
            /* Save PDF File */
            $pdf->save($pdf_file);
            /* Display PDF From Page */
            return $pdf->inline()->withHeaders($this->get_pdf_headers($filename));
        } else {
            return back();
        }
    }

    /**
     * Save Contract Custom Html
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function save_contract_custom(Request $request, Contract $contract)
    {
        /* Contract Unsigned Status */
        if ($contract->contract_status_id == 1) {
            /* Input Validation */
            $this->validate($request, ['contract_html' => 'required']);
            /* Set Absolute Image Path For PDF View  */
            $contract_html = str_replace('src="', 'src="'.public_path(), $request->input('contract_html'));
            /* Update Contract Html */
            $contract->update(['html' =>  $contract_html]);
            /* PDF Cleaned With Purified Html */
            $html['contract'] = Purifier::clean($request->input('contract_html'));
            /* Template Options */
            $options = $this->get_pdf_template_options();
            /* Background Logo */
            $html['logo_bg'] = $options['logo_bg'];
            /* Load PDF View */
            $pdf = $this->load_pdf_contract_view($html, 'template', $options);
            /* Contract PDF Filename */
            $filename = 'Ugovor_' . $contract->contract_number . '.pdf';
            /* PDF File Path */
            $pdf_file = $this->parse->get_pdf_contract_path(true, $contract->client_id, $contract->id, $filename);
            /* Contract Unsigned Status */
            if ($contract->contract_status_id == '1') {
                /* Delete PDF File If It Exists */
                if (file_exists($pdf_file)) {
                    unlink($pdf_file);
                }
                /* Save PDF File */
                $pdf->save($pdf_file);
            }
            $request->session()->flash('message', 'Ugovor je uspešno sačuvan.');
        }

        return back();
    }

    /**
     * Display PDF Contract Signed
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function contract_signed(Contract $contract)
    {
        /* Contract All But Unsigned Status */
        if ($contract->contract_status_id != 1) {
            /* Contract PDF Filename */
            $filename = 'Ugovor_' . $contract->contract_number . '.pdf';
            /* PDF File Path */
            $pdf_file = $this->parse->get_pdf_contract_path(true, $contract->client_id, $contract->id, $filename);

            if (file_exists($pdf_file)) {
                /* Display Stored PDF File */
                return response()->file($pdf_file, $this->get_pdf_headers($filename));
            } elseif ($contract->html) {
                /* HTMl Contract Stored or From Input*/
                $html['contract'] = $contract->html;
                /* Template Options */
                $options = $this->get_pdf_template_options();
                /* Background Logo */
                $html['logo_bg'] = $options['logo_bg'];
                /* Load PDF View */
                $pdf = $this->load_pdf_contract_view($html, 'template', $options);
                /* Save PDF File */
                $pdf->save($pdf_file);
                /* Display Stored PDF File */
                return response()->file($pdf_file, $this->get_pdf_headers($filename));
            } else {
                return back();
            }
        } else {
            return back();
        }
    }

    /**
     * Display PDF Invoice or Proinvoice Preview
     *
     * @param  \App\Http\Requests\InvoiceRequest $request
     * @param  string $type
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function invoice_proinvoice_preview(InvoiceRequest $request, $type, Client $client)
    {
        /* Input Validation */
        $this->validate($request, $request->rules());
        /* Payment type (Invoice or Proinvoice) */
        $type = $this->parse->get_payment_type($type);
        /* Input Values */
        $payment = $request->all();
        $payment['number'] = $type['name'] . ' broj: ';
        $payment['type'] = $type['name'];
        /* Get Client (Legal or Individal) */
        $client_array = $this->client->get_client($client)->toArray();
        /* Client Array For Invoice PDF View */
        $client = $this->parse->get_client_invoice_pdf($client->legal_status_id, $client_array);
        /* Global Training Array */
        $global_training = $this->global_training->get_global_training()->toArray();
        /* Invoice or Proinvoice Data */
        $data = ['gt' => $global_training, 'client' => $client, 'payment' => $payment];
        /* Load PDF View */
        $pdf = $this->load_pdf_invoice_view($type['name'], $data);
        /* Display PDF From Page */
        return $pdf->inline()->withHeaders($this->get_pdf_headers($type['name']));
    }

    /**
     * Display PDF Invoice or Proinvoice
     *
     * @param  string  $invoice_type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice_proinvoice($invoice_type, $id, Client $client)
    {
        /* Type (Invoice or Proinvoice) */
        $type = $this->parse->get_payment_type($invoice_type);
        if ($type) {
            /* Invoice or Proinvoice */
            $payment = DB::table($type['table'])->where('id', $id)->first();
            if ($payment) {
                /* Make Array From Object For PDF View */
                $payment = (array) $payment;
                /* Invoice or Proinvoice Number */
                $payment['number'] = $type['name'] . ' broj: ' . $payment[$type['number']];
                /* Invoice or Proinvoice  */
                $payment['type'] = $type['name'];
                /* Get Client (Legal or Individal) */
                $client_array = $this->client->get_client($client)->toArray();
                /* Client Array For Invoice PDF View */
                $client = $this->parse->get_client_invoice_pdf($client->legal_status_id, $client_array);
                /* Global Training Array */
                $global_training = $this->global_training->get_global_training()->toArray();
                /* Invoice or Proinvoice Data */
                $data = ['gt' => $global_training, 'client' => $client, 'payment' => $payment];
                /* Load PDF View (Invoice or Proinvoice) */
                $pdf = $this->load_pdf_invoice_view($type['name'], $data);
                /* Invoice or Proinvoice Number */
                $number = str_replace("/", "_", $payment[$type['number']]);
                /* Invoice or Proinvoice PDF Filename */
                $filename = $type['name'] . '_' . $number . '.pdf';
                /* Invoice or Proinvoice PDF File Path */
                $pdf_file = $this->parse->get_pdf_invoice_path(true, $client['id'], $payment['contract_id'], $filename);
                /* Invoice or Proinvoice Status Issued */
                if ($payment['is_issued'] == '1') {
                    /* Save PDF File If It Doesn't Exists */
                    if (!file_exists($pdf_file)) {
                        $pdf->save($pdf_file);
                    }
                    /* Display Stored PDF File */
                    return response()->file($pdf_file, $this->get_pdf_headers($filename));
                } else {
                    /* Display PDF From Page */
                    return $pdf->inline()->withHeaders($this->get_pdf_headers($filename));
                }
            } else {
                abort(400);
            }
        } else {
            abort(400);
        }
    }

    /**
     * Returns Template Options Array For PDF View
     *
     * @return array
     */
    public function get_pdf_template_options()
    {
        $template = $this->template->get_template_options();
        $header_html = $template->logo_hd == 1 ? resource_path() . '/views/contracts/pdf/header.html' : '';
        $paginate = $template->paginate == 1 ? '[page] / [toPage]' : '';
        $header_line = $template->line_hd == 1;
        $footer_line = $template->line_ft == 1;
        return $options = [
            'logo_bg' => $template->logo_bg,
            'header-html' => $header_html,
            'header-line' => $header_line,
            'footer-line' => $footer_line,
            'footer-right' => $paginate,
            'margin-top' => $template->margin_top,
            'margin-right' => $template->margin_right,
            'margin-bottom' => $template->margin_bottom,
            'margin-left' => $template->margin_left,
        ];
    }

    /**
     * Returns PDF Contract View
     *
     * @param  string $view
     * @param  array $data
     * @param  array $params
     * @return \PDF
     */
    public function load_pdf_contract_view($data, $view = 'contract', $params = [])
    {

        return $pdf = PDF::loadView('contracts.pdf.' . $view, $data)
            ->setOption('title', isset($params['title']) ? $params['title'] : 'Ugovor')
            ->setOption('margin-top', isset($params['margin-top']) ? $params['margin-top'] : 30)
            ->setOption('margin-left', isset($params['margin-left']) ? $params['margin-left'] : 15)
            ->setOption('margin-right', isset($params['margin-right']) ? $params['margin-right'] : 15)
            ->setOption('margin-bottom', isset($params['margin-bottom']) ? $params['margin-bottom'] : 15)
            ->setOption('footer-font-size', isset($params['footer-font-size']) ? $params['footer-font-size'] : 10)
            ->setOption('footer-font-name', isset($params['footer-font-name']) ? $params['footer-font-name'] : 'Arial')
            ->setOption('footer-line', isset($params['footer-line']) ? $params['footer-line'] : true)
            ->setOption('footer-spacing', isset($params['footer-spacing']) ? $params['footer-spacing'] : 5)
            ->setOption('footer-right', isset($params['footer-right']) ? $params['footer-right'] : '[page] / [toPage]')
            ->setOption('header-html', isset($params['header-html']) ? $params['header-html'] : resource_path() . '/views/contracts/pdf/header.html')
            ->setOption('footer-font-size', isset($params['footer-font-size']) ? $params['footer-font-size'] : 8)
            ->setOption('header-font-name', isset($params['header-font-name']) ? $params['header-font-name'] : 'Helvetica')
            ->setOption('header-line', isset($params['header-line']) ? $params['header-line'] : true)
            ->setOption('header-spacing', isset($params['header-spacing']) ? $params['header-spacing'] : 15)
            ->setOption('enable-forms', isset($params['enable-forms']) ? $params['enable-forms'] : true);
    }

    /**
     * Returns PDF Invoice/Proinvoice View
     *
     * @param  string $typename
     * @param  array $data
     * @return \PDF
     */
    public function load_pdf_invoice_view($typename, $data)
    {
        return PDF::loadView('invoices.pdf', $data)
            ->setOption('title', $typename)
            ->setOption('margin-top', 20)
            ->setOption('margin-left', 20)
            ->setOption('margin-right', 20)
            ->setOption('margin-bottom', 0)
            ->setOption('footer-spacing', 0)
            ->setOption('header-spacing', 0);
    }

    /**
     * Returns Headers For PDF View (Name of PDF File On Download)
     *
     * @param  string $filename
     * @return array
     */
    public function get_pdf_headers($filename)
    {
        return $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'filename="' . $filename . '"',
        ];
    }
}
