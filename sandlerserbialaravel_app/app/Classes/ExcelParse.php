<?php

namespace App\Classes;

use Excel;

class ExcelParse
{
    /**
     * Returns True If The File Is Filled In
     *
     * @param  string stored file path (Excel)
     * @return  bool
     */
    public function fileIsFilled($file_path)
    {
        if (Excel::load($file_path)->all()->first()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns Array of Excel File Headers
     *
     * @param  string $file_path
     * @return  array
     */
    public function getHeaders($file_path)
    {
        return Excel::load($file_path)->all()->first()->keys()->toArray();
        /* not working on server*/
        //return ((((Excel::load($file_path))->all())->first())->keys())->toArray();
    }

    /**
     * Returns List of False Excel Header Names
     *
     * @param  array $excel_headers
     * @return  string
     */
    public function checkHeaders($excel_headers)
    {
        if ($excel_headers) {
            list($excel_names, $column_names) = array_divide($this->getColumnNamesArray());
            $false_header = array();
            foreach ($excel_headers as $header) {
                if (!in_array($header, $excel_names)) {
                    $false_header[] .= str_replace("_", " ", ucfirst($header));
                }
            }
            return $false_header = implode(", ", $false_header);
        }
    }

    /**
     * Returns Table Column Name
     *
     * @param  string $excel_header
     * @return  string
     */
    public function changeColumnName($excel_header)
    {
        $table_column_names = $this->getColumnNamesArray();
        foreach ($table_column_names as $excel_header_name => $table_column_name) {
            if ($excel_header_name == $excel_header) {
                return $table_column_name;
            }
        }
    }

    /**
     * Returns Array Of Table Column Names
     *
     * @return  array
     */
    public function getColumnNamesArray()
    {
        $table_column_names = array(
            'naziv' => 'long_name',
            'kraci_naziv' => 'short_name',
            'direktor' => 'ceo',
            'telefon' => 'phone',
            'email' => 'email',
            'lice_za_razgovor' => 'contact_person',
            'telefon_lica_za_razgovor' => 'contact_person_phone',
            'maticni_broj_firme' => 'identification',
            'pib' => 'pib',
            'delatnost' => 'activity',
            'adresa' => 'address',
            'opstina' => 'county',
            'postanski_broj' => 'postal',
            'grad' => 'city',
            'website' => 'website',
            'velicina' => 'company_size_id',
        );
        return $table_column_names;
    }

    /**
     * Returns Array Of Excel File Data For Storing
     *
     * @param  string $file_path
     * @return  array
     */
    public function createExcelArrayWithTableNames($file_path)
    {
        $reader_array = Excel::load($file_path)->get();
        /* not working on server*/
        //$reader_array = (Excel::load($file_path))->get();
        $suspects_array = array();
        foreach ($reader_array as $array) {
            $suspect_values = array();
            foreach ($array as $key => $value) {
                $suspect_values[$this->changeColumnName($key)] = $value;
            }
            $suspects_array[] = $suspect_values;
        }
        return $suspects_array;
    }

    /**
     * Returns Array Of Excel Data For Storing With Changed Company Size Value
     *
     * @param  array $excel_array
     * @return array
     */
    public function replaceCompanySizeValue($excel_array)
    {
        $suspects_array = array();
        foreach ($excel_array as $array) {
            $suspect_values = array();
            foreach ($array as $key => $value) {
                if ($key == 'company_size_id') {
                    $value = $this->returnCompanySizeID($value);
                }
                $suspect_values[$key] = $value;
            }
            $suspects_array[] = $suspect_values;
        }
        return $suspects_array;
    }

    /**
     * Returns Company Size Id
     *
     * @param  string $company_size_name
     * @return  int
     */
    public function returnCompanySizeID($company_size_name)
    {
        switch ($company_size_name) {
            case 'Nepoznato':
                return 1;
            break;
            case 'Mikro':
                return 2;
            break;
            case 'Malo':
                return 3;
            break;
            case 'Srednje':
                return 4;
            break;
            case 'Veliko':
                return 5;
            break;
            default:
                return 1;
            break;
        }
    }

    /**
     * Returns Excel File Storage Path (Without Filename Returns Directory Path)
     *
     * @param  bool $full_path
     * @param  string $filename
     * @return  string
     */
    public function get_excel_file_path($full_path, $filename)
    {
        $path = config('constants.excel_storage_path') . $filename;
        return $full_path ? storage_path($path) : $path;
    }
}
