<?php

namespace App\Entity;

class UserSearch
{
    /**
     * var string|null
     */
    private $team;

    /**
     * var string|null
     */
    private $libre;

    /**
     * var string|null
     */
    private $category;

    /**
     * Get var string|null
     */ 
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set var string|null
     *
     * @return  self
     */ 
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get var string|null
     */ 
    public function getLibre()
    {
        return $this->libre;
    }

    /**
     * Set var string|null
     *
     * @return  self
     */ 
    public function setLibre($libre)
    {
        $this->libre = $libre;

        return $this;
    }

    /**
     * Get var string|null
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set var string|null
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
}