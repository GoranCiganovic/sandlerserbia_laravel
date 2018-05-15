<?php

/* Welcome Page */
Route::get('/', function () {
    return view('welcome');
});

Route::auth();

/* Home Page, Statistics, Debts, No Javascirpt */
Route::get('home', 'HomeController@index');
Route::get('statistics', 'HomeController@statistics');
Route::get('debts', 'HomeController@debts');
Route::get('nojs', 'HomeController@nojs');

/* Route Group with Middleware Auth, Allow */
Route::group(['middleware' => ['auth', 'allow']], function () {

    /* User Profile - Edit, Update */
    Route::get('user/edit/{user}', 'UserController@edit');
    Route::post('user/update/{user}', 'UserController@update');

    /* Rates Edit - Taxes, Sandler, DISC/Devine */
    Route::get('taxes/edit', 'RatesController@edit_taxes');
    Route::get('sandler/edit', 'RatesController@edit_sandler');
    Route::get('disc_devine/edit', 'RatesController@edit_disc_devine');

    /* Global Training Edit */
    Route::get('global_training/edit', 'GlobalTrainingController@edit');

    /* Exchange Rates Display, Edit */
    Route::get('exchange', 'ExchangeRatesController@index');
    Route::get('exchange/edit/{exchange}', 'ExchangeRatesController@edit');

    /* Articles */
    Route::get('articles', 'ArticlesController@index');
    /* Article Edit */
    Route::get('article/edit/{article}', 'ArticlesController@edit');

    /* Template Edit */
    Route::get('template/edit/{template}', 'TemplatesController@edit');

    /* Statistics (Home Page) - Conversation, Closing, Sandler, Disc/Devine, Total */
    Route::get('conversation_ratio', 'StatisticsController@conversation_ratio');
    Route::get('closing_ratio', 'StatisticsController@closing_ratio');
    Route::get('sandler_traffic', 'StatisticsController@sandler_traffic');
    Route::get('disc_devine_traffic', 'StatisticsController@disc_devine_traffic');
    Route::get('total_traffic', 'StatisticsController@total_traffic');

    /* Disc Devine (Home Page) - Current Debt, Edit Debt */
    Route::get('disc_devine/debt', 'DiscDevinesController@debt');
    Route::get('disc_devine/edit_debt/{disc_devine}', 'DiscDevinesController@edit');
    /* Sandler (Home Page) - Current Debt, Edit debt */
    Route::get('sandler/debt', 'SandlersController@debt');
    Route::get('sandler/edit_debt/{sandler}', 'SandlersController@edit');
    /* PDV (Home Page) - Current Debt */
    Route::get('pdv/debt', 'InvoicesController@pdv_debt');

    /* Suspects (Home Page) - Create Form Legal, Individual, From File */
    Route::get('legal/create', 'LegalsController@create');
    Route::get('legals/create_from_file', 'LegalsController@create_from_file');
    Route::get('individual/create', 'IndividualsController@create');

    /* Clients Home Page Search All */
    Route::get('search/{legal}/{sort}', 'ClientsController@search_all');
    /* Clients Home Page Search by Status */
    Route::get('clients', 'ClientsController@search_by_status');
    /* Clients Show by Client Id */
    Route::get('client/{client}', 'ClientsController@show');
    /* Client Edit Profile on Legal Status*/
    Route::get('client/edit/{client}', 'ClientsController@edit');

    /* Contract Create */
    Route::get('contract/create/{client}', 'ContractsController@create');
    /* Contract Show */
    Route::get('contract/{contract}', 'ContractsController@show');
    /* Contract Edit */
    Route::get('contract/edit/{contract}', 'ContractsController@edit');
    /* Contract Add Description */
    Route::get('contract/add_description/{contract}', 'ContractsController@add_description');
    /* Contract Custom */
    Route::get('contract/custom/{contract}', 'ContractsController@custom');
    /* Contracts (Home Page) - In Progress, Unsigned, Finished, Broken */
    Route::get('contracts/in_progress', 'ContractsController@in_progress');
    Route::get('contracts/unsigned', 'ContractsController@unsigned');
    Route::get('contracts/finished', 'ContractsController@finished');
    Route::get('contracts/broken', 'ContractsController@broken');

    /* Payments Display */
    Route::get('payments/{contract}', 'PaymentsController@index');
    /* Payment Edit*/
    Route::get('payment/edit/{contract}/{payment}', 'PaymentsController@edit');
    /* Payment Show*/
    Route::get('payment/{contract}/{payment}', 'PaymentsController@show');

    /* Participants Display */
    Route::get('participants/{contract}', 'ParticipantsController@index');
    /* Participant Create*/
    Route::get('participant/create/{contract}', 'ParticipantsController@create');
    /* Participant Edit*/
    Route::get('participant/edit/{contract}/{participant}', 'ParticipantsController@edit');

    /* Invoice or Proinvoice Create */
    Route::get('create/{invoice_type}/{contract}/{payment}', 'InvoicesController@create');
    /* Invoice or Proinvoice Edit */
    Route::get('edit/{invoice_type}/{contract}/{payment}/{type_id}', 'InvoicesController@edit');
    /* Invoice Create From Proinvoice */
    Route::get('invoice/create_from_proinvoice/{contract}/{payment}/{proinvoice}', 'InvoicesController@create_from_proinvoice');
    /* Invoices (Home Page) - From Proinvoices, Issue Today, Confirm Issued (Created), Confirm Paid, All Paid  */
    Route::get('invoices/from_proinvoices', 'InvoicesController@from_proinvoices');
    Route::get('invoices/issue_today', 'InvoicesController@issue_today');
    Route::get('invoices/confirm_issued', 'InvoicesController@confirm_issued');
    Route::get('invoices/confirm_paid', 'InvoicesController@confirm_paid');
    Route::get('invoices/all_paid', 'InvoicesController@all_paid');

    /* Proinvoices (Home Page) - Issue Today, Created, Confirm Paid */
    Route::get('proinvoices/issue_today', 'ProinvoicesController@issue_today');
    Route::get('proinvoices/confirm_issued', 'ProinvoicesController@confirm_issued');
    Route::get('proinvoices/confirm_paid', 'ProinvoicesController@confirm_paid');

    /* Presentation Create Invoice or Proinvoice */
    Route::get('presentation/create/{client}/{type}', 'PresentationsController@create');
    /* Presentation Edit Invoice or Proinvoice */
    Route::get('presentation/edit/{client_id}/{invoice_type}/{type_id}', 'PresentationsController@edit');
    /* Presentation Show Invoice or Proinvoice */
    Route::get('presentation/show/{client_id}/{invoice_type}/{type_id}', 'PresentationsController@show');
    /* Presentation Create Invoice From Proinvoice */
    Route::get('presentation/create_from_proinvoice/{client}/{proinvoice}', 'PresentationsController@invoice_from_proinvoice');

    /* PDF Contract Template */
    Route::get('pdf/contract_template', 'PdfController@contract_template');
    /* PDF Contract Default By Template */
    Route::get('pdf/contract_default/{contract}', 'PdfController@contract_default');
    /* PDF Contract Custom */
    Route::post('pdf/contract_custom/{contract}', 'PdfController@contract_custom');
    /* PDF Contract  Signed */
    Route::get('pdf/contract_signed/{contract}', 'PdfController@contract_signed');

    /* PDF Preview (Invoice/Proinvoice) */
    Route::post('pdf_preview/{type}/{client}', 'PdfController@invoice_proinvoice_preview');
    /* PDF (Invoice/Proinvoice) */
    Route::post('pdf/{type}/{id}/{client}', 'PdfController@invoice_proinvoice');
});
/* /Route Group with Middleware Auth, Allow */

