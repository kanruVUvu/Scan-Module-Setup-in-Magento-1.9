<?php

class Bms_Scan_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getHospitalsList(){
		$hospitals = array (""=>"----Please Select-----",
							"Columbia Asia Hospital"=>"Columbia Asia Hospital",
							"Medihope Super Specialty Hospital"=>"Medihope Super Specialty Hospital",
							"GM Hospital"=>"GM Hospital",
							"Phoenix Hospital"=>"Phoenix Hospital",
							"Manipal Hospital"=>"Manipal Hospital",
							"BGS Global Hospital"=>"BGS Global Hospital",
							"People Tree Hospitals"=>"People Tree Hospitals",
							"All Care Dental Centre"=>"All Care Dental Centre",
							"Prasad Eye Hospital"=>"Prasad Eye Hospital",
							"Dr. Agarwal's Eye Hospital"=>"Dr. Agarwal's Eye Hospital",
							"Apollo Spectra Hospitals"=>"Apollo Spectra Hospitals",
							"Meenakshi ENT Speciality Hospital"=>"Meenakshi ENT Speciality Hospital",
							"The Bangalore Hospital"=>"The Bangalore Hospital",
							"Hairline Clinics"=>"Hairline Clinics",
							"Suguna Hospital"=>"Suguna Hospital",
							"Hosmat Hospital"=>"Hosmat Hospital",
							"Femiint Health"=>"Femiint Health",
							"Sharavathi Hospital"=>"Sharavathi Hospital",
							"Yashomati Hospital"=>"Yashomati Hospital",
							"Prosmiles Dental"=>"Prosmiles Dental",
							"Smiles Dental Care"=>"Smiles Dental Care",
							"Smiles Dental Specialities"=>"Smiles Dental Specialities",
							"Navashakthi Nethralaya"=>"Navashakthi Nethralaya",
							"Manjunatha Nethralaya"=>"Manjunatha Nethralaya",
							"Sparsh Hospital"=>"Sparsh Hospital",
							"Ramakrishna Hospital"=>"Ramakrishna Hospital",
							"Karthik Netralaya Eye Hospital"=>"Karthik Netralaya Eye Hospital",
							"Sparha Advanced Aesthetic Studio"=>"Sparha Advanced Aesthetic Studio",
							"Apex Hospital"=>"Apex Hospital",
							"Lifeline Hospital"=>"Lifeline Hospital",
							"Zenith Multispeciality Hospital"=>"Zenith Multispeciality Hospital",
							"Saifee Hospital"=>"Saifee Hospital",
							"Terna Speciality Hospital and Research Center" => "Terna Speciality Hospital and Research Center",
							"Sailee Hospital and Diagnostic Center" => "Sailee Hospital and Diagnostic Center"




							);
							
		return $hospitals;
	}
}