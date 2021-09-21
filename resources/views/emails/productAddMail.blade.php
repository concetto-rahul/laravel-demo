<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <div>
        <h3>Hello Admin,</h3>
        <p>New product added to system.</p>
        <p>Prodcut Details as below:</p>
        <table border=1>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Image</th>
            </tr>
            <tr>
                <td>{{ $details['name'] }}</td>
                <td>{{ $details['sku_code'] }}</td>
                <td><img src="{{asset($details['imageviewfile'])}}" style="width:100px"/></td>
            </tr>
        </table>
        <h5>This product added by {{ $details['added_by']." (".$details['added_id'].")" }}</h5>
    
    <p>Thank you</p>
    <p>Abcd</p>
    </div>
   
</body>
</html>