/* Route Group with Middleware Auth, Admin, Allow */
Route::group(['middleware' => ['auth', 'admin', 'allow']], function () {

    /* Display All Users (No Admin Status) */
    Route::get('users', 'UserController@index');
    /* Show User (No Admin Status) */
    Route::get('user/show/{user}', 'UserController@show');
    /* Set Authorized User (No Admin Status) */
    Route::get('user/authorized/{user}', 'UserController@authorized');
    /* Set Unauthorized User (No Admin Status) */
    Route::get('user/unauthorized/{user}', 'UserController@unauthorized');
    /* Delete User (no admin status) */
    Route::get('user/delete/{user}', 'UserController@destroy');

    /* Global Training - Update */
    Route::post('global_training/update/{id}', 'GlobalTrainingController@update');

    /* Rates update - Sandler, Taxes, Disc/Devine*/
    Route::post('taxes/update/{rate}', 'RatesController@update_taxes');
    Route::post('sandler/update/{rate}', 'RatesController@update_sandler');
    Route::post('disc_devine/update/{rate}', 'RatesController@update_disc_devine');

    /* Exchange Rates Update */
    Route::post('exchange/update/{exchange}', 'ExchangeRatesController@update');

    /* Article Update */
    Route::post('article/update/{article}', 'ArticlesController@update');

    /* Template Update */
    Route::post('template/update/{template}', 'TemplatesController@update');

    /* Legal Insert */
    Route::post('legal/store', 'LegalsController@store');
    /* Legals Insert From File */
    Route::post('legal/store_file', 'LegalsController@store_file');
    /* Legal Profile Update */
    Route::post('legal/update/{legal}', 'LegalsController@update');
    /* Legal Profile Add Meeting Date */
    Route::post('legal/add_meeting_date/{legal}', 'LegalsController@add_meeting_date');
    /* Individual Insert */
    Route::post('individual/store', 'IndividualsController@store');
    /* Individual Profile Update */
    Route::post('individual/update/{individual}', 'IndividualsController@update');
    /* Individual Profile Add Meeting Date */
    Route::post('individual/add_meeting_date/{individual}', 'IndividualsController@add_meeting_date');
    /* Client Change Status (Suspects and Prospects Status) */
    Route::get('client/change_status/{client_id}/{status}', 'ClientsController@change_status');
    /* Client Delete Profile (Suspects and Prospects Status) */
    Route::get('client/delete/{client}/{client_status}', 'ClientsController@destroy');

    /* Contract Insert */
    Route::post('contract/store/{client}', 'ContractsController@store');
    /* Contract Update */
    Route::post('contract/update/{contract}', 'ContractsController@update');
    /* Contract Delete */
    Route::get('contract/delete/{contract}', 'ContractsController@destroy');
    /* Contract Sign */
    Route::get('contract/sign/{contract}', 'ContractsController@sign');
    /* Contract Break Up */
    Route::get('contract/break_up/{contract}', 'ContractsController@break_up');
    /* Contract Update Description */
    Route::post('contract/update_description/{contract}', 'ContractsController@update_description');

    /* Participant Insert */
    Route::post('participant/store/{contract}', 'ParticipantsController@store');
    /* Participant Update */
    Route::post('participant/update/{participant}', 'ParticipantsController@update');
    /* Participant Delete */
    Route::get('participant/delete/{contract}/{participant}', 'ParticipantsController@destroy');

    /* Payment Update */
    Route::post('payment/update/{payment}', 'PaymentsController@update');

    /* Invoice Insert */
    Route::post('invoice/store/{contract}/{payment}', 'InvoicesController@store');
    /* Invoice Update */
    Route::post('invoice/update/{contract}/{payment}/{invoice}', 'InvoicesController@update');
    /* Invoice Delete */
    Route::get('invoice/delete/{contract}/{payment}/{invoice}', 'InvoicesController@destroy');
    /* Invoice Issued*/
    Route::get('invoice/issued/{contract}/{payment}/{invoice}', 'InvoicesController@issued');
    /* Invoice Paid */
    Route::get('invoice/paid/{contract}/{payment}/{invoice}', 'InvoicesController@paid');

    /* Proinvoice Insert */
    Route::post('proinvoice/store/{contract}/{payment}', 'ProinvoicesController@store');
    /* Proinvoice Update */
    Route::post('proinvoice/update/{contract}/{payment}/{proinvoice}', 'ProinvoicesController@update');
    /* Proinvoice Delete */
    Route::get('proinvoice/delete/{contract}/{payment}/{proinvoice}', 'ProinvoicesController@destroy');
    /* Proinvoice Issued */
    Route::get('proinvoice/issued/{contract}/{payment}/{proinvoice}', 'ProinvoicesController@issued');
    /* Proinvoice Paid */
    Route::get('proinvoice/paid/{contract}/{payment}/{proinvoice}', 'ProinvoicesController@paid');

    /* Presentation Proinvoice Insert */
    Route::post('presentation/store/proinvoice/{client}', 'PresentationsController@store_proinvoice');
    /* Presentation Invoice Insert */
    Route::post('presentation/store/invoice/{client}', 'PresentationsController@store_invoice');
    /* Presentation Proinvoice Update */
    Route::post('presentation/update/{client}/proinvoice/{proinvoice}', 'PresentationsController@update_proinvoice');
    /* Presentation Invoice Update */
    Route::post('presentation/update/{client}/invoice/{invoice}', 'PresentationsController@update_invoice');
    /* Presentation Proinvoice Delete */
    Route::get('presentation/delete/{client}/proinvoice/{proinvoice}', 'PresentationsController@destroy_proinvoice');
    /* Presentation Invoice Delete */
    Route::get('presentation/delete/{client}/invoice/{invoice}', 'PresentationsController@destroy_invoice');
    /* Presentation Proinvoice Issued */
    Route::get('presentation/issued/{client}/proinvoice/{proinvoice}', 'PresentationsController@issued_proinvoice');
    /* Presentation Invoice Issued */
    Route::get('presentation/issued/{client}/invoice/{invoice}', 'PresentationsController@issued_invoice');
    /* Presentation Proinvoice Paid */
    Route::get('presentation/paid/{client}/proinvoice/{proinvoice}', 'PresentationsController@paid_proinvoice');
    /* Presentation Invoice Paid */
    Route::get('presentation/paid/{client}/invoice/{invoice}', 'PresentationsController@paid_invoice');

    /* PDF Contract Custom Save */
    Route::post('pdf/save_contract_custom/{contract}', 'PdfController@save_contract_custom');

    /* Disc Devine Debt-  Update  */
    Route::post('disc_devine/update_debt/{disc_devine}', 'DiscDevinesController@update');
    /* Sandler Debt -  Update  */
    Route::post('sandler/update_debt/{sandler}', 'SandlersController@update');
});
/* /Route Group with Middleware Auth, Admin, Allow */
