<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use voku\helper\HtmlDomParser as HelperHtmlDomParser;
use App\Company;
use App\Contact;
use App\Director;
use App\History;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Carbon;

class CompanyDataConrtoller extends Controller
{


 public function fatchData(Request $request)
 {  
    $url = $request->post('urlinput');
    
    if(!filter_var($url, FILTER_VALIDATE_URL)){
        return response()->json(['massage'=>'Not a vailid Json']);
    }
   
    $website = Http::get($url);
    $dom = HelperHtmlDomParser::str_get_html($website->body());

    $history  = new History;

    $history->url = $url;
    $history->response = $dom;
    $history->header = json_encode($website->headers());
    $history->save();

    $this->getHtlmData($dom);
     # code...
 }

    private function getHtlmData($dom)
    {

        
        
        // company data
        $companyArrya  = $this->getpareseContainBySelector($dom,'#companyinformation .table tr');

        // contact
       
        $contactArray = $this->getpareseContainBySelector($dom,'#contactdetails .table tr');

        // Listin 

        $liting  = $this->getpareseContainBySelector($dom,'#listingandannualcomplaincedetails .table tr');
        $other  = $this->getpareseContainBySelector($dom,'#otherinformation .table tr');
        $directors = $this->getpareseContainBySelectorMultiple($dom,'#directors .table tr');

        
        foreach($directors as $director){
            $directorsmany[] = new Director(
                [   
                    'din'=>$director[0],
                    'name'=>$director[1],
                    'designation'=>$director[2],
                    'dateofopinment'=>Carbon::createFromFormat('d-m-Y',$director[3])->format('Y-m-d')    
                ],
            );

        }

        $contact = new Contact;    

       $contact->email = trim(str_replace('&nbsp;','',$contactArray['EmailAddress']??null));
       $contact->address = trim(str_replace('&nbsp;','',$contactArray['RegisteredOffice']??null));
       $company = new Company;
       $company->cin = trim($companyArrya['CorporateIdentificationNumber']??null);
       $company->name = trim($companyArrya['CompanyName']??null);
       $company->status = trim($companyArrya['CompanyStatus']??null);
       $company->age = trim($companyArrya['AgeDateofIncorporation']??null);
       $company->registration_number = trim($companyArrya['RegistrationNumber']??null);
       $company->category = trim($companyArrya['CompanyCategory']??null);
       $company->class =  trim($company['ClassofCompany']??null);
       $company->Roc_code = trim($company['ROCCode']??null);
       $company->is_listed = trim($liting['Whetherlistedornot']??null);
       $company->state  = trim($other['State']??null);
       $company->pin = trim($other['PIN']??null);
       $company->district = trim($other['District']??null);
       $company->city = trim($other['City']??null);
       $company->section = trim($other['Section']??null);
       $company->divison = trim($other['Division']??null);
       $company->main_group = trim($other['MainGroup']??null);
       $company->main_class = trim($other['MainClass']??null);

       $company->last_agm = Carbon::createFromFormat('d-m-Y',trim($liting['DateofLastAGM']))->format('Y-m-d'??null);
       $company->last_balance_sheet = Carbon::createFromFormat('d-m-Y',trim($liting['DateofBalancesheet']))->format('Y-m-d'??null);
       $company->numbers_of_memmber = trim($company['NumberofMembersApplicableonlyincaseofcompanywithoutShareCapital']??null);
       $company->save();
       $company->contact()->save($contact);
       $company->directors()->saveMany($directorsmany);
      
        return response()->json(['message'=>'Data inserted Sucessfully']);
        
    }
private function getpareseContainBySelector($domobject, $selector){
    $dpa = $domobject->findMultiOrFalse($selector);
        $objectArray =[];
        
        foreach($dpa as $p){
            $key = str_replace([' ',')','('],'', $p->first_child()->text());
            $objectArray[$key] = trim($p->last_child()->text());
        }
        return $objectArray;
}
private function getpareseContainBySelectorMultiple($domobject, $selector){
    $dpa = $domobject->findMultiOrFalse($selector);
        $objectArray =[];
        $i = 1;
        foreach($dpa as $p){
            if($i==1){
                $i++;
                continue;
            }
            $key = str_replace([' ',')','('],'', $p->first_child()->text());
            $objectArray['key'.$i] = [
            $p->first_child()->text(),
            trim($p->first_child()->next_sibling()->text()),
            trim($p->first_child()->next_sibling()->next_sibling()->text()),
            trim($p->first_child()->next_sibling()->next_sibling()->next_sibling()->text()),

            ];
            $i++;
            
        }
        return $objectArray;
}



}
