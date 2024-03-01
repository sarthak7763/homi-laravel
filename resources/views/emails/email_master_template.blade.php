<!DOCTYPE html>
<html>
<head>
    <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    * {
        box-sizing: border-box;
    }
</style>
</head>
<body>
<div class="signup_table" style="font-family: arial;">
    <div class="container">
        <table style="text-align: left; max-width: 700px; margin: auto; border: 1px solid #ddd; border-collapse: collapse;">
            <thead style="background: #f4f4fb;">
                <tr>
                    <th colspan="2" style="text-align: center; padding: 15px 0;">
                        <p style="padding-left : 15px">
                            <img src="{{url('/')}}/storage/uploads/sitelogo/Logo.png" style="display:block" width="200px" height="89" alt="homi" title="homi" />
                        </p>    
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" style="font-size: 15px; line-height: 26px; padding: 8px; border-bottom: 1px solid #ddd;">
                        {!! $details['email_content'] !!}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
