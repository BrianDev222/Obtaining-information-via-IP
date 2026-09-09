<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

$message = "";

$ip = trim($_POST["ip"]);

if (!empty($ip)) {

if (filter_var($ip, FILTER_VALIDATE_IP)) {
 

$api = "http://ip-api.com/json/{$ip}";

$ch = curl_init($api);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

$result = json_decode($response, true);

} else { 
 $message = "The IP is invalid.";
 } 
} else {
 $message = "Empty ip field";
 }
}


?>
<!DOCTYPE html>
<html lang="En" dir="lrt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Get ip Information </title>
    <style>
        body { 
          font-family: "SF Pro Display", "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
          margin: 50px;
        }
        .container { 
            max-width: 600px;
             margin: 0 auto; 
        }
        .form-group {
             margin: 20px 0; 
        }
        .form-group input[type="text"] { 
            padding: 10px; 
            width: 70%; 
            border: 1px solid #ccc; 
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group button { 
            padding: 10px 20px; 
            background: #007bff; 
            color: white; 
            border: none; 
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .result { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 5px; 
            margin-top: 20px;
            text-align: right;
        }
        pre {
            background: #fff; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            text-align: left; 
            font-size: 12px;
        }
        .success { 
            color: #28a745;
         }
        .error {
             color: #dc3545;
         }
        table { 
            width: 100%; 
            border-collapse: collapse;
         }
        td { 
            padding: 8px;
             border-bottom: 1px solid #ddd; 
        }
        td:first-child {
             font-weight: bold; 
             width: 40%; 
        }
    </style>
</head>
<body>
    <div class="container">
        <center>
            <h1> Get Information IP </h1>
            
            <form method="POST" class="form-group">
                <input type="text" name="ip" placeholder="8.8.8.8" required value="<?php if(isset($ip)) { echo $ip; } ?>">
                <button type="submit"> Check </button>
            </form>
            
            <?php if (isset($message)): ?>
                <div class="error">
                    <strong><?php echo $message; ?></strong>
                </div>
            <?php endif; ?>
            
            <?php if ($result && $result['status'] === 'success'): ?>
                <div class="result">
                    <h3> IP: <?php echo htmlspecialchars($result['query']); ?></h3>
                    <table>

                        <tr>
                            <td> Country </td>
                            <td><?php echo htmlspecialchars($result['country']); ?></td>
                        </tr>
                        
                        <tr>
                            <td> CountryCode </td>
                            <td><?php echo htmlspecialchars($result['countryCode']); ?></td>
                        </tr>
                        <tr>
                            <td> Region </td>
                            <td><?php echo htmlspecialchars($result['regionName']); ?></td>
                        </tr>
                        <tr>
                            <td> City </td>
                            <td><?php echo htmlspecialchars($result['city']); ?></td>
                        </tr>
                        <tr>
                            <td> Zip </td>
                            <td><?php echo htmlspecialchars($result['zip']); ?></td>
                        </tr>
                        <tr>
                            <td> lat </td>
                            <td><?php echo $result['lat'] . ', ' . $result['lon']; ?></td>
                        </tr>
                        <tr>
                            <td> Isp </td>
                            <td><?php echo htmlspecialchars($result['isp']); ?></td>
                        </tr>
                        <tr>
                            <td> Org </td>
                            <td><?php echo htmlspecialchars($result['org']); ?></td>
                        </tr>
                        <tr>
                            <td> Timezone </td>
                            <td><?php echo htmlspecialchars($result['timezone']); ?></td>
                        </tr>
                    </table>
                    
                    <details>
                        <summary> Josn </summary>
                        <pre class="pre">
                        <?php echo json_encode($result, JSON_PRETTY_PRINT); ?>
                        </pre>
                    </details>
                </div>
            <?php else: ?>

                <span class="error"> Error: can not result ip info </span>

            <?php endif; ?>
            
        </center>
    </div>
</body>
</html>