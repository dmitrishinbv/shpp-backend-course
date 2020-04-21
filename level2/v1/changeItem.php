<?php
$jsonFile = 'todo.json';
$input = json_decode(file_get_contents("php://input"), true);
$errorStatuses = ["500 Internal Server Error", "400 Bad Request"];

$data = checkInputInfo($jsonFile, $input, $errorStatuses);
changeItem($jsonFile, $data, $input, $errorStatuses);

function checkInputInfo($jsonFile, $input, $errorStatuses)
{
    $data = readJson($jsonFile);

    if ($data && $input) {
        $data = json_decode($data, true);

        if (!isset ($input["text"]) || !isset ($input["id"]) || !isset ($input["checked"])) {
            showError($errorStatuses[1]);
        }


    } else {
        showError($errorStatuses[1]);
    }

    return $data;
}


function readJson($jsonFile)
{
    return (is_readable($jsonFile) && is_writable($jsonFile)) ? file_get_contents($jsonFile)  : false;
}


function changeItem($jsonFile, $data, $item, $errorStatuses)
{
    $itemsArray = $data['items'];

    for ($i = 0; $i < count($itemsArray); $i++) {
        $currentItem = $itemsArray[$i];

        if ($currentItem["id"] == $item["id"]) {
            $itemsArray[$i] = ["id" => $item["id"], "text" => $item["text"], "checked" => $item["checked"]];
            $itemsArray = ["items" => $itemsArray];
            $data = json_encode($itemsArray);
            file_put_contents($jsonFile, $data);
            exit(json_encode(["ok" => true]));
        }
    }
    showError($errorStatuses[1]);
}


function showError($message)
{
    header("HTTP/1.1 $message");
    die (json_encode(['error' => $message]));
}
?>