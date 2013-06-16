<?php

class model {
    public $_id = null;
    public $_fields;

    public $_cache = array();

    public function __construct($id=null){
        if(! isset($this->_fields) || ! is_array($this->_fields)) $this->_fields = array();
        if(!isset($id)) return;
        $this->_id = $id;

        if(isset($this->_cache[$this->_id]))
            return $this->_cache[$this->_id];

        $_fields_string = implode(',', array_keys($this->_fields));
        $result = $GLOBALS['db']->select('SELECT id, '.$_fields_string.' FROM '.$this->table.' WHERE id = :id', array(':id' => $id));
        if(isset($result[0])){
            foreach($this->_fields as $key => $value){
                $this->_fields[$key] = $result[0][$key];
            }
        }else{
            error_log('No object at '.$this->table.' '.$id);
            log_trace();
            $this->_id = null;
            return;
        }
        $this->_cache[$this->_id] = $this;
    }

    public function __get($key){
        if(method_exists($this, $key)) return $this->$key();
        return $this->_fields[$key];
    }

    public function __set($key, $value){
        if(method_exists($this, $key)) $this->$key($value);
        else $this->_fields[$key] = $value;
    }

    public function __isset($key){
        return isset($this->_fields[$key]);
    }

    public function save(){
        if($this->_id){
            $this->_fields['modified'] = time();
            $GLOBALS['db']->update($this->table, $this->_fields, "`id` = {$this->_id}");
        }else{
            $this->_fields['modified'] = time();
            $this->_fields['added'] = time();
            $GLOBALS['db']->insert($this->table, $this->_fields);
            $this->_id = $GLOBALS['db']->lastInsertId();
        }

        $this->_cache[$this->_id] = $this;

    }

    public function delete(){
        $GLOBALS['db']->delete($this->table, "`id` = {$this->_id}"); 
        unset($this->_cache[$this->_id]);
    }

}