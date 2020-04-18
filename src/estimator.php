<?php

function covid19ImpactEstimator($data)
{
   
  $impact = estimateImpact($data);
  $severeImpact = estimateSevereImpact($data);
  return extimatorResponse($data, $impact, $severeImpact);
}


 function estimateImpact($data)
{
   $currentlyInfected= floor($data->reportedCases *10);
   $infectionsByRequestedTime = floor($currentlyInfected * (pow(2, floor($data->timeToElapse / 3))));
   $severeCasesByRequestedTime = floor($infectionsByRequestedTime * 0.15);
   $hospitalBedsByRequestedTime = floor($severeCasesByRequestedTime - ($data->totalHospitalBeds * 0.35));
   $casesForICUByRequestedTime = floor($infectionsByRequestedTime * 0.05);
   $casesForVentilatorsByRequestedTime = floor($infectionsByRequestedTime * 0.02);
   $dollarsInFlight = floor(($infectionsByRequestedTime * $data->region->avgDailyIncomePopulation * $data->region->avgDailyIncomeInUSD) / 30);
   return $impact = array(
              "currentlyInfected"=>$currentlyInfected ,
              "infectionsByRequestedTime"=> $infectionsByRequestedTime, 
              "severeCasesByRequestedTime"=>$severeCasesByRequestedTime,
              "hospitalBedsByRequestedTime"=>$hospitalBedsByRequestedTime,
              "casesForICUByRequestedTime"=>$casesForICUByRequestedTime,
              "casesForVentilatorsByRequestedTime"=> $casesForVentilatorsByRequestedTime,
              "dollarsInFlight"=> $dollarsInFlight
            );
             
}

 function estimateSevereImpact($data)
{
  $currentlyInfected= floor($data->reportedCases *50);
  $infectionsByRequestedTime = floor($currentlyInfected * (pow(2, floor($data->timeToElapse / 3))));
  $severeCasesByRequestedTime = floor($infectionsByRequestedTime * 0.15);
  $hospitalBedsByRequestedTime = floor($severeCasesByRequestedTime - ($data->totalHospitalBeds * 0.35));
  $casesForICUByRequestedTime = floor($infectionsByRequestedTime * 0.05);
  $casesForVentilatorsByRequestedTime = floor($infectionsByRequestedTime * 0.02);
  $dollarsInFlight = floor(($infectionsByRequestedTime * $data->region->avgDailyIncomePopulation * $data->region->avgDailyIncomeInUSD) / 30);
   
 return  $severeImpact = array(
     "currentlyInfected"=>$currentlyInfected , 
     "infectionsByRequestedTime"=> $infectionsByRequestedTime,
     "severeCasesByRequestedTime"=>$severeCasesByRequestedTime,
     "hospitalBedsByRequestedTime"=>$hospitalBedsByRequestedTime,
     "casesForICUByRequestedTime"=>$casesForICUByRequestedTime,
     "casesForVentilatorsByRequestedTime"=> $casesForVentilatorsByRequestedTime,
     "dollarsInFlight"=>$dollarsInFlight
    
    );
}

 function extimatorResponse($data, $impact, $severeImpact)
{
  return json_encode(array("data"=> $data, "impact"=>$impact, "severeImpact"=>$severeImpact));
}
