<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Homi</title>
</head>
<body style="background-color:#eee;">
  <table style="background:#ffffff; border-spacing: 0; border-collapse:collapse; padding: 0px;  width: 600px; margin: 0 auto;">
    <tr>
      <td>
        <table style="width: 100%; background-color: #fff; padding: 15px 15px;">
          <tr>
            <td style="text-align: center;">
              <img src="{{asset('assets_front/images/brand-logo/logo.png')}}" alt="Offercity" style="width: 140px;">
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
              <p>Hello {{ $messageBody ? $messageBody['name'] : '' }}</p>
              <p style="margin: 0; padding: 0 0 20px; font-size: 18px; color: #000;"> You can reset your password by clicking the button below:</p>
              <p style="margin: 0; padding: 0 0 20px; font-size: 18px; color: #000;"> {!! $messageBody['token'] !!}</p>
              <p style="margin: 0; padding: 0 0 5px; font-size: 18px; color: #000;">Thank You</p>
              <p style="margin: 0; padding: 0 0 15px; font-size: 18px; color: #000;">Team Homi</p>
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