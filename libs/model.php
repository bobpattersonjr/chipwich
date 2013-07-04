<?php

class model {
    public $_id = null;
    public $_fields;

    public static $_cache = array();

    public function __construct($id=null){
        if(! isset($this->_fields) || ! is_array($this->_fields)) $this->_fields = array();
        if(!isset($id)) return;
        $this->_id = $id;

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
        static::$_cache[get_called_class()][$this->_id] = $this;
    }

    public static function get_obj($id=null){
        if(! isset($id)) return null;

        if(isset(self::$_cache[get_called_class()]) && array_key_exists($id, self::$_cache[get_called_class()]) && self::$_cache[get_called_class()][$id] != null){
            return self::$_cache[get_called_class()][$id];
        }
        $class = get_called_class();
        $obj = new $class($id);
        if($obj)
            self::$_cache[get_called_class()][$id] = $obj;
        return $obj;
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

        static::$_cache[get_called_class()][$this->_id] = $this;

    }

    public function delete(){
        $GLOBALS['db']->delete($this->table, "`id` = {$this->_id}"); 
        unset(static::$_cache[get_called_class()][$this->_id]);
    }

}