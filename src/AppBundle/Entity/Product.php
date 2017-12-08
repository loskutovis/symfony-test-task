<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class for table Product
 *
 * @ORM\Table(name="tblProductData", uniqueConstraints={@ORM\UniqueConstraint(name="strProductCode", columns={"strProductCode"})})
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer MAX_PRICE
     * @var integer MIN_STOCK
     * @var integer MIN_PRICE
     */
    const MAX_PRICE = 1000;
    const MIN_PRICE = 5;
    const MIN_STOCK = 10;
    const DISCOUNTED = 'yes';

    /**
     * @var array
     */
    private $dataFromFile;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private $added;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $discontinued;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stmTimestamp", type="datetime", nullable=false, columnDefinition="DATETIME on update CURRENT_TIMESTAMP")
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="intProductDataId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     * @ORM\Column(name="intStock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     * @ORM\Column(name="floatCostInGBP", type="float", nullable=false)
     */
    private $price;

    /**
     * Product constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->dataFromFile = $values;

        $this->stock = $this->setFieldValue('Stock');
        $this->price = $this->setFieldValue('Cost in GBP');
        $this->code = $this->setFieldValue('Product Code');
        $this->name = $this->setFieldValue('Product Name');
        $this->description = $this->setFieldValue('Product Description');
        $this->discontinued = $this->setFieldValue('Discontinued');
        $this->added = new DateTime();
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     * @param $payload
     */
    public function validate(ExecutionContextInterface $context, $payload) {
        if (strtolower($this->discontinued) === Product::DISCOUNTED) {
            $this->discontinued = new DateTime();
        }

        if ((float) $this->price > Product::MAX_PRICE || ((float) $this->price < Product::MIN_PRICE &&
                (int) $this->stock < Product::MIN_STOCK)) {
            $context->buildViolation('Wrong stock and price values')
                ->addViolation();
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    private function setFieldValue(string $key)
    {
      return key_exists($key, $this->dataFromFile) ? $this->dataFromFile[$key] : null;
    }
}

