<?php


abstract class Product
{
    // Common properties
    protected $id;
    protected $name;
    protected $price;

    // Constructor
    public function __construct() {
    }

    // Common functions
    // CRUD
    public abstract function add();
    public abstract function edit();
    public abstract function details();
    public abstract function delete();
    public static abstract function toList();

    // Gets; Sets
    public abstract function setName($name);
    public abstract function setPrice($price);
    public abstract function setId($id);
    public abstract function getName();
    public abstract function getPrice();
    public abstract function getId();

    // Convert
    public abstract function convertToObjectClass($object);
}
?>