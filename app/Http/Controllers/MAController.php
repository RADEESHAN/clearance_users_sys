<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;


class MAController extends Controller
{


    public function showMAData()
{
    $maEntries = DB::table('clearance')
        ->leftJoin('_m_a', 'clearance.MA_ID', '=', '_m_a.MA_ID')
        ->leftJoin('hq_vc', 'clearance.HQvc_off_id', '=', 'hq_vc.HQvc_off_id')
        ->leftJoin('log_office', 'clearance.Log_off_id', '=', 'log_office.Log_off_id')
        ->leftJoin('defence_studies', 'clearance.DS_off_id', '=', 'defence_studies.DS_off_id')
        ->leftJoin('cadet_mess', 'clearance.CM_off_id', '=', 'cadet_mess.CM_off_id')
        ->leftJoin('press', 'clearance.Press_off_id', '=', 'press.Press_off_id')
        ->leftJoin('stores', 'clearance.Store_off_id', '=', 'stores.Store_off_id')
        ->leftJoin('practice_division', 'clearance.PD_off_id', '=', 'practice_division.PD_off_id')
        ->leftJoin('officer_cmd_university_service', 'clearance.OCUS_id', '=', 'officer_cmd_university_service.OCUS_id')
        ->leftJoin('hq', 'clearance.HQ_off_id', '=', 'hq.HQ_off_id')
        ->leftJoin('it', 'clearance.IT_off_id', '=', 'it.IT_off_id')
        ->leftJoin('library', 'clearance.Librarian_id', '=', 'library.Librarian_id')
        ->leftJoin('enlistment', 'clearance.Enlist_id', '=', 'enlistment.Enlist_id')
        ->leftJoin('ass_sec', 'clearance.ass_sec_off_id', '=', 'ass_sec.ass_sec_off_id')
        ->leftJoin('staff_off_it_ds', 'clearance.SODS_off_id', '=', 'staff_off_it_ds.SODS_off_id')
        ->select(
            'clearance.*',
            '_m_a.MA_off_name',
            'hq_vc.HQvc_off_name',
            'log_office.Log_off_name',
            'defence_studies.DS_off_name',
            'cadet_mess.CM_off_name',
            'press.Press_off_name',
            'stores.Store_off_name',
            'practice_division.PD_off_name',
            'officer_cmd_university_service.OCUS_Name',
            'hq.HQ_off_name',
            'it.it_OFF_name',
            'library.Librarian_Name',
            'enlistment.Enlist_Name',
            'ass_sec.ass_sec_off_name',
            'staff_off_it_ds.SODS_off_name',
            'clearance.MA_approved',
            'clearance.Student_Name',
            'clearance.Student_Reg_NO',
           
        )
        ->get();

       
    return view('ma_entries', compact('maEntries'));
}

public function contains_clearance()
{
    $maEntries = DB::table('clearance')
        ->leftJoin('_m_a', 'clearance.MA_ID', '=', '_m_a.MA_ID')
        ->select(
            'clearance.Clearance_NO',
            'clearance.Student_Name',
            'clearance.Student_Reg_NO'
        )
        ->get();

    return view('clearance-requests', compact('maEntries'));
}




    // Method to handle approval requests
   // Method to handle approval requests
   public function approveClearance(Request $request)
   {
       $request->validate([
           'id' => 'required|integer|exists:clearance,Clearance_NO',
       ]);
   
       $clearanceNo = $request->input('id');
       $ma = DB::table('clearance')->where('Clearance_NO', $clearanceNo)->first();
   
       if ($ma && $ma->MA_approved !== 'Approved') {
           DB::table('clearance')->where('Clearance_NO', $clearanceNo)->update(['MA_approved' => 'Approved']);
           return response()->json(['success' => true]);
       } else {
           return response()->json(['success' => false]);
       }
   }
   
   public function declineClearance(Request $request)
   {
       $request->validate([
           'id' => 'required|integer|exists:clearance,Clearance_NO',
       ]);
   
       $clearanceNo = $request->input('id');
       DB::table('clearance')->where('Clearance_NO', $clearanceNo)->update(['MA_approved' => 'Declined']);
   
       return response()->json(['success' => true]);
   }

   public function showClearanceRequests()
    {
        $maEntries = DB::table('clearance')
        ->leftJoin('_m_a', 'clearance.MA_ID', '=', '_m_a.MA_ID')
        ->leftJoin('hq_vc', 'clearance.HQvc_off_id', '=', 'hq_vc.HQvc_off_id')
        ->leftJoin('log_office', 'clearance.Log_off_id', '=', 'log_office.Log_off_id')
        ->leftJoin('defence_studies', 'clearance.DS_off_id', '=', 'defence_studies.DS_off_id')
        ->leftJoin('cadet_mess', 'clearance.CM_off_id', '=', 'cadet_mess.CM_off_id')
        ->leftJoin('press', 'clearance.Press_off_id', '=', 'press.Press_off_id')
        ->leftJoin('stores', 'clearance.Store_off_id', '=', 'stores.Store_off_id')
        ->leftJoin('practice_division', 'clearance.PD_off_id', '=', 'practice_division.PD_off_id')
        ->leftJoin('officer_cmd_university_service', 'clearance.OCUS_id', '=', 'officer_cmd_university_service.OCUS_id')
        ->leftJoin('hq', 'clearance.HQ_off_id', '=', 'hq.HQ_off_id')
        ->leftJoin('it', 'clearance.IT_off_id', '=', 'it.IT_off_id')
        ->leftJoin('library', 'clearance.Librarian_id', '=', 'library.Librarian_id')
        ->leftJoin('enlistment', 'clearance.Enlist_id', '=', 'enlistment.Enlist_id')
        ->leftJoin('ass_sec', 'clearance.ass_sec_off_id', '=', 'ass_sec.ass_sec_off_id')
        ->leftJoin('staff_off_it_ds', 'clearance.SODS_off_id', '=', 'staff_off_it_ds.SODS_off_id')
        ->select(
            'clearance.*',
            '_m_a.MA_off_name',
            'hq_vc.HQvc_off_name',
            'log_office.Log_off_name',
            'defence_studies.DS_off_name',
            'cadet_mess.CM_off_name',
            'press.Press_off_name',
            'stores.Store_off_name',
            'practice_division.PD_off_name',
            'officer_cmd_university_service.OCUS_Name',
            'hq.HQ_off_name',
            'it.it_OFF_name',
            'library.Librarian_Name',
            'enlistment.Enlist_Name',
            'ass_sec.ass_sec_off_name',
            'staff_off_it_ds.SODS_off_name',
            'clearance.MA_approved',
            'clearance.Student_Name',
            'clearance.Student_Reg_NO',
           
        )
        ->get();

       
    return view('Component_clearance', compact('maEntries'));
}

public function import(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Import the file
        Excel::import(new UsersImport, $request->file('file'));

        return back()->with('success', 'Users imported successfully.');
    }
}
   
