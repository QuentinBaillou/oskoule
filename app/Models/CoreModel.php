<?php

namespace App\Models;

abstract class CoreModel
{
    protected $id;
    protected $status;
    protected $created_at;
    protected $updated_at;

    public function save()
    {
        if (isset($this->id) && $this->id > 0) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    abstract public function create();
    abstract public function update();
    abstract public function delete();

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     */
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
