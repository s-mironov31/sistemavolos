<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
        return;

global $DB;


$DEFAULT_EMAIL_FROM = COption::GetOptionString("main", "email_from", "admin@".$GLOBALS["SERVER_NAME"]);

$arComponentParameters['PARAMETERS']['EMAIL_FROM'] = Array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("EMAIL_FROM"),
        "TYPE" => "STRING",
        "DEFAULT" => $DEFAULT_EMAIL_FROM,
);

$arComponentParameters['PARAMETERS']['EMAIL_TO'] = Array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("EMAIL_TO"),
        "TYPE" => "STRING",
        "DEFAULT" => $DEFAULT_EMAIL_FROM,
);

$arComponentParameters['PARAMETERS']['SUBJECT'] = Array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("SUBJECT"),
        "TYPE" => "STRING",
);

$arComponentParameters['PARAMETERS']['PREFIX'] = Array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("PREFIX"),
        "TYPE" => "STRING",
);

$arComponentParameters['PARAMETERS']['USE_CAPTCHA'] = Array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("USE_CAPTCHA"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
);

/*$db_res = CEventType::GetList();
while($res = $db_res->Fetch()){
        print_r($res);
}*/

$event_types = array();
$z = $DB->Query('SELECT `ID`,`EVENT_NAME`, `NAME` FROM `b_event_type`');
$event_types[""] = GetMessage("NOT_SELECTED");
while($res = $z->Fetch()){
        //$event_types[$res['ID']] = $res['NAME'].' ['.$res['EVENT_NAME'].']';
        //$event_types[$res['ID']] = $res['EVENT_NAME'];
		$event_types[$res['EVENT_NAME']] = $res['EVENT_NAME'];
}

$arComponentParameters['PARAMETERS']['EVENT_TYPE'] = Array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("POST_EVENT_TYPE"),
        "TYPE" => "LIST",
        "VALUES" => $event_types,
);


$iblock_types = array();
$z = $DB->Query('SELECT a.`ID`, b.`NAME` FROM `b_iblock_type` a, `b_iblock_type_lang` b WHERE a.`ID`=b.`IBLOCK_TYPE_ID` and b.`LID`="'.LANG.'"');
$iblock_types[""] = GetMessage("NOT_SELECTED");
while($res = $z->Fetch()){
        $iblock_types[$res['ID']] = $res['NAME'];
}

$arComponentParameters['PARAMETERS']['IBLOCK_TYPE'] = Array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("R_IBLOCK_TYPE"),
        "TYPE" => "LIST",
        "VALUES" => $iblock_types,
        "REFRESH" => "Y",
);

if(strlen($arCurrentValues['IBLOCK_TYPE']) > 0){
        $iblocks = array();
        $z = $DB->Query('SELECT `ID`, `NAME` FROM `b_iblock` WHERE `IBLOCK_TYPE_ID`="'.$arCurrentValues['IBLOCK_TYPE'].'"');
        $iblocks[""] = GetMessage("NOT_SELECTED");
        while($res = $z->Fetch()){
                $iblocks[$res['ID']] = $res['NAME'];
        }

        $arComponentParameters['PARAMETERS']['IBLOCK_ID'] = Array(
               "PARENT" => "BASE",
               "NAME" => GetMessage("R_IBLOCK"),
               "TYPE" => "LIST",
               "VALUES" => $iblocks,
        );
}

$arComponentParameters['PARAMETERS']['SEND_NAME'] = Array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("R_SEND_NAME"),
        "TYPE" => "STRING",
);

?>
