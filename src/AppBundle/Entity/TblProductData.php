<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Class for table TblProductData
 *
 * @ORM\Table(name="tblProductData", uniqueConstraints={@ORM\UniqueConstraint(name="strProductCode", columns={"strProductCode"})})
 * @ORM\Entity
 */
class TblProductData
{
    /**
     * @var int MAX_COST
     * @var int MIN_COST
     * @var int MIN_STOCK
     * @var string DISCONTINUED
     */
    const MAX_COST = 1000;
    const MIN_COST = 5;
    const MIN_STOCK = 10;
    const DISCONTINUED = 'yes';

    /**
     * @var string
     *
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     */
    private $strProductName;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    private $strProductDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private $strProductCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private $dtmAdded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $dtmDiscontinued;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stmTimestamp", type="datetime", nullable=false, columnDefinition="DATETIME on update CURRENT_TIMESTAMP")
     */
    private $stmTimestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="intProductDataId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $intProductDataId;

    /**
     * @var integer
     *
     * @ORM\Column(name="intStock", type="integer", nullable=false)
     */
    private $intStock;

    /**
     * @var float
     *
     * @ORM\Column(name="floatCostInGBP", type="float", nullable=false)
     */
    private $floatCostInGBP;

    /**
     * @return string
     */
    public function getStrProductName(): string
    {
        return $this->strProductName;
    }

    /**
     * @param string $strProductName
     * @throws Exception
     * @return $this
     */
    public function setStrProductName(string $strProductName): self
    {
        $this->checkValue($strProductName);

        $this->strProductName = $strProductName;

        return $this;
    }

    /**
     * @return string
     */
    public function getStrProductDesc(): string
    {
        return $this->strProductDesc;
    }

    /**
     * @param string $strProductDesc
     * @throws Exception
     * @return $this
     */
    public function setStrProductDesc(string $strProductDesc): self
    {
        $this->checkValue($strProductDesc);

        $this->strProductDesc = $strProductDesc;

        return $this;
    }

    /**
     * @return string
     */
    public function getStrProductCode(): string
    {
        return $this->strProductCode;
    }

    /**
     * @param string $strProductCode
     * @throws Exception
     * @return $this
     */
    public function setStrProductCode(string $strProductCode): self
    {
        $this->checkValue($strProductCode);

        $this->strProductCode = $strProductCode;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtmAdded(): \DateTime
    {
        return $this->dtmAdded;
    }

    /**
     * @return $this
     */
    public function setDtmAdded(): self
    {
        $this->dtmAdded = new \DateTime();

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtmDiscontinued(): \DateTime
    {
        return $this->dtmDiscontinued;
    }

    /**
     * @param \DateTime $dtmDiscontinued
     * @return $this
     */
    public function setDtmDiscontinued(string $dtmDiscontinued): self
    {
        if (strtolower($dtmDiscontinued) === self::DISCONTINUED) {
            $this->dtmDiscontinued = new \DateTime();
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getIntProductDataId(): int
    {
        return $this->intProductDataId;
    }

    /**
     * @return int
     */
    public function getIntStock(): int
    {
        return $this->intStock;
    }

    /**
     * @param mixed $intStock
     * @throws Exception
     * @return $this
     */
    public function setIntStock($intStock): self
    {
        if ($intStock !== '0') {
            $this->checkValue($intStock);
        }

        $this->intStock = (int) $intStock;

        return $this;
    }

    /**
     * @return float
     */
    public function getFloatCostInGBP(): float
    {
        return $this->floatCostInGBP;
    }

    /**
     * @param float $floatCostInGBP
     * @throws Exception
     * @return $this
     */
    public function setFloatCostInGBP(float $floatCostInGBP)
    {
        $this->checkValue($floatCostInGBP);

        $this->floatCostInGBP = $floatCostInGBP;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStmTimestamp(): \DateTime
    {
        return $this->stmTimestamp;
    }

    /**
     * @param array $fields
     * @return TblProductData|bool
     */
    public static function loadFields(array $fields)
    {
        $productData = new static();

        try {
            $productData->setIntStock($fields['Stock'])
                ->setFloatCostInGBP((float) $fields['Cost in GBP'])
                ->setStrProductDesc($fields['Product Description'])
                ->setDtmDiscontinued($fields['Discontinued'])
                ->setStrProductCode($fields['Product Code'])
                ->setStrProductName($fields['Product Name'])
                ->setDtmAdded();
        } catch (Exception $e) {
            return null;
        }

        return $productData;
    }

    /**
     * Checks if price and stock meet the requirements
     *
     * @var float $price
     * @var integer $stock
     * @var bool $result
     * @return bool
     */
    public function checkProductData(): bool
    {
        $price = $this->getFloatCostInGBP();
        $stock = $this->getIntStock();
        $result = false;

        if (isset($price) && isset($stock)
            && !($price > self::MAX_COST || ($price < self::MIN_COST && $stock < self::MIN_STOCK))) {
            $result = true;
        }

        return $result;
    }

    /**
     * @param mixed $value
     * @throws Exception
     */
    public function checkValue($value) {
        if (empty($value)) {
            throw new Exception('Empty value');
        }
    }
}

