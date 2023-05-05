
<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Huboffercity</title>
</head>
<body style="background-color:#eee;">
  <table style="background:#ffffff; border-spacing: 0; border-collapse:collapse; padding: 0px;  width: 600px; margin: 0 auto;">
    <tr>
      <td>
        <table style="width: 100%; background-color: #fff; padding: 15px 15px;">
          <tr>
            <td style="text-align: center;">
              <img src="{{asset('assets_front/images/brand-logo/logo.png')}}" alt="Huboffercity" style="width: 140px;">
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td> 
       <table style="width: 100%; background-color:#B6D8FA; padding: 15px;">
          <tr>
            <td style=" background-color: #B6D8FA; padding: 10px;">
              
              <div style="margin: 0; padding: 0 0 20px; font-size: 14px; color: #000;"><?php echo $messageBody; ?>
                @php $email_signature=getEmailSignature();  @endphp 
                {!! @$email_signature->option_value !!}
                </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width: 100%; background-color: #111C4E; padding: 20px 15px;">
          <tr>
            <td style="text-align: center; border-bottom: 1px solid #dddddd4f; padding: 5px 0px 15px;">
              <h4 style="text-align: center; font-size: 30px; color: #fff; font-family:'Prompt-Semibold'; margin: 0; padding: 0 0 20px;">Follow Us</h4>
                @php $links=getFooterSocialLink(); @endphp 
                <a style="text-decoration: none; padding-right: 10px;" href="{{@$links[0]}}"><img src="{{asset('template/images/facebook1.png')}}" alt="facebook" style="width: 40px;"></a>
                <a style="text-decoration: none; padding-right: 10px;" href="{{@$links[2]}}"><img src="{{asset('template/images/instagram1.png')}}" alt="instagram" style="width: 40px;"></a>
                <a style="text-decoration: none; padding-right: 10px;" href="{{@$links[1]}}"><img src="{{asset('template/images/twitter1.png')}}" alt="twitter" style="width: 40px;"></a>
            </td>
          </tr>
          <tr>
            <td style="text-align: center; padding: 10px 0 0 0">
              <a style="text-decoration: none; color: #fff; font-size: 14px; padding: 0px 10px;" href="https://offercity.com/about-us/" target="_blank">About Us</a>
              <a style="text-decoration: none; color: #fff; font-size: 14px; padding: 0px 10px;" href="https://offercity.com/terms-of-service/" target="_blank">Terms & Conditions</a>
              <a style="text-decoration: none; color: #fff; font-size: 14px; padding: 0px 10px;" href="https://offercity.com/privacy-policy/" target="_blank">Privacy Policy</a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
<style>
  * { font-family: 'Prompt-Regular'; }
  @font-face {
  font-family: 'Prompt-Regular';
  src: url('./fonts/Prompt-Regular.eot?#iefix') format('embedded-opentype'),
       url('./fonts/Prompt-Regular.otf')  format('opentype'),
       url('./fonts/Prompt-Regular.woff') format('woff'),
       url('./fonts/Prompt-Regular.ttf')  format('truetype'),
       url('./fonts/Prompt-Regular.svg#Prompt-Regular') format('svg');
  font-weight: normal;
  font-style: normal;
}
@font-face {
    font-family: 'Prompt-Semibold';
    src: url('./fonts/Prompt-Semibold.eot');
    src: url('./fonts/Prompt-Semibold.eot?#iefix') format('embedded-opentype'),
        url('./fonts/Prompt-Semibold.woff2') format('woff2'),
        url('./fonts/Prompt-Semibold.woff') format('woff'),
        url('./fonts/Prompt-Semibold.ttf') format('truetype'),
        url('./fonts/Prompt-Semibold.svg#Prompt-Semibold') format('svg');
    font-weight: 600;
    font-style: normal;
    font-display: swap;
}
@font-face {
  font-family: 'Prompt-Bold';
  src: url('./fonts/Prompt-Bold.eot?#iefix') format('embedded-opentype'),
       url('./fonts/Prompt-Bold.otf')  format('opentype'),
       url('./fonts/Prompt-Bold.woff') format('woff'),
       url('./fonts/Prompt-Bold.ttf')  format('truetype'),
       url('./fonts/Prompt-Bold.svg#Prompt-Bold') format('svg');
  font-weight: normal;
  font-style: normal;
}
</style>
</html>