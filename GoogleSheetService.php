<?php

class GoogleSheetService
{
    private string $spreadsheetId;
    private string $sheetName;
    private string $range = '';
    private array $data;
    private Google_Service_Sheets $service;

    const VALUE_INPUT_OPTION = 'USER_ENTERED';

    public function __construct(Google_Service_Sheets $service, string $spreadsheetId, string $sheetName)
    {
        $this->service = $service;
        $this->spreadsheetId = $spreadsheetId;
        $this->sheetName = $sheetName;
    }

    public function setSpreadSheetId(string $spreadsheetId): self
    {
        $this->spreadsheetId = $spreadsheetId;

        return $this;
    }

    public function setSheet(string $sheetName): self
    {
        $this->sheetName = $sheetName;

        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setRange(string $range): self
    {
        $this->range = $range;

        return $this;
    }

    public function sendData(): mixed
    {
        $existingData = $this->getData();

        $duplicate = $this->checkDuplicates($this->data, $existingData);
        if ($duplicate) {
            echo 'Duplcate found';
            return false;
        }
        $valueRange = new Google_Service_Sheets_ValueRange();
        $valueRange->setValues([$this->data]);
        $range = $this->sheetName; // the service will detect the last row of this sheet
        $options = ['valueInputOption' => self::VALUE_INPUT_OPTION];
        $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $valueRange, $options);
        unset($this->data);
        echo 'Data sent successfully';
        return true;
    }

    public function checkDuplicates(array $newRows, $existingData): bool
    {
        
        print_r($existingData);
        $isDuplicate = false;

        foreach ($existingData as $rowData) {

            // Assuming the first column contains unique identifiers
            if ($rowData[0] == $newRows[0]) { 
                $isDuplicate = true;
                break;
            }
            
        }

        // If no duplicates, add the new row
        if (!$isDuplicate) {
            echo "New entry added successfully.";
        } else {
            echo "Duplicate entry found. Not added to the spreadsheet.";
        }
        return $isDuplicate;
    }

    public function updateData(array $updateRow): void
    {
        $valueRange = new Google_Service_Sheets_ValueRange();
        $valueRange->setValues([$updateRow]);
        $range = $this->sheetName . $this->range;
        $options = ['valueInputOption' => self::VALUE_INPUT_OPTION];
        $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $valueRange, $options);
    }

    public function deleteRow(): void
    {
        $range = $this->sheetName . '!' . $this->range; // the range to clear, the 23th and 24th lines
        $clear = new Google_Service_Sheets_ClearValuesRequest();
        $this->service->spreadsheets_values->clear($this->spreadsheetId, $range, $clear);
    }

    public function getData(): array
    {
        $range = $this->sheetName . '!A1:K'; // assign the range you want to get
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);

        return $response->getValues();
    }

    protected function getRange(): string
    {
        return $this->sheetName . '!' . $this->range;
    }

}


require_once __DIR__ . '/config.php';

$googleSheetService = new GoogleSheetService($service, '1udSubIQrO0XQyQ7x5ZPM7tivroY9kBBxcJifbsq1PVY', 'genie-usage');








$array = [
    "5000",
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
];


$googleSheetService
    ->setData($array)
    ->sendData();












