<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted' => 'Polje :attribute mora biti prihvaćeno.',
    'active_url' => 'Polje :attribute nije validan URL.',
    'after' => 'Polje :attribute mora biti datum posle polja :date.',
    'after_today' => 'Polje :attribute mora biti datum posle današnjeg datuma.', //custom
    'after_and_today' => 'Polje :attribute mora biti današnji datum ili posle današnjeg datuma.', //custom
    'after_or_equal' => 'Polje :attribute mora biti datum koji ne sme biti pre polja :date.',
    'alpha' => 'Polje :attribute može sadržati samo slova.',
    'alpha_dash' => 'Polje :attribute može sadržati samo slova, brojeve i donje crte.',
    'alpha_num' => 'Polje :attribute može sadržati samo slova i brojeve.',
    'alpha_spaces' => 'Polje :attribute može sadržati samo slova, razmake, tačke, srednje crte i apostrofe.', //custom
    'array' => 'Polje :attribute mora sadržati nekih niz stavki.',
    'before' => 'Polje :attribute mora biti datum pre polja :date.',
    'before_today' => 'Polje :attribute mora biti datum pre današnjeg datuma.', //custom
    'before_and_today' => 'Polje :attribute mora biti današnji datum ili pre današnjeg datuma.', //custom
    'before_or_equal' => 'Polje :attribute mora biti datum koji ne sme biti posle polja :date.',
    'between' => [
        'numeric' => 'Polje :attribute mora biti između :min - :max.',
        'file' => 'Fajl :attribute mora biti između :min - :max kilobajta.',
        'string' => 'Polje :attribute mora biti između :min - :max karaktera.',
        'array' => 'Polje :attribute mora biti između :min - :max stavki.',
    ],
    'boolean' => 'Polje :attribute mora biti tačno ili netačno.',
    'confirmed' => 'Potvrda polja :attribute se ne poklapa.',
    'date' => 'Polje :attribute nije važeći datum.',
    'date_format' => 'Polje :attribute ne odgovora prema formatu :format.',
    'different' => 'Polja :attribute i :other moraju biti različita.',
    'digits' => 'Polje :attribute mora sadržati :digits cifri.',
    'digits_between' => 'Polje :attribute mora biti izemđu :min i :max cifri.',
    'dimensions' => 'Polje :attribute ima pogrešne dimenzije slike.',
    'distinct' => 'Polje :attribute ima dupliranu vrednost.',
    'email' => 'Format polja :attribute nije validan.',
    'exists' => 'Odabrano polje :attribute nije validno.',
    'file' => 'Polje :attribute mora biti fajl.',
    'filled' => 'Polje :attribute mora biti popunjeno.',
    'image' => 'Polje :attribute mora biti slika.',
    'in' => 'Odabrano polje :attribute nije validno.',
    'in_array' => 'Polje :attribute ne postoji u :other.',
    'integer' => 'Polje :attribute mora biti broj.',
    'ip' => 'Polje :attribute mora biti validna IP adresa.',
    'ipv4' => 'Polje :attribute mora imati ispravnu IPv4 adresu.',
    'ipv6' => 'Polje :attribute mora imati ispravnu IPv6 adresu.',
    'json' => 'Polje :attribute mora biti ispravan JSON string.',
    'max' => [
        'numeric' => 'Polje :attribute mora biti manje od :max.',
        'file' => 'Polje :attribute mora biti manje od :max kilobajta.',
        'string' => 'Polje :attribute mora sadržati manje od :max karaktera.',
        'array' => 'Polje :attribute ne sme da ima više od :max stavki.',
    ],
    'mimes' => 'Polje :attribute mora biti fajl tipa: :values.',
    'mimetypes' => 'Polje :attribute mora biti fajl tipa: :values.',
    'min' => [
        'numeric' => 'Polje :attribute mora biti najmanje :min.',
        'file' => 'Fajl :attribute mora biti najmanje :min kilobajta.',
        'string' => 'Polje :attribute mora sadržati najmanje :min karaktera.',
        'array' => 'Polje :attribute mora sadrzati najmanje :min stavku.',
    ],
    'not_in' => 'Odabrani element polja :attribute nije validan.',
    'numeric' => 'Polje :attribute mora biti broj.',
    'numeric_spaces' => 'Polje :attribute mora biti broj ili razmak.', //custom
    'present' => 'Polje :attribute mora postojati.',
    'regex' => 'Format polja :attribute nije validan.',
    'required' => 'Polje :attribute je obavezno.',
    'required_if' => 'Polje :attribute je potrebno kada polje :other sadrži :value.',
    'required_unless' => 'Polje :attribute je obavezno osim ako se :other nalazi u :values.',
    'required_with' => 'Polje :attribute je potrebno kada polje :values je prisutan.',
    'required_with_all' => 'Polje :attribute je obavezno kada je :values prikazano.',
    'required_without' => 'Polje :attribute je potrebno kada polje :values nije prisutan.',
    'required_without_all' => 'Polje :attribute je potrebno kada nijedan od sledeći polja :values nisu prisutni.',
    'same' => 'Polja :attribute i :other se moraju poklapati.',
    'size' => [
        'numeric' => 'Polje :attribute mora biti :size.',
        'file' => 'Fajl :attribute mora biti :size kilobajta.',
        'string' => 'Polje :attribute mora biti :size karaktera.',
        'array' => 'Polje :attribute mora sadržati :size stavki.',
    ],
    'string' => 'Polje :attribute mora sadržati slova.',
    'timezone' => 'Polje :attribute mora biti ispravna vremenska zona.',
    'unique' => 'Polje :attribute već postoji.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'Format polja :attribute nije validan.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'method' => [
            'valid_method' => 'Neispravan URL!',
        ],
        'advance' => [
            'less_equal_then' => 'Polje Avans mora biti jednako ili manje od polja Vrednost Ugovora.',
            'advance_zero' => 'Polje Avans mora imati vrednost polja Vrednost Ugovora (EUR) ako polje Broj rata ima vrednost 0',
        ],
        'payments' => [
            'payments_zero' => 'Polje Broj rata mora biti veće od 0 ako polje Avans (EUR) ima vrednost 0',
        ],
        'single_submit' => [
            'size' => 'Onemogućeno je korišćenje dvoklika!',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'date' => 'Datum',
        'name' => 'Ime',
        'email' => 'Email adresa',
        'password' => 'Lozinka',
        'password_confirmation' => 'Potvrda lozinke',
        'phone' => 'Telefon',
        'pdv' => 'PDV (procenat)',
        'ppo' => 'Porez po odbitku (procenat)',
        'pdv_paying_day' => 'Dan plaćanja PDV-a u mesecu',
        'sandler' => 'Sandler (procenat)',
        'sandler_paying_day' => 'Dan plaćanja u mesecu',
        'disc' => 'DISC iznos u dolarima',
        'devine' => 'Devine iznos u dolarima',
        'dd_paying_day' => 'Dan plaćanja u mesecu',
        'exchange_value' => 'Srednji kurs (RSD)',
        'representative' => 'Ovlašćeni zastupnik',
        'website' => 'Website',
        'address' => 'Adresa',
        'county' => 'Opština',
        'postal' => 'Poštanski broj',
        'city' => 'Grad',
        'bank' => 'Banka',
        'account' => 'Račun',
        'pib' => 'PIB',
        'identification' => 'Matični broj firme',
        'long_name' => 'Naziv',
        'short_name' => 'Kraći naziv',
        'ceo' => 'Direktor',
        'contact_person' => 'Lice za razgovor',
        'contact_person_phone' => 'Telefon lica za razgovor',
        'activity' => 'Delatnost',
        'comment' => 'Komentar',
        'company_size_id' => 'Veličina',
        'first_name' => 'Ime',
        'last_name' => 'Prezime',
        'jmbg' => 'JMBG',
        'id_card' => 'Broj lične karte',
        'works_at' => 'Zaposlen u',
        'format_meeting_date' => 'Datum sastanka',
        'meeting_date' => 'Datum sastanka-skriveno',
        'excel_file' => 'Excel',
        'from' => 'Datum od',
        'to' => 'Datum do',
        'checkFrom' => 'Datum od',
        'checkTo' => 'Datum do',
        'contract_number' => 'Broj Ugovora',
        'description' => 'Opis Ugovora',
        'format_contract_date' => 'Datum Ugovora',
        'contract_date' => 'Datum Ugovora-skriveno',
        'participants' => 'Broj učesnika',
        'event_place' => 'Mesto održavanja',
        'classes_number' => 'Broj časova',
        'format_start_date' => 'Datum početka',
        'start_date' => 'Datum početka-skriveno',
        'format_end_date' => 'Datum završetka',
        'end_date' => 'Datum završetka-skriveno',
        'work_dynamics' => 'Dinamika rada',
        'event_time' => 'Vreme održavanja',
        'value' => 'Vrednost Ugovora (EUR)',
        'value_letters' => 'Vrednost Ugovora slovima',
        'advance' => 'Avans (EUR)',
        'payments' => 'Broj rata',
        'position' => 'Pozicija',
        'dd_option' => 'DISC/Devine opcija',
        'value_euro' => 'Vrednost',
        'format_pay_date' => 'Datum plaćanja',
        'pay_date' => 'Datum plaćanja-skriveno',
        'pay_date_desc' => 'Opis',
        'contract' => 'Ugovor',
        'logo_bg' => 'Prikaži logo u pozadini',
        'logo_hd' => 'Prikaži logo u zaglavlju',
        'line_hd' => 'Prikaži liniju gornjeg zaglavlja',
        'line_ft' => 'Prikaži liniju donjeg zaglavlja',
        'paginate' => 'Prikaži obeležavanje strana',
        'margin_top' => 'Margina gore',
        'margin_bottom' => 'Margina dole',
        'margin_left' => 'Margina levo',
        'margin_right' => 'Margina desno',
        'html' => 'za unos teksta Ugovora',
        'exchange_euro' => 'Srednji kurs evra',
        'value_din' => 'Vrednost u dinarima',
        'pdv_din' => 'PDV u dinarima',
        'value_din_tax' => 'Vrednost u dinarima sa pdv-om',
        'format_issue_date' => 'Datum izdavanja',
        'issue_date' => 'Datum izdavanja-skriveno',
        'format_traffic_date' => 'Datum prometa',
        'traffic_date' => 'Datum prometa-skriveno',
        'note' => 'Napomena',
        'format_paid_date' => 'Datum plaćanja',
        'paid_date' => 'Datum plaćanja-skriveno',
        'middle_ex_dollar' => 'Srednji kurs dolara',
        'dd_din' => 'DISC/Devine (RSD)',
        'ppo_din' => 'Porez po odbitku (RSD)',
        'dd_dollar' => 'DISC/Devine (USD)-skriveno',
        'sandler_din' => 'Sandler (RSD)',
        'sandler_dollar' => 'Sandler (USD)',
        'invoice_din' => 'Vrednost fakture-skriveno',
        'sandler_percent' => 'Sandler procenat-skriveno',
        'title' => 'Naziv',
        'article' => 'Sadržaj',

    ],

];
