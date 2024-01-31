<?php
$dbHost="localhost";
$dbUsername="root";
$dbPassword="mysql";
$dbName="mifostenant-waumini";

//die("sdfsfsf");
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName) or  die("Error!!");
$table="m_loan";

//tablempesarepayments
$query=mysqli_query($db,"select * from ".$table." WHERE loan_status_id=200  LIMIT 1000") or die(mysqli_error($db));

while($rows= mysqli_fetch_array($query)){
    //approveLoan($rows["id"], $rows["approved_principal"],"31 December 2018","01 January 2019","approved");
	$disbursementdate="01 January 2019";
	 DisburseLoan($rows["id"], $rows["id"],$rows["approved_principal"],$disbursementdate,"Disbursed on ".$disbursementdate);
}

function approveLoan($loanid,$principal,$approvaldate,$disbursementdate,$note){
 // die('{"clientId":"'.$clientid.'","productId":'.$product.',"disbursementData":[],"fundId":1,"principal":'.$principal.',"loanTermFrequency":'.$freq.',"loanTermFrequencyType":0,"numberOfRepayments":'.$freq.',"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"inArrearsTolerance":365,"graceOnArrearsAgeing":365,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"'.$disbursementdate.'","submittedOnDate":"'.$submitteddate.'"}');// Date Format 27 October 2018
    $serverurl="https://localhost:8000/";
	//die($serverurl."fineract-provider/api/v1/loans/".$loanid."?command=approve&tenantIdentifier=default");
    $freq=12;
    $curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt_array($curl, array(
  CURLOPT_PORT => "8000",
  CURLOPT_URL => $serverurl."fineract-provider/api/v1/loans/".$loanid."?command=approve&tenantIdentifier=default",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  //CURLOPT_POSTFIELDS => '{"clientId":"'.$clientid.'","productId":'.$product.',"disbursementData":[],"principal":'.$principal.',"loanTermFrequency":'.$freq.',"loanTermFrequencyType":2,"numberOfRepayments":'.$freq.',"repaymentEvery":1,"repaymentFrequencyType":2,"interestRatePerPeriod":2.25,"amortizationType":1,"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"inArrearsTolerance":1,"graceOnArrearsAgeing":1,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"'.$disbursementdate.'","submittedOnDate":"'.$submitteddate.'"}', //
  CURLOPT_POSTFIELDS =>'{"approvedOnDate":"'.$approvaldate.'","approvedLoanAmount":'.$principal.',"note":"'.$note.'","expectedDisbursementDate":"'.$disbursementdate.'","disbursementData":[],"locale":"en","dateFormat":"dd MMMM yyyy"}',
    
    CURLOPT_HTTPHEADER => array(
    "authorization: Basic bWlmb3M6cGFzc3dvcmQ=",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 82f71847-a076-7a85-a4d7-ed6745be0190"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

//die(print_r($curl));

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
    
}


function addShares($clientid,$approvaldate,$externalid,$submitteddate,$applicationdate){
 // die('{"clientId":"'.$clientid.'","productId":'.$product.',"disbursementData":[],"fundId":1,"principal":'.$principal.',"loanTermFrequency":'.$freq.',"loanTermFrequencyType":0,"numberOfRepayments":'.$freq.',"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"inArrearsTolerance":365,"graceOnArrearsAgeing":365,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"'.$disbursementdate.'","submittedOnDate":"'.$submitteddate.'"}');// Date Format 27 October 2018
    $serverurl="https://localhost:8000/";
	//die($serverurl."fineract-provider/api/v1/loans/".$loanid."?command=approve&tenantIdentifier=default");
    $freq=12;
    $curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt_array($curl, array(
  CURLOPT_PORT => "8000",
  CURLOPT_URL => $serverurl."fineract-provider/api/v1/accounts/share&tenantIdentifier=default",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  //CURLOPT_POSTFIELDS => '{"clientId":"'.$clientid.'","productId":'.$product.',"disbursementData":[],"principal":'.$principal.',"loanTermFrequency":'.$freq.',"loanTermFrequencyType":2,"numberOfRepayments":'.$freq.',"repaymentEvery":1,"repaymentFrequencyType":2,"interestRatePerPeriod":2.25,"amortizationType":1,"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"inArrearsTolerance":1,"graceOnArrearsAgeing":1,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"'.$disbursementdate.'","submittedOnDate":"'.$submitteddate.'"}', //
 // CURLOPT_POSTFIELDS =>'{"approvedOnDate":"'.$approvaldate.'","approvedLoanAmount":'.$principal.',"note":"'.$note.'","expectedDisbursementDate":"'.$disbursementdate.'","disbursementData":[],"locale":"en","dateFormat":"dd MMMM yyyy"}',
   CURLOPT_POSTFIELDS => '{
	"clientId":"'.$clientid.'",
	"productId": 1,
	"requestedShares":"'.$approvaldate.'",
	"externalId": "'.$externalid.'",
	"submittedDate": "'.$submitteddate.'",
	"minimumActivePeriod": "1",
	"minimumActivePeriodFrequencyType": 0,
	"lockinPeriodFrequency": "1",
	"lockinPeriodFrequencyType": 0,
	"applicationDate": "'.$applicationdate.'",
	"allowDividendCalculationForInactiveClients": true,
	"locale": "en",
    "dateFormat": "dd MMMM yyyy"}',
    CURLOPT_HTTPHEADER => array(
    "authorization: Basic bWlmb3M6cGFzc3dvcmQ=",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 82f71847-a076-7a85-a4d7-ed6745be0190"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

//die(print_r($curl));

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
    
}

function DisburseLoan($loanid,$accno,$principal,$disbursementdate,$note){
  //  die('{"clientId":"'.$clientid.'","productId":'.$product.',"disbursementData":[],"fundId":1,"principal":'.$principal.',"loanTermFrequency":'.$freq.',"loanTermFrequencyType":0,"numberOfRepayments":'.$freq.',"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"inArrearsTolerance":365,"graceOnArrearsAgeing":365,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"'.$disbursementdate.'","submittedOnDate":"'.$submitteddate.'"}');// Date Format 27 October 2018
    $serverurl="https://localhost:8000/";
    $freq=12;
    $curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt_array($curl, array(
  CURLOPT_PORT => "8000",
  CURLOPT_URL => $serverurl."fineract-provider/api/v1/loans/".$loanid."?command=disburse&tenantIdentifier=default",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  //CURLOPT_POSTFIELDS => '{"clientId":"'.$clientid.'","productId":'.$product.',"disbursementData":[],"principal":'.$principal.',"loanTermFrequency":'.$freq.',"loanTermFrequencyType":2,"numberOfRepayments":'.$freq.',"repaymentEvery":1,"repaymentFrequencyType":2,"interestRatePerPeriod":2.25,"amortizationType":1,"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"inArrearsTolerance":1,"graceOnArrearsAgeing":1,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"'.$disbursementdate.'","submittedOnDate":"'.$submitteddate.'"}', //
  CURLOPT_POSTFIELDS =>'{
  "dateFormat": "dd MMMM yyyy",
  "locale": "en",
  "transactionAmount":'.$principal.',
  "actualDisbursementDate":"'.$disbursementdate.'",
  "paymentTypeId": "4",
  "note": "'.$note.'",
  "accountNumber": "'.$accno.'",
  "receiptNumber": "'.$accno.'",
  "bankNumber": "WAUMINI"
}',
    
    CURLOPT_HTTPHEADER => array(
    "authorization: Basic bWlmb3M6cGFzc3dvcmQ=",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 82f71847-a076-7a85-a4d7-ed6745be0190"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
    
}


