<?php

class ProductGateway
{
    private $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function insertProduct($name, $description, $price, $image)
    {
        $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";

        if ($this->conn->query($sql)) {
            return array('success' => true);
        } else {
            return array('success' => false, 'errors' => array("Error: " . $sql . "<br>" . mysqli_error($this->conn)));
        }
    }

    public function getProduct($id)
    {
        $result = $this->conn->query("SELECT * FROM products WHERE id=$id");

        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return array('message' => 'No product found with the given id.');
        }
    }

    public function getAllProducts()
    {
        $result = $this->conn->query("SELECT * FROM products");

        $products = array();

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public function updateProduct($id, $name, $description, $price, $image)
    {
        $query = "UPDATE products SET name='$name', description='$description', price='$price', image='$image' WHERE id=$id";

        if ($this->conn->query($query)) {
            return array('success' => true);
        } else {
            return array('success' => false, 'errors' => array("Error: " . $query . "<br>" . mysqli_error($this->conn)));
        }
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id='$id'";

        if ($this->conn->query($sql)) {
            return array('success' => true);
        } else {
            return array('success' => false, 'message' => "Error: " . $sql . "<br>" . mysqli_error($this->conn));
        }
    }
}











