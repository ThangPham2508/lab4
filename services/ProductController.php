<?php
class ProductController
{
    private $gateway;

    public function __construct(ProductGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function processRequest(string $method, ?string $id)
    {
        if ($id) {
            $this->processResourceRequest($method, $id);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id): void
    {
        $product = $this->gateway->getProduct($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode(["message" => "Product not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($product);
                break;

            case "PUT":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data, false);

                if (empty($errors)) {
                    $result = $this->gateway->updateProduct($id, $data['name'], $data['description'], $data['price'], $data['image']);
                    echo json_encode($result);
                } else {
                    echo json_encode(array('success' => false, 'errors' => $errors));
                }
                break;

            case "DELETE":
                $result = $this->gateway->deleteProduct($id);
                echo json_encode($result);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, PUT, DELETE");
        }
    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->gateway->getAllProducts());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if (empty($errors)) {
                    $result = $this->gateway->insertProduct($data['name'], $data['description'], $data['price'], $data['image']);
                    echo json_encode($result);
                } else {
                    echo json_encode(array('success' => false, 'errors' => $errors));
                }
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    private function getValidationErrors($data, $isNew = true)
    {
        $errors = [];

        if ($isNew || isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 5 || strlen($name) > 40) {
                $errors[] = "Name must be between 5 and 40 characters.";
            }
        }

        if ($isNew || isset($data['description'])) {
            $description = $data['description'];
            if (strlen($description) > 5000) {
                $errors[] = "Description cannot exceed 5000 characters.";
            }
        }

        if ($isNew || isset($data['price'])) {
            $price = $data['price'];
            if (!is_numeric($price) || $price <= 0) {
                $errors[] = "Price must be a real number.";
            }
        }

        if ($isNew || isset($data['image'])) {
            $image = $data['image'];
            if (strlen($image) > 255) {
                $errors[] = "Image URL cannot exceed 255 characters.";
            }
        }

        return $errors;
    }
}
?>