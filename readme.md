# Google Sheet Data Sender

Configure Google Sheet
Configure **google php client** 


# Configuration Google Sheet API


1. Create a new project or Select existing from [Google Cloud Console ](https://console.cloud.google.com/)
![Create Project](https://img001.prntscr.com/file/img001/HWZmsNuZTjuuYuKpBZ4fYg.png)
2. Then navigate to APIs & Services -> Enabled APIs & Services
![Javatpoint](https://img001.prntscr.com/file/img001/Qod3uvsZSySGm2z7fzyXNg.png)
3. Search Google Google Sheet then click to google sheet and enable
4. After Enabled there will be Manage Button click to manage 
![Javatpoint](https://img001.prntscr.com/file/img001/jBQELy_4TXCAlaULgsCg4A.png)
5. There will be three tab last one is Credentials click that tab
6. There is a **+ Create Credentials** Button click that and select **Service account**
![Javatpoint](https://img001.prntscr.com/file/img001/CTHECQDjRWqgRFoTk8i9eg.png)
7. Provide information about this service account leave the optional fields click create then done.
![Javatpoint](https://img001.prntscr.com/file/img001/Z8Szf6OHRga4xP3ea3Y4lA.png)
8. Generate Keys from service account

![Javatpoint](https://img001.prntscr.com/file/img001/-3EwT2QwQDO4BaQ3jJ6YDw.png)
Click keys tab then add keys 
create new keys 
![Javatpoint](https://img001.prntscr.com/file/img001/5WhOERpTR2qZyCJZaRqRYA.png)
9. It will give you JSON file to download 

![Javatpoint](https://img001.prntscr.com/file/img001/k_HwqS5MR9CWILXy_rTrrg.png)
Attach the sheet you want to give permission that service account make sure it's editor role 
![Javatpoint]( https://img001.prntscr.com/file/img001/kyYbrelLR6-HFMltmWWD9Q.png)


# Configuration PHP Google Client

Install google/apiclient Package
    `composer require google/apiclient`

 

       <?php
    
      
    
    // Usage:
    
    require_once  'vendor/autoload.php';
    
      
    
    $client = new  Google_Client();
    
    $client->setApplicationName('Google Sheets API');
    
    $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    
    $client->setAccessType('offline');
    
    $path = __DIR__  .  '/credential.json'; //this file was genated from service account
    
    $client->setAuthConfig($path);
    
      
    
    $service = new  Google_Service_Sheets($client);




Send data to sheet 

  

    $googleSheetService = new  GoogleSheetService($service);

  
  

    $array = [
    
    	[
    
    	"10",
    
    	"10000",
    
    	"seo features",
    
    	"keyword cluster",
    
    	"getgenie?local",
    
    	"en",
    
    	"1577",
    
    	"0",
    
    	"0",
    
    	"2023-12-13 8:48:51",
    
    	"Gelenie Free-Free"
    
    	],
    
    ];

  
  

    $googleSheetService
    
    ->setSpreadSheetId('1udSubIQrO0XQyQ7x5ZPM7tivroY9kBBxcJifbsq1PVY') // Spreadsheet ID
    
    ->setSheet('genie-usage') // Sheet name
    
    ->setData($array)
    
    ->send();



Clear and Insert 

    $googleSheetService
    
    ->setSpreadSheetId('1udSubIQrO0XQyQ7x5ZPM7tivroY9kBBxcJifbsq1PVY') // Spreadsheet ID
    
    ->setSheet('genie-usage') // Sheet name
    
    ->setData($array)
    
    ->clearAndInsert(); 





