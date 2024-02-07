<?php

class GoogleSheetService
{
    private string $spreadsheetId;
    private string $sheetName;
    private string $range = '';
    private array $data;
    private Google_Service_Sheets $service;

    const VALUE_INPUT_OPTION = 'USER_ENTERED';

    public function __construct(Google_Service_Sheets $service,
         string $spreadsheetId = '',
         string $sheetName = '')
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

    public function sendBatchData(): bool
    {
        try {
            $existingData = $this->getData();

            if ($this->checkBatchDuplicates($this->data, $existingData)) {
                throw new Exception('Duplicate entries found. Data not sent to the spreadsheet.');
            }

            $valueRange = new Google_Service_Sheets_ValueRange();
            $valueRange->setValues($this->data);
            $range = $this->sheetName; // the service will detect the last row of this sheet
            $options = ['valueInputOption' => self::VALUE_INPUT_OPTION];
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $valueRange, $options);
            echo 'Data sent successfully';
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function sendData(): bool
    {
        try {
            $existingData = $this->getData();

            if ($this->checkDuplicates($this->data, $existingData)) {
                throw new Exception('Duplicate entry found. Data not sent to the spreadsheet.');
            }

            $valueRange = new Google_Service_Sheets_ValueRange();
            $valueRange->setValues([$this->data]);
            $range = $this->sheetName; // the service will detect the last row of this sheet
            $options = ['valueInputOption' => self::VALUE_INPUT_OPTION];
            $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $valueRange, $options);
            echo 'Data sent successfully';
            unset($this->data);
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function checkDuplicates(array $newRows, array $existingData): bool
    {

        $isDuplicate = false;

        foreach ($existingData as $rowData) {

            // Assuming the first column contains unique identifiers
            if ($rowData[0] == $newRows[0]) {
                $isDuplicate = true;
                break;
            }

        }

        return $isDuplicate;
    }

    public function checkBatchDuplicates(array $newRows, array $existingData): bool
    {
        // Assuming the first column contains unique identifiers
        $existingIds = array_column($existingData, 0);
        $newIds = array_column($newRows, 0);

        // Check for duplicates in the new data
        foreach ($newIds as $newId) {
            if (in_array($newId, $existingIds)) {
                return true;
            }
        }

        return false;
    }

    public function updateData(array $updateRow): bool
    {
        try {
            $valueRange = new Google_Service_Sheets_ValueRange();
            $valueRange->setValues([$updateRow]);
            $range = $this->sheetName . $this->range;
            $options = ['valueInputOption' => self::VALUE_INPUT_OPTION];
            $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $valueRange, $options);
            echo 'Data updated successfully';
            unset($this->data);
            return true;
        } catch (Google_Service_Exception $e) {
            echo 'Google Service Exception: ' . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteRow(): bool
    {
        try {
            $range = $this->sheetName . '!' . $this->range; // the range to clear, the 23rd and 24th lines
            $clear = new Google_Service_Sheets_ClearValuesRequest();
            $this->service->spreadsheets_values->clear($this->spreadsheetId, $range, $clear);
            echo 'Row deleted successfully';
            return true;
        } catch (Google_Service_Exception $e) {
            echo 'Google Service Exception: ' . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage();
            return false;
        }
    }

    public function getData(): array
    {
        try {
            // assign the range you want to get
            $range = $this->sheetName . '!A1:K';
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);

            return $response->getValues();
        } catch (Google_Service_Exception $e) {
            echo 'Google Service Exception: ' . $e->getMessage();
            return [];
        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage();
            return [];
        }
    }

    protected function getRange(): string
    {
        return $this->sheetName . '!' . $this->range;
    }

}



require_once 'config.php';


$googleSheetService = new GoogleSheetService($service);


// single insert
$array = [
    "d600",
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

// $googleSheetService
//     ->setSpreadSheetId('1udSubIQrO0XQyQ7x5ZPM7tivroY9kBBxcJifbsq1PVY')
//     ->setSheet('genie-usage')
//     ->setData($array)
//     ->sendData();



// Example usage of batch insert
$array = [];
for($i = 43; $i < 50; $i++) {
    $array[] = [
        "$i",
        "100$i",
        "seo features",
        "keyword cluster",
        "getgenie?local",
        "en",
        "15$i",
        "$i",
        "$i",
        "2023-12-13 8:48:51",
        "Gelenie Free-Free"
    ];
   
}

$googleSheetService
    ->setData($array)
    ->setSpreadSheetId('1udSubIQrO0XQyQ7x5ZPM7tivroY9kBBxcJifbsq1PVY')
    ->setSheet('genie-usage')
    ->setData($array)
    ->sendBatchData();
