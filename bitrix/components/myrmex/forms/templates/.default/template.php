<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

   <script type="text/javascript" src="/image/validate.js"></script>


<?if($arResult['process'] == 'sent'){?>
         <div style="text-align: center;">
         <br/>
         <b>�������.</b><br/>
         <br/>
         <b>� ��������� ����� � ���� �������� ���� �� ����� ����������.</b><br/>
         <br/>
         <b><a href=".">���������</a></b>
         </div>
         <br/>
<?}else{?>

         <p>���������, ����������, �����. �� ����������� � ���� ��������.</p>

         <?
         if(is_array($arResult['error_arr']) && count($arResult['error_arr']) > 0){
         echo '<p style="color: red;">';
         foreach($arResult['error_arr'] as $key=>$val){
                echo $val.'<br>';
         }
         echo '</p>';
         }
         ?>

         <p style="font-size:80%">����, ���������� <span style="color:red;">*</span>, ����������� ��� ����������.</p><br/>


         <form method="post" onsubmit="return init_validate(this);"        enctype="multipart/form-data">

         <table>
         <tr>
         <td align="right">�. �. �.:<span style="color:red;">*</span>&nbsp;</td>
           <td style="padding:8px 0px 8px 0px;">
              <input name="public_fio_label" type="hidden" value="�.�.�." />
              <input name="public_fio"       type="Text"   title="�.�.�." validate="not_empty" class="faq_input" onclick="this.style.backgroundColor='white';" />
           </td>
         </tr>

         <tr>
         <td align="right">E-mail:<span style="color:red;">*</span>&nbsp;</td>
           <td style="padding:8px 0px 8px 0px;">
              <input name="public_email_label" type="hidden" value="E-mail" />
              <input name="public_email"       type="Text"   title="E-mail" validate="email" class="faq_input" onclick="this.style.backgroundColor='white';" />
           </td>
         </tr>

         <tr>
         <td align="right">�������:&nbsp;</td>
           <td style="padding:8px 0px 8px 0px;">
              <input name="public_phone_label" type="hidden" value="�������" />
              <input name="public_phone"       type="Text"   title="�������" class="faq_input" onclick="this.style.backgroundColor='white';" />
           </td>
         </tr>


         <tr>
         <td align="right">������:<span style="color:red;">*</span>&nbsp;</td>
           <td style="padding:8px 0px 8px 0px;">
              <input    name="public_comments_label" type="hidden"     value="����� ���������" />
              <textarea name="public_comments"       class="faq_input" style="width: 250px; height: 100px; overflow: auto;" field_title="����� ���������" validate="not_empty" onclick="this.style.backgroundColor='white';"></textarea>
           </td>
         </tr>

         <tr>
         <td align="right">����: &nbsp;</td>
           <td style="padding:8px 0px 8px 0px;">
              <input type="file" name="file_userfile" />
           </td>
         </tr>

         <tr>
         <td align="right">��������: &nbsp;</td>
           <td style="padding:8px 0px 8px 0px;">
              <input type="file" name="image_userimage" />
           </td>
         </tr>

         <?if($arParams['USE_CAPTCHA']=="Y"){?>
         <tr>
         <td align="right">&nbsp;</td>
           <td align="left" style="padding: 5px 0px 2px 0px">
                   <input type="hidden" name="captcha_sid" value="<?=htmlspecialchars($arResult["CAPTCHACode"]);?>" />
                   <img id="captcha_img" src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialchars($arResult["CAPTCHACode"]);?>" width="180" height="40" />
         </td>
         </tr>

         <tr>
             <td align="right">����������� ���:<span style="color:red;">*</span>&nbsp;</td>
           <td style="padding:0px 0px 0px 0px;">
                   <input name="captcha" id="captcha" type="text" value="" class="faq_input" validate="not_empty" field_title="��� �������������" />
                   <div style="font-size:80%;">������� ���, ����������� �� ��������.</div>
           </td>
         </tr>

         <tr>
         <td colspan="2">
               <div id="cap_id"></div>
         </td>
         </tr>
         <?}?>

         <tr>
         <td valign="top" align="right" colspan="2" style="padding:5px 0px 5px 0px;">
                   <input class="search_button" type="submit" name="send" value="���������" style="margin:0; width:80px;"/>
           </td>
         </tr>


         </tr>
         </table>
         </form>
<?}?>

