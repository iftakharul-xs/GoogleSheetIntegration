<?php

/*
// Example usage of batch insert
$array = [];
for($i = 33; $i < 36; $i++) {
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
->sendBatchData();
*/



//Example usage of single insert

/*
$data = [
    "5600",
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
    ->setData($data)
    ->sendData();
*/



/**
 * Delete row
 */

 // Set the range to delete, for example, delete row 23
// $googleSheetService->setRange('23:28');

// // Call the deleteRow method
// $result = $googleSheetService->deleteRow();

// if ($result) {
//     echo 'Row deleted successfully.';
// } else {
//     echo 'Failed to delete row.';
// }


/**
 * Update row
 */


 /*
 // Define the data to update
$updateData = [
    "5600",
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
    // Add more updated values as needed
];

// Set the range where you want to update the data, for example, update row 5
$googleSheetService->setRange('!5:5');

// Call the updateData method
$result = $googleSheetService->updateData($updateData);

if ($result) {
    echo 'Data updated successfully.';
} else {
    echo 'Failed to update data.';
}*/