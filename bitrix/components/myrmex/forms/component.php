<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//print_r($arParams);
CModule::IncludeModule('iblock');
global $DB, $HTTP_HOST;

$var = ($arParams['SEND_NAME'] ? $arParams['SEND_NAME'] : 'send');
if($_POST && $_POST[$var]){
        $error_arr = array();                                      //Сообщения об ошибках
        $arFields = array();                                       //Массив с отправляемыми данными
        $files_str="";                                             //Строка местоположения файлов
        $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/upload/files';    //Директория закачки
        $uploaddirhttp = "http://".$HTTP_HOST."/upload/files";     //веб-адрес директории закачки

        //собираем все данные из $_POST-массива
        foreach($_POST as $key=>$val){
                if(substr($key, 0, 7) == 'public_'){
                        $field_name = strtoupper(substr($key, 7));
                        $arPostFields[$field_name] = $val;

                        //валидация
                        if(isset($arParams['VALID_'.$field_name])){
                                switch($arParams['VALID_'.$field_name]){
                                        case 'not_empty':
                                                if(strlen(trim($val)) == 0){
                                                        $error_arr[] = GetMessage("FIELD").$_POST[$key.'_label'].GetMessage("MB_NOT_EMPTY");
                                                }
                                                break;
                                        case 'number':
                                                if(preg_match('/\D/', trim($val))){
                                                        $error_arr[] = GetMessage("IN_FIELD").$_POST[$key.'_label'].GetMessage("MB_NUMBER");
                                                }
                                                break;
                                        case 'email':
                                                if(!preg_match('/^(.+)@(.+)\.(.+)$/', trim($val))){
                                                        $error_arr[] = GetMessage("IN_FIELD").$_POST[$key.'_label'].GetMessage("INCORRECT_EMAIL");
                                                }
                                                break;
                                        case 'email_or_empty':
                                                if(!preg_match('/^(.+)@(.+)\.(.+)$/', trim($val)) && strlen(trim($val)) > 0){
                                                        $error_arr[] = GetMessage("IN_FIELD").$_POST[$key.'_label'].GetMessage("INCORRECT_EMAIL");
                                                }
                                                break;
                                }
                        }
                }
        }


         //собираем все данные из $_FILES-массива
         foreach($_FILES as $key => $value)
         {
           //Если это файл, то он имеет префикс file_
           $is_file = (substr($key,0,5)=="file_");
           //Если это картинка, то она имеет префикс image_
           $is_image = (substr($key,0,6)=="image_");

           if($is_file || $is_image)
           {
               //Если файл закачан
               if ( is_uploaded_file($_FILES[$key]['tmp_name']) )
               {
                   //Пытаемся создать директорию /files/
                   if( !is_dir($uploaddir) )
                    {
                       if(!@mkdir($uploaddir, 0777)) $error_arr[] = GetMessage("CANNOT_CREATE_FOLDER").$uploaddir.GetMessage("ACCESS_DENIED");
                    }

                    //Узнаем время до миллисекунд
                    list($usec, $sec) = explode(" ",microtime());

                    //Надо найти расширение
                    $extension = strtolower(end(explode(".",$_FILES[$key]['name'])));

                    if($is_file){
                      $field_name = strtoupper(substr($key, 5));
                      //!!!Необходимо проверить все расширения: не должно быть php, htm, txt - иначе сломают
                      if($extension=='doc' or $extension=='xls' or $extension=='rtf' or $extension=='pdf' or $extension=='txt' or $extension=='zip' or $extension=='gzip' or $extension=='rar')
                       {
                          //Создаем временное имя для файла
                          $tmpfilename=$sec.round($usec*1000).'.'.$extension;

                          if(filesize($_FILES[$key]['tmp_name']) > 1500000)
                          {
                             $error_arr[] = GetMessage("ERROR_UPLOAD_1");
                          }
                          else
                          {
                            copy($_FILES[$key]['tmp_name'], $uploaddir.'/'.$tmpfilename);
                            $files_str .= "<div><a href=\"".$uploaddirhttp.'/'.$tmpfilename."\">".GetMessage("FILE")."</a></div>";
                            $arPostFields[$field_name] = $uploaddirhttp.'/'.$tmpfilename;
                          }

                       }
                      else
                       {
                         $error_arr[] = GetMessage("ERROR_UPLOAD_2");
                       }
                    }elseif($is_image){
                      $field_name = strtoupper(substr($key, 6));
                      //!!!Необходимо проверить все расширения: не должно быть php, htm, txt - иначе сломают
                      if($extension=='jpg' or $extension=='gif' or $extension=='png')
                       {
                          //Создаем временное имя для файла
                          $tmpfilename=$sec.round($usec*1000).'.'.$extension;

                          if(filesize($_FILES[$key]['tmp_name']) > 1500000)
                          {
                             $error_arr[] = GetMessage("ERROR_UPLOAD_3");
                          }
                          else
                          {
                            copy($_FILES[$key]['tmp_name'], $uploaddir.'/'.$tmpfilename);
                            $files_str.="<div><a href=\"".$uploaddirhttp.'/'.$tmpfilename."\">".GetMessage("PICTURE")."</a></div>";
                            $arPostFields[$field_name] = $uploaddirhttp.'/'.$tmpfilename;
                          }
                       }
                      else
                       {
                         $error_arr[] = GetMessage("ERROR_UPLOAD_4");
                        }
                    }
               }
           }
         }


        $arFields = array_merge($arFields, $arPostFields);

        if($arParams['USE_CAPTCHA']=="Y" && !$APPLICATION->CaptchaCheckCode($_POST['captcha'], $_POST['captcha_sid'])){
                $error_arr[] = GetMessage("INCORRECT_CAPTCHA_CODE");
        }

        if(count($error_arr) == 0){
                //print_r($arFields);

                //если определено почтовое событие, то отправляем письмо
                $event_type = trim($arParams['EVENT_TYPE']);
                if(strlen($event_type) > 0){
                         $arFields['EMAIL_FROM'] = $arParams['EMAIL_FROM'];
                         $arFields['EMAIL_TO'] = $arParams['EMAIL_TO'];
                         $arFields['SUBJECT'] = $arParams['SUBJECT'];
                         $arFields['PREFIX'] = $arParams['PREFIX'];

                         $body = '';
                         if(strlen($arFields['SUBJECT'])) $body .= $arFields['SUBJECT'].':<br>';
                         foreach($arPostFields as $key=>$val){
                                  if(substr($key, -6) != '_LABEL' && strlen($arPostFields[$key.'_LABEL'])){
                                          $body .= '<b>'.$arPostFields[$key.'_LABEL'].'</b>: '.$val.'<br>';
                                  }

                                  $props[$kproperties[$key]] = array('VALUE' => $val);
                         }
                         $arFields['BODY'] = $body.$files_str;

                         $event = new CEvent;
                         $event->Send($event_type, SITE_ID, $arFields);
                }

                //если указан инфоблок, то пишем данные в него
                $arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
                if($arParams['IBLOCK_ID'] > 0){
                 $z = $DB->Query('SELECT DISTINCT `ID`, `CODE` FROM `b_iblock_property` WHERE `IBLOCK_ID`='.$arParams['IBLOCK_ID']);
                 $properties = array();
                 $kproperties = array();
                 while($res = $z->Fetch()){
                         $properties[$res['ID']] = $res['CODE'];
                         $kproperties[$res['CODE']] = $res['ID'];
                 }

                 $props = array();
                 $propOdj = new CIBlockProperty;
                 foreach($arPostFields as $key=>$val){
                         if(substr($key, -6) != '_LABEL'){
                                 if(!in_array($key, $properties)){
                                         $arTemp = array(
                                                 "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                                                 "NAME" => ($arPostFields[$key.'_LABEL'] ? $arPostFields[$key.'_LABEL'] : $key),
                                                 "CODE" => $key,
                                         );

                                         $ID = $propOdj->Add($arTemp);
                                         $properties[$ID] = $key;
                                         $kproperties[$key] = $ID;
                                 }
                                 $props[$kproperties[$key]] = array('VALUE' => $val);
                         }
                 }

                 $arTemp = Array(
                         "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                         "NAME" => date('Y.m.d H:i:s'),
                         "PROPERTY_VALUES" => $props,
                 );
                 $elem = new CIBlockElement;
                 $elem->Add($arTemp);
                }

                $arResult['process'] = 'sent';
        }

        $arResult['error_arr'] = $error_arr;
}



if($arParams['USE_CAPTCHA']=="Y"){
        $arResult["CAPTCHACode"] = $APPLICATION->CaptchaGetCode();
}

//print_r($error_arr);
$this->IncludeComponentTemplate();
?>
