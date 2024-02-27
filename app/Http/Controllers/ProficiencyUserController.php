<?php

namespace App\Http\Controllers;

use App\Models\ProficiencyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProficiencyUserController extends Controller
{
    public function download_client_report($record){

        $data = ProficiencyUser::select('client_report')->where('id',$record)->first(); 
        $content = Storage::disk('public')->path($data->client_report);       
        return response()->download($content);
    }
    public function download_client_certificate($record){

        $data = ProficiencyUser::select('client_sertificate')->where('id',$record)->first(); 
        $content = Storage::disk('public')->path($data->client_sertificate);       
        return response()->download($content);
    }
}
