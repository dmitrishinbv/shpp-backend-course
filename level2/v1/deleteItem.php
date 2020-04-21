<?php
$jsonFile = 'todo.json';
$input = json_decode(file_get_contents("php://input"), true);
$errorStatuses = ["500 Internal Server Error", "400 Bad Request"];

$data = checkInfo($jsonFile, $input, $errorStatuses);

deleteItem($jsonFile, $data, $input, $errorStatuses);

function checkInfo($jsonFile, $input, $errorStatuses)
{
    $data = readJson($jsonFile);

    if ($data && $input) {
        $data = json_decode($data, true);

        if (!isset ($input["id"]) || !is_numeric((int) ($input["id"]))) {
            showResult($errorStatuses[1]);
        }

    } else {
        showResult($errorStatuses[0]);
    }

    return $data;
}


function readJson($jsonFile)
{
    return (is_readable($jsonFile) && is_writable($jsonFile)) ? file_get_contents($jsonFile)  : false;
}


function deleteItem($jsonFile, $data, $input, $errorStatuses)
{
    $id = $input["id"];
    $foundItem = false;

    if (count($data["items"]) > 1) {
        foreach ($data["items"] as $arr) {
            if ($arr["id"] == $id) {
                $foundItem = true;
                continue;
            } else {
                $newArray[] = $arr;
            }
        }

        if ($foundItem) {
            $newArray = ["items" => $newArray];
            file_put_contents($jsonFile, json_encode($newArray));
            exit(json_encode(["ok" => true]));

        } else {
            showError ($errorStatuses[1]);
        }
    }

    else {
        if ($data["items"][0]["id"] === $id) {
            $newArray = ["items" => []];
            file_put_contents($jsonFile, json_encode($newArray));
            exit(json_encode(["ok" => true]));
        }

        else {
            showError ($errorStatuses[1]);
        }
    }
}


function showError ($message) {
     exit(json_encode(["error" => $message]));
}
?>