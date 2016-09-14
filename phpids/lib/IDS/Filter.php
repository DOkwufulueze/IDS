<?php

class IDS_Filter
{

    /**
     * Filter rule
     *
     * @var    string
     */
    protected $rule;

    /**
     * List of tags of the filter
     *
     * @var    array
     */
    protected $tags = array();

    /**
     * Filter impact level
     *
     * @var    integer
     */
    protected $impact = 0;

    /**
     * Filter description
     *
     * @var    string
     */
    protected $description = null;

    /**
     * Constructor
     *
     * @param integer $id          filter id
     * @param mixed   $rule        filter rule
     * @param string  $description filter description
     * @param array   $tags        list of tags
     * @param integer $impact      filter impact level
     * 
     * @return void
     */
    public function __construct($id, $rule, $description, array $tags, $impact) 
    {
        $this->id          = $id;
        $this->rule        = $rule;
        $this->tags        = $tags;
        $this->impact      = $impact;
        $this->description = $description;
    }

    /**
     * Matches a string against current filter
     *
     * Matches given string against the filter rule the specific object of this
     * class represents
     *
     * @param string $string the string to match
     * 
     * @throws InvalidArgumentException if argument is no string
     * @return boolean
     */
    public function match($string)
    {
        if (!is_string($string)) {
            throw new InvalidArgumentException('
                Invalid argument. Expected a string, received ' . gettype($string)
            );
        }

        return (bool) preg_match(
            '/' . $this->getRule() . '/ms', strtolower($string)
        );
    }

    /**
     * Returns filter description
     *
     * @return string
     */
    public function getDescription() 
    {
        return $this->description;
    }

    /**
     * Return list of affected tags
     *
     * Each filter rule is concerned with a certain kind of attack vectors. 
     * This method returns those affected kinds.
     *
     * @return array
     */
    public function getTags() 
    {
        return $this->tags;
    }

    /**
     * Returns filter rule
     *
     * @return string
     */
    public function getRule() 
    {
        return $this->rule;
    }

    /**
     * Get filter impact level
     *
     * @return integer
     */
    public function getImpact() 
    {
        return $this->impact;
    }
    
    /**
     * Get filter ID
     *
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }
}