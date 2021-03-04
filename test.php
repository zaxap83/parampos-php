<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

include "vendor/autoload.php";

use ParamposLibrary\TransactionQuery;
use ParamposLibrary\TransactionAbstact;
use ParamposLibrary\InstallmentPlanForMerchant;
use ParamposLibrary\InstallmentPlanForUser;
use ParamposLibrary\UpdateInstallmentPlan;
use ParamposLibrary\CardInformations;
use ParamposLibrary\Payment;


echo '<pre>';

$testCards = [
    'ZİRAAT BANKASI Visa' => [ 'num' => '4546711234567894', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'ZİRAAT BANKASI Master' => [ 'num' => '5401341234567891', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'FİNANSBANK Visa' => [ 'num' => '4022774022774026', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'FİNANSBANK Master' => [ 'num' => '5456165456165454', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'AKBANK Visa' => [ 'num' => '4355084355084358', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'AKBANK Master' => [ 'num' => '5571135571135575', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'İŞ BANKASI Visa' => [ 'num' => '4508034508034509', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'İŞ BANKASI Master' => [ 'num' => '5406675406675403', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'HALK BANKASI Visa' => [ 'num' => '4531444531442283', 'y' => '2026', 'm' => '12', 'code' => '000' ],
    'HALK BANKASI Master' => [ 'num' => '5818775818772285', 'y' => '2026', 'm' => '12', 'code' => '001' ],
    'Test Visa' => [ 'num' => '4242424242424242', 'y' => '2026', 'm' => '12', 'code' => '001' ],
    'Test Visa 2' => [ 'num' => '4444444444444444', 'y' => '2026', 'm' => '12', 'code' => '111' ],
];

$cardKey = 'ZİRAAT BANKASI Visa';

$cardNum = $testCards[$cardKey]['num'];
$cardYear = $testCards[$cardKey]['y'];
$cardMonth = $testCards[$cardKey]['m'];
$cardCVC = $testCards[$cardKey]['code'];

$cardInfoReq = new CardInformations($cardNum); //BIN_SanalPos
$cardInfoData = $cardInfoReq->get();

$cardInfo = $cardInfoData;

$merchantPlanReq = new InstallmentPlanForUser(); //TP_Ozel_Oran_SK_Liste
$merchantPlans = $merchantPlanReq->get();

foreach( $merchantPlans as $name => $plan ) {

    $cardInfo['planPosName'] = $name;
    $cardInfo['planData'] = $plan[0];

    if( isset( $plan[0]['SanalPOS_ID'] ) && $plan[0]['SanalPOS_ID'] == $cardInfo['posId'] ) {

        for( $i = 1; $i < 12; $i++ ) {
            $cardInfo['user_plans']['MO_0'.$i] = $plan[0]['MO_0'.$i];
        }
        
        break;
    }
}

$orderID = 100035;
$transactionID = '1a34afa323356'.$orderID;

$orderSumm = 500;
$commission = 0;

if( $cardInfo['user_plans']['MO_01'] ) $commission = $cardInfo['user_plans']['MO_01'];

$total = $orderSumm + ( ($orderSumm * $commission) / 100);

$summFormated = number_format( $orderSumm, 2, ',', '');
$totalFormated = number_format( $total, 2, ',', '');

$x = new Payment();

$x->setPosId($cardInfo['posId']);
$x->setCardHolderName("Alex Zakharov");
$x->setCardNumber($cardNum);
$x->setCardExpireYear($cardYear);
$x->setCardExpireMonth($cardMonth);
$x->setCardCvc($cardCVC);
$x->setCardHolderPhone("+380501232255");
$x->setSuccessUrl("http://zaxap.asuscomm.com/webhook/setpaymentstatus/success");
$x->setFailUrl("http://zaxap.asuscomm.com/webhook/setpaymentstatus/fail");
$x->setOrderId($transactionID);
$x->setOrderDescription("Test order $transactionID description text");
$x->setInstallment("1");
$x->setTotalPrice($summFormated);
$x->setTotalGeneralPrice($totalFormated);
$x->setTransactionId($transactionID);
$x->setIpAddress("127.0.0.1");
$x->setReferenceUrl("http://zaxap.asuscomm.com/webhook/setpaymentstatus/test");
$x->setExtraData1("");
$x->setExtraData2("");
$x->setExtraData3("");
$x->setExtraData4("");
$x->setExtraData5("");

//print_r($merchantPlans); die;
print_r($x);
print_r($cardInfoData);
print_r($x->create()); //TP_Islem_Odeme_WNS or TP_Islem_Odeme

echo '</pre>';