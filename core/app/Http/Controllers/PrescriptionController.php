<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Prescription;
use App\PrescriptionImage;
use App\Appointment;
class PrescriptionController extends Controller
{
    public function patientPrescriptionReportUpload(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $done=$image->move('assets/appointment/prescription', $imageName);
        return response()->json(['successss' => $imageName]);

        // try{

        //     $location = imagePath()['appointment']['path'];
        //     $size = imagePath()['appointment']['size'];
        //     $image->move($path, $filename);
        //   $staff_image = uploadImage($request->file('file'), $location , $size);

        // }catch(\Exception $exp) {
        //     return 'error Could not upload the image.';
        // }
    }
    public function prescriptionStore(Request $request)
    {

        // $this->validate($request, [
        //     'disease' => 'required',
        //     'note' => 'required',
        // ]);
        $prescription = new Prescription();
        $prescription->appointment_id = $request->appointment_id;
        $prescription->disease =  $request->disease;
        $prescription->patient_id =  $request->patient_id;
        $prescription->doctor_id = $request->doctor_id;
        $prescription->note =  $request->note;
        $prescription->date = Carbon::now();
        $prescription->save();

        $selectedPrescriptionDocument = $request->input('selectedDocument');//array of selected document

        if ($selectedPrescriptionDocument != []) {
            for ($i = 0; $i < sizeof($selectedPrescriptionDocument); $i++) {// for loop for all selected test
                $prescription_document = new PrescriptionImage();
                $prescription_document->prescription_id = $prescription->id;
                $prescription_document->attachment_name  = $selectedPrescriptionDocument[$i];
                $prescription_document->date = Carbon::now();
                $prescription_document->save();

                }
        }
        $appointments = Appointment::where('id', '=', $request->appointment_id)->update([
            'is_complete' => 1]);

            $patient = 1;
            // notify($appointment, 'APPOINTMENT_CONFIRM', [
            //     'booking_date' => $appointment->booking_date,
            //     'time_serial' => $appointment->time_serial,
            //     'doctor_name' => $doctor->name,
            //     'doctor_fees' => ''.$doctor->fees.' '.$general->cur_text.'',
            // ],$patient);

            $notify[] = ['success', 'Your prescription has been taken.'];
            return back()->withNotify($notify);



    }
}
