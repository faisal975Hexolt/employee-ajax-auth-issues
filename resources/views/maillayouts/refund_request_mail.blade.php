<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME_FULL')}}</title>

</head>
    <body style="margin:0;padding:0">
        <div style="width:100%;min-width:320px; font-family:Helvetica,Arial;font-weight:bold;font-size:24px;background-image: url(./bg1.png);background-size: contain;background-repeat: no-repeat;">
        <div>
          <div style="position: relative;top: 25px; margin:0 auto; width:100%;max-width:598px;text-align:center;background-color:#fff">
            <table style="width:100%;max-width:599px;font-family:Arial;font-size:16px;color:#868686;background-color:#efefeb;border: 1px solid rgb(167, 167, 167);" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="background-color:#887aff;width:auto"> </td>
                  <td style="background-color:#887aff;text-align:center;width:75px">
                    <div style="width: 130px;">
                      <img style="vertical-align:bottom;width:130px;" src="{{ asset('new/img/s2Pay_Logo_email.png')}}" alt="{{env('APP_NAME')}}">
                    </div>
                  </td>
                  <td style="padding-top:30px;height:38px;background-color:#887aff;width:auto"> </td>
                </tr>
              </tbody>
            </table>
            <table style="width:100%;max-width:600px;font-family:Arial;font-size:16px;color:#868686;table-layout:fixed;border: 1px solid rgb(167, 167, 167);" cellspacing="0" cellpadding="0" border="0">
             <thead>
               <th colspan="3">
                <p style="text-align:center;width:auto;background-color:#fff;padding: 40px 0;font-size: 28px;font-weight: 550;color: #061f5f;border-bottom: 1px solid rgb(167, 167, 167);margin: 0;">Welcome to {{env('APP_NAME')}}</p>
                <p style="text-align:center justify;line-height: 26px; width:auto;background-color:#fff;padding: 12px 20px;text-align: justify; font-size: 17px;font-weight: 450;color: rgb(143, 143, 143);margin: 0;">
                Dear {{$htmldata["merchanName"]}},

                <br><br>We hope this email finds you well. We are writing to acknowledge that we have received your refund request for the order/transaction with number : {{$htmldata["transaction_id"]}}.

                <br><br>Please rest assured that our team is currently reviewing your request, and we will process it as quickly as possible. We aim to provide you with a seamless refund experience and will do our best to resolve the matter promptly.

                <br><br>In the meantime, here are some important points to keep in mind regarding the refund process:

                <br><br>Refund Status: Once your refund request is processed, we will notify you of its approval or denial. If approved, the refund amount will be credited back to the original payment method used during the purchase.

                <br><br>Processing Time: The refund processing time may vary depending on your payment method and financial institution. Usually, it takes [4 business days/weeks] for the funds to be reflected in your account.

                <br><br>Notification: As soon as your refund is processed, you will receive an email confirmation with the details of the refund amount and the payment method used.

                <br><br>Contact Information: If you have any questions or concerns about your refund or any other issues, please don't hesitate to contact our customer support team at [{{env('SUPPORT_CONTATCT_MAIL')}}/{{env('SUPPORT_NUMBER')}}].

                <br><br>We sincerely apologize for any inconvenience caused and appreciate your patience during this process. Our team is working diligently to resolve the matter to your satisfaction.

                    <br><br>Thank you for your understanding.

                    <br>Best regards,   
                
                
               
               </th>
             </thead>
             
              <tbody>
                <tr  style="text-align:center;width:auto;background-color:#fff;padding: 30px 0;font-size: 14px;font-weight: 400;">
                  <td style="padding: 20px 0;border-bottom: 1px solid #ccc;" colspan="3"><p style="text-align: start;padding: 0 13px;line-height: 29px;">If you have any queries concerning the processing of your online payment, please contact our support, <span style="color: #178ddb;"><a href="mailto:{{env('SUPPORT_CONTATCT')}}"></a>{{env('SUPPORT_CONTATCT')}}</span></p></td>
                </tr>
                <tr>
                  <td colspan="1"><div class="row">
                    <div style="float: left; width: 100%;">
                      <p style="font-weight: 400;font-size: 13px;padding-left: 8px;line-height: 22px;">{{env('APP_NAME')}}
                        <br><a href="mailto:{{'COMPANY_CONTATCT'}}">{{env('COMPANY_CONTATCT')}}</a>
                        <br><a href="tel:{{ env('SUPPORT_NUMBER') }}">{{ env('SUPPORT_NUMBER') }}</a>
                      </p>
                    </div>
                  </div></td>
                  <td colspan="2">
                    <div style="float: right;padding: 5px 8px 5px 0;">
                      <a href="#" target="_blank"><img src="{{asset('/images/managepay-pci.png')}}" alt="{{env('APP_NAME')}}-pci" width="70"></a>
                      <img src="https://grimsbygardencentre.org.uk/img/paypal-cards.png" width="90" alt="" style="margin-top: -40px;">
                    </div>
                  </td>
                </tr>
               
              </tbody>
            </table>
            <p style="text-align:center justify; width:auto;background-color:#fff;padding: 12px 20px;font-size: 15px;font-weight: 400;color: rgb(143, 143, 143);">&copy; Copyright Designed By <span style="color: #178ddb;text-decoration: underline;">{{env('APP_NAME_FULL')}}</span></p>
          </div>
        </div>
       
        </div>
</body>
</html>