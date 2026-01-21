<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Employee\MasterEmployee;

class MasterEmployeeImportController extends Controller
{
    //
    public function import()
    {
        return view('admin.imports.master-employee');
    }

    public function clear()
    {
        // Authorize action if required
        if (!Gate::allows('master_employee_import')) {
            abort(401, "You are not Authorized to Access this Page!");
        }

        // Truncate table
        MasterEmployee::truncate();

        return redirect()->back()->with('success', 'All Master Employee records have been cleared successfully.');
    }

    public function process(Request $request)
    {
        set_time_limit(3000);

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv,txt',
        ]);

        $file = $request->file('excel_file');

        // Path for storing failed rows CSV
        $failedCsvPath = storage_path('app/failed_master_employee_imports.csv');

        // Delete old failed file if exists
        if (file_exists($failedCsvPath)) {
            unlink($failedCsvPath);
        }

        // This will hold failed rows
        $failedRows = [];

        // Read and process each row
        SimpleExcelReader::create($file->getRealPath(), 'csv')
            ->getRows()
            ->each(function (array $row) use (&$failedRows) {
                try {
                    MasterEmployee::create([
                        'employee_number' => (int) trim($row['New Emp No']),
                        'old_emp_no' => $row['Old Emp No'] ?? null,
                        'new_emp_no' => $row['New Emp No'] ?? null,
                        'name' => $row['Name'] ?? null,
                        'designation' => $row['Designation'] ?? null,
                        'designation_level' => $row['Designation Level'] ?? null,
                        'position' => $row['Position'] ?? null,
                        'core_department' => $row['Core Department'] ?? null,
                        'core_department_level' => $row['Core Department Level'] ?? null,
                        'department' => $row['Department'] ?? null,
                        'organization' => $row['Organization'] ?? null,
                        'assignment_type' => $row['Assignment Type'] ?? null,
                        'employee_type' => $row['Employee Type'] ?? null,
                        'supervisor_emp_no' => $row['Supervisor Employee No'] ?? null,
                        'supervisor_name' => $row['Supervisor Name'] ?? null,
                        'class' => $row['Class'] ?? null,
                        'category' => $row['Category'] ?? null,
                        'sh_nsh' => $row['SH/NSH'] ?? null,
                        'union' => MasterEmployee::parseBool($row['Union'] ?? false),
                        'dob' => MasterEmployee::parseDate($row['Date of Birth'] ?? null),
                        'gender' => $row['Gender'] ?? null,
                        'blood_group' => $row['Blood Group'] ?? null,
                        'disabled' => MasterEmployee::parseBool($row['Disabled'] ?? false),
                        'pan_number' => $row['PAN Number'] ?? null,
                        'cpf_number' => $row['CPF Number'] ?? null,
                        'cpf_joining_date' => MasterEmployee::parseDate($row['CPF Joining Date'] ?? null),
                        'eps_number' => $row['EPS Number'] ?? null,
                        'eps_joining_date' => MasterEmployee::parseDate($row['EPS Joining Date'] ?? null),
                        'date_of_joining' => MasterEmployee::parseDate($row['Date of Joining'] ?? null),
                        'bank' => $row['Bank'] ?? null,
                        'branch' => $row['Branch'] ?? null,
                        'bank_account_no' => $row['Bank Account No'] ?? null,
                        'grade' => $row['Grade'] ?? null,
                        'grade_step' => $row['Grade Step'] ?? null,
                        'grade_start_date' => MasterEmployee::parseDate($row['Grade Start Date'] ?? null),
                        'basic' => MasterEmployee::parseFloat($row['Basic'] ?? null),
                        'ot_code' => $row['OT Code'] ?? null,
                        'svrcdbs_flag' => MasterEmployee::parseBool($row['SVRCDBS Flag'] ?? null),
                        'next_increment' => MasterEmployee::parseDate($row['Next Increment'] ?? null),
                        'username' => $row['User Name'] ?? null,
                        'doj_current_cadre' => MasterEmployee::parseDate($row['Date of Joining of current Cader'] ?? null),
                        'last_higher_grade' => MasterEmployee::parseDate($row['Date of Last Higher Grade'] ?? null),
                        'doj_current_place' => MasterEmployee::parseDate($row['Date of Joining in Current place'] ?? null),
                        'caste' => $row['Caste'] ?? null,
                        'qualification' => $row['Qualifications'] ?? null,
                        'restricted_ph' => MasterEmployee::parseBool($row['Restricted PH Applicable'] ?? null),
                        'second_fourth_sat_not_app' => MasterEmployee::parseBool($row['2nd and 4th Sat Not App'] ?? null),
                        'age' => $row['Age'] ?? null,
                        'image_present' => MasterEmployee::parseBool($row['Image Present (Y/N)'] ?? null),
                        'ifsc_code' => $row['IFSC Code'] ?? null,
                        'aadhaar_number' => $row['Aadhar Number'] ?? null,
                        'pf_member_id' => $row['PF Member ID'] ?? null,
                        'lic_id' => $row['LIC ID'] ?? null,
                        'pran' => $row['PRAN'] ?? null,
                        'antecedent_verified' => MasterEmployee::parseBool($row['ANTECEDENT VARIFIED'] ?? null),
                        'antecedent_remark' => $row['ANTECEDENT REMARK'] ?? null,
                        'medical_exam' => MasterEmployee::parseBool($row['MEDICAL EXAMINATION'] ?? null),
                        'medical_remark' => $row['MEDICAL REMARK'] ?? null,
                        'parent_company' => $row['PARENT COMPANY'] ?? null,
                        'deputed_from' => $row['DEPUTED FROM'] ?? null,
                        'last_location' => $row['LAST LOCATION'] ?? null,
                        'deputation_remark' => $row['DEPUTATION REMARK'] ?? null,
                        'old_basic_grade' => $row['OLD BASIC GRADE'] ?? null,
                        'old_basic' => MasterEmployee::parseFloat($row['OLD BASIC'] ?? null),
                        'old_basic_from' => MasterEmployee::parseDate($row['OLD BASIC FROM'] ?? null),
                        'old_basic_to' => MasterEmployee::parseDate($row['OLD BASIC TO'] ?? null),
                        'pay_revision_flag' => MasterEmployee::parseBool($row['Pay Revision Flag'] ?? null),
                        'class3_doj_ho_cir' => MasterEmployee::parseDate($row['Class 3 Doj in HO/CIR'] ?? null),
                        'class4_doj_ho_cir_div' => MasterEmployee::parseDate($row['Class 4 Doj in HO/CIR/DIV'] ?? null),
                        'years_on_current_cadre' => MasterEmployee::parseInt($row['Years completed on current Cadre'] ?? null),
                        'years_on_current_place' => MasterEmployee::parseInt($row['Years completed on current Place'] ?? null),
                        'cleared_regional_lang' => MasterEmployee::parseBool($row['Cleared Regional Language'] ?? null),
                        'cleared_hindi_exam' => MasterEmployee::parseBool($row['Cleared Hindi Exam'] ?? null),
                        'cleared_departmental_exam' => MasterEmployee::parseBool($row['Cleared Departmental Exam'] ?? null),
                        'email' => $row['Email'] ?? null,
                        'phone_no' => $row['PhoneNo'] ?? null,
                    ]);
                } catch (\Exception $e) {
                    // Add error message into the row for debugging
                    $row['Error Message'] = $e->getMessage();
                    $failedRows[] = $row;
                }
            });

        // Save failed rows to CSV if there are any
        if (!empty($failedRows)) {
            $handle = fopen($failedCsvPath, 'w');
            fputcsv($handle, array_keys($failedRows[0])); // headers
            foreach ($failedRows as $failedRow) {
                fputcsv($handle, $failedRow);
            }
            fclose($handle);
        }

        return redirect()->back()->with('success', 'Import completed! ' . (count($failedRows) ? 'Some rows failed. See failed_master_employee_imports.csv' : 'All rows imported successfully.'));
    }

}
