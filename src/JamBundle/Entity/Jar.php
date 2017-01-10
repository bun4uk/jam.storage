<?php
/**
 * Created by PhpStorm.
 * User: v.bunchuk
 * Date: 23/09/2016
 * Time: 14:20
 */

namespace JamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JamBundle\Entity\Year;
use JamBundle\Entity\Type;

/**
 * @ORM\Entity
 * @ORM\Table(name="jar")
 */
class Jar
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="Type", cascade={"persist"})
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @var Year
     *
     * @ORM\ManyToOne(targetEntity="Year", cascade={"persist"})
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id", nullable=false)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="comment",
     *     type="text"
     * )
     */
    private $comment;

    /**
     * @var int
     */
    private $amount;

    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Jar
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set type
     *
     * @param Type $type
     *
     * @return Jar
     */
    public function setType(Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set year
     *
     * @param Year $year
     *
     * @return Jar
     */
    public function setYear(Year $year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set amount
     *
     * @param int $amount
     *
     * @return Jar
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
