<?php

class FlowerController extends BaseController
{

    /**
     * "/flowers/list" Endpoint - Get list of flowers
     */
    public function listAction(): void
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $flowerModel = new FlowerModel();

                $intLimit = 20;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }

                $arrFlowers = $flowerModel->getFlowers($intLimit);
                $responseData = json_encode($arrFlowers);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong!Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            } catch (Exception $e) {

                echo "Exception throw at database" . $e->getMessage() . $e->getCode();
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (!$strErrorDesc) {
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader));
        }
    }


    /**
     * "/flowers/add" Endpoint - Get list of flowers
     */
    public function addAction(): void
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrRequestBody = $this->getRequestBody();

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $flowerModel = new FlowerModel();

                if (isset($arrRequestBody['name']) &&
                    isset($arrRequestBody['description']) &&
                    isset($arrRequestBody['price']) &&
                    isset($arrRequestBody['available_quantity']) &&
                    isset($arrRequestBody['difficulty']) &&
                    isset($arrRequestBody['flower_images']) &&
                    isset($arrRequestBody['user_id'])) {

                    $flowerData = ['name' => $arrRequestBody['name'],
                        'description' => $arrRequestBody['description'],
                        'price' => $arrRequestBody['price'],
                        'available_quantity' => $arrRequestBody['available_quantity'],
                        'difficulty' => $arrRequestBody['difficulty'],
                        'flower_images' => $arrRequestBody['flower_images'],
                        'user_id' => $arrRequestBody['user_id']
                    ];

                    $flowerModel->addFlower($flowerData);

                    $responseData = json_encode(['message' => 'Flower added successfully']);
                } else {
                    throw new Exception('Required fields missing');
                }
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]),
                ['Content-Type: application/json', $strErrorHeader]);
        }
    }


    /**
     * @throws Exception
     */
    public function updateAction(): void
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrRequestBody = $this->getRequestBody();

        if (strtoupper($requestMethod) == 'PUT') {
            try {
                $flowerModel = new FlowerModel();

                if (isset($arrRequestBody['id']) &&
                    isset($arrRequestBody['name']) &&
                    isset($arrRequestBody['description']) &&
                    isset($arrRequestBody['price']) &&
                    isset($arrRequestBody['available_quantity']) &&
                    isset($arrRequestBody['difficulty'])) {

                    $flowerData = [
                        'id' => $arrRequestBody['id'],
                        'name' => $arrRequestBody['name'],
                        'description' => $arrRequestBody['description'],
                        'price' => $arrRequestBody['price'],
                        'available_quantity' => $arrRequestBody['available_quantity'],
                        'difficulty' => $arrRequestBody['difficulty']
                    ];

                    $flowerModel->updateFlower($flowerData);

                    $responseData = json_encode(['message' => 'Flower updated successfully']);
                } else {
                    throw new Exception('Required fields missing');
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong!Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]),
                ['Content-Type: application/json', $strErrorHeader]);
        }
    }


    /**
     * @throws Exception
     */
    public function deleteAction(): void
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'DELETE') {
            try {
                $flowerModel = new FlowerModel();

                if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                    $flowerId = $arrQueryStringParams['id'];
                } else {
                    throw new Exception('Required fields missing');
                }

                $flowerModel->deleteFlower($flowerId);

                $responseData = json_encode(['message' => 'Flower deleted successfully']);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong!Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
        } else {
            $this->sendOutput(json_encode(['error' => $strErrorDesc]),
                ['Content-Type: application/json', $strErrorHeader]);
        }
    }
}

