<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use voku\helper\HtmlDomParser as HelperHtmlDomParser;
use App\Company;
use App\Contact;
use App\Director;
use Illuminate\Support\Carbon;

class CompanyDataConrtoller extends Controller
{
    //
    /*
        "State" => "West Bengal"
  "District" => "Kolkata"
  "City" => "Kolkata"
  "PIN" => "700069"
  "Section" => "Real estate activitiesSee other companies with same Real estate activities Section"
  "Division" => "Veterinary activitiesSee other companies with same Veterinary activities Division"
  "MainGroup" => "NoneSee other companies with same None Group"
  "MainClass" => "None"
]
    */
    public function getHtlmData()
    {

        $website = Http::get('http://www.mycorporateinfo.com/business/kamdhenu-engineering-industries-ltd');

        
        $dom = HelperHtmlDomParser::str_get_html($website->body());
        
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

        $contact->email = trim(str_replace('&nbsp;','',$contactArray['EmailAddress']));
        $contact->address = trim(str_replace('&nbsp;','',$contactArray['RegisteredOffice']));
       $company = new Company;
       $company->cin = trim($companyArrya['CorporateIdentificationNumber']);
       $company->name = trim($companyArrya['CompanyName']);
       $company->status = trim($companyArrya['CompanyStatus']);
       $company->age = trim($companyArrya['AgeDateofIncorporation']);
       $company->registration_number = trim($companyArrya['RegistrationNumber']);
       $company->category = trim($companyArrya['CompanyCategory']);
       $company->class =  trim($company['ClassofCompany']);
       $company->Roc_code = trim($company['ROCCode']);
       $company->is_listed = trim($liting['Whetherlistedornot']);
       $company->state  = trim($other['State']);
       $company->pin = trim($other['PIN']);
       $company->district = trim($other['District']);
       $company->city = trim($other['City']);
       $company->section = trim($other['Section']);
       $company->divison = trim($other['Division']);
       $company->main_group = trim($other['MainGroup']);
       $company->main_class = trim($other['MainClass']);

       $company->last_agm = Carbon::createFromFormat('d-m-Y',trim($liting['DateofLastAGM']))->format('Y-m-d');
       $company->last_balance_sheet = Carbon::createFromFormat('d-m-Y',trim($liting['DateofBalancesheet']))->format('Y-m-d');
       $company->numbers_of_memmber = trim($company['NumberofMembersApplicableonlyincaseofcompanywithoutShareCapital']);
       $company->save();
       $company->contact()->save($contact);
       $company->directors()->saveMany($directorsmany);
      
       echo "done!";
        
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